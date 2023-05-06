<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_home_page_can_be_rendered_for_non_logged_in_users(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home.index');
    }

    public function test_home_page_can_be_rendered_for_logged_users_with_a_different_route(): void
    {
        $this->seed(RolesSeeder::class);
        $role = Role::where('name', 'client')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role->name));

        $this->actingAs($user);

        $response = $this->get(route('clients.index'));
        $response->assertStatus(200);
        $response->assertViewIs('clients.categories');
    }
}
