<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertViewIs('auth.login');
    }

    public function test_clients_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();
        $rol = Role::where('name', 'client')->first();

        $user->assignRole($rol);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue($user->hasRole('client'));
    }

    public function test_admins_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();
        $rol = Role::where('name', 'admin')->first();

        $user->assignRole($rol);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_superadmin_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();
        $rol = Role::where('name', 'superadmin')->first();

        $user->assignRole($rol);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue($user->hasRole('superadmin')); 
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $rol = Role::where('name', 'client')->first();

        $user->assignRole($rol);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
