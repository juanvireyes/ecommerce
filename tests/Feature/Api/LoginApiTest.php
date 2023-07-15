<?php

namespace Api;

use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    public Role $superadmin;
    public Role $admin;
    public Role $client;
    public User $user;


    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $this->superadmin = Role::where('name', 'superadmin')->first();
        $this->admin = Role::where('name', 'admin')->first();
        $this->client = Role::where('name', 'client')->first();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function superadmin_can_get_token(): void
    {
        $this->user->assignRole($this->superadmin);
        $this->assertTrue($this->user->hasRole($this->superadmin));

        $this->actingAs($this->user)->post(route('user.token'), [
            'email' => $this->user->email,
            'password' => 'password'
        ], ['accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonMissingValidationErrors('email', 'password')
            ->assertJsonStructure([
                'access_token'
            ]);
    }

    /** @test */
    public function admin_can_get_token(): void
    {
        $this->user->assignRole($this->admin);
        $this->assertTrue($this->user->hasRole($this->admin));

        $this->actingAs($this->user)->post(route('user.token'), [
            'email' => $this->user->email,
            'password' => 'password'
        ], ['accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonMissingValidationErrors('email', 'password')
            ->assertJsonStructure([
                'access_token'
            ]);
    }

    /** @test */
    public function client_cant_get_token(): void
    {
        $this->user->assignRole($this->client);
        $this->assertTrue($this->user->hasRole($this->client));

        $this->actingAs($this->user)->post(route('user.token'), [
            'email' => $this->user->email,
            'password' => 'password'
        ], ['accept' => 'application/json'])
            ->assertStatus(403)
            ->assertJsonMissingValidationErrors('email', 'password')
            ->assertJsonStructure([
                'Error'
            ]);
    }

    /** @test */
    public function user_cant_get_token_with_invalid_credentials(): void
    {
        $this->user->assignRole($this->superadmin);
        $this->assertTrue($this->user->hasRole($this->superadmin));

        $this->actingAs($this->user)->postJson(route('user.token'), [
            'email' => $this->user->email,
            'password' => '12345'
        ], ['accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJsonMissingValidationErrors('email', 'password')
            ->assertJsonStructure([
                'Error'
            ]);
    }
}
