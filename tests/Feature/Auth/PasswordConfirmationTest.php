<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordConfirmationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $this->seed(RolesSeeder::class);
        $role = Role::where('name', 'client')->first();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $this->seed(RolesSeeder::class);
        $role = Role::where('name', 'client')->first();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $this->seed(RolesSeeder::class);
        $role = Role::where('name', 'client')->first();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
