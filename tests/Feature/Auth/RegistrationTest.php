<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('userRegisterLayout');
    }

    public function test_new_users_can_register_as_clients(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Testing',
            'last_name' => 'User',
            'name' => 'Testing User',
            'id_number' => '1234567890',
            'email' => 'testinguser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cellphone' => '1234567890',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'Massachussets',
            'country' => 'USA',
            'is_active' => true
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('user-dashboard');
    }

    public function test_superadmin_registration_form_can_be_rendered(): void
    {
        $response = $this->get(route('saregister'));

        $response->assertStatus(200);
        $response->assertViewIs('userRegisterLayout');
    }

    public function test_new_users_can_register_as_superadmin(): void
    {
        $role = Role::where('name', 'superadmin')->first();
        $response = $this->post(route('saregister'), [
            'first_name' => 'Superadmin',
            'last_name' => 'Test',
            'name' => 'Superadmin Test',
            'id_number' => '1234567890',
            'email' => 'superadmin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cellphone' => '+571234567890',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'Massachussets',
            'country' => 'USA',
            'is_active' => true
        ]);

        $this->assertAuthenticated();

        $response->assertStatus(302);
        $response->assertRedirect('user-dashboard');

        $user = User::where('email', 'superadmin@example.com')->first();
        $this->assertTrue($user->hasRole($role->name));
    }

    public function tests_admin_admin_registration_form_can_be_rendered(): void
    {
        $response = $this->get(route('adminregister'));

        $response->assertStatus(200);

        $response->assertViewIs('userRegisterLayout');
    }

    public function test_new_users_can_register_as_admin(): void
    {
        $role = Role::where('name', 'admin')->first();

        $response = $this->post(route('adminregister'), [
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'name' => 'Admin Test',
            'id_number' => '2345678900',
            'email' => 'admintest@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cellphone' => '+571234567890',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'state' => 'Massachussets',
            'country' => 'USA',
            'is_active' => true
        ]);

        $this->assertAuthenticated();

        $response->assertStatus(302);

        $response->assertRedirect('user-dashboard');

        $user = User::where('email', 'admintest@example.com')->first();
        $this->assertTrue($user->hasRole($role->name));
    }
}
