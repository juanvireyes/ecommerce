<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
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
}
