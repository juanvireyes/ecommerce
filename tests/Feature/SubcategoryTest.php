<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Database\Seeders\PermissionsSeeder;
use Spatie\Permission\Contracts\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubcategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_ssubcategories_index_page_can_be_rendered_as_admin(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'admin')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('subcategories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.index');
    }

    public function test_subcategories_index_page_can_be_rendered_as_superadmin(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'superadmin')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('subcategories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.index');
    }

    public function test_subcategories_index_page_cant_be_rendered_as_client(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'client')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('subcategories.index'));

        $response->assertStatus(403);
    }

    public function test_create_subcategory_page_can_be_rendered_as_admin(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'admin')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('subcategories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.create');
    }

    public function test_create_subcategory_page_can_be_rendered_as_superadmin(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'superadmin')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('subcategories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.create');
    }

    public function test_create_subcategory_page_cant_be_rendered_as_client(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'client')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('subcategories.create'));

        $response->assertStatus(403);
    }

    public function test_subcategory_can_be_created_as_admin(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $role = Role::where('name', 'admin')->first();

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('image.jpg');
        $category = Category::factory()->create();
        $response = $this->post(route('subcategory.store'), [
            'name' => 'Test Subcategory',
            'slug' => 'test-subcategory',
            'description' => 'test',
            'image' => $file,
            'order' => 1,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('subcategories.index'));

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Test Subcategory',
            'slug' => 'test-subcategory',
            'description' => 'test',
            'order' => 1,
            'category_id' => $category->id,
        ]);
    }
}
