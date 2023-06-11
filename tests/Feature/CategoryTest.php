<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Database\Seeders\RolesSeeder;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Role $admin_role;
    private Role $superadmin_role;
    private Role $client_role;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->admin_role = Role::where('name', 'admin')->first(); // @phpstan ignore-line
        $this->superadmin_role = Role::where('name', 'superadmin')->first(); // @phpstan ignore-line
        $this->client_role = Role::where('name', 'client')->first(); // @phpstan ignore-line

        $this->user = User::factory()->create();
    }
    
    public function test_categories_list_page_loads_successfully_for_admin(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));

        $this->actingAs($this->user);

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
    }

    public function test_categories_list_page_loads_successfully_for_superadmin(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));

        $this->actingAs($this->user);

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
    }

    public function test_user_can_see_create_category_page_as_admin(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));

        $this->actingAs($this->user);

        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);

        $response->assertViewIs('categories.category-form');
    }

    public function test_user_can_see_category_page_as_superadmin(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));

        $this->actingAs($this->user);

        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);

        $response->assertViewIs('categories.category-form');
    }

    public function test_user_cant_see_create_category_page_as_client(): void
    {
        $role = $this->client_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));

        $this->actingAs($this->user);

        $response = $this->get(route('categories.create'));
        $response->assertStatus(403);
    }

    public function test_user_can_create_category_as_admin(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('image.jpg');

        $response = $this->post(route('category.store'), [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
            'image' => $file
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
        ]);
    }

    public function test_user_can_create_category_as_superadmin(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('image.jpg');

        $response = $this->post(route('category.store'), [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
            'image' => $file
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
        ]);
    }

    public function test_category_cant_be_created_without_name(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('image.jpg');

        $response = $this->post(route('category.store'), [
            'name' => '',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
            'image' => $file
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function test_category_cant_be_created_with_non_accepted_image_format(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('image.pdf');

        $response = $this->post(route('category.store'), [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
            'image' => $file
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('image');
    }

    public function test_category_can_be_created_without_image(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $response = $this->post(route('category.store'), [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
            'image' => null
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
            'order' => 6,
        ]);
    }

    public function test_category_can_be_deleted_as_admin(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $category = Category::factory()->create();

        // @phpstan-ignore-next-line
        $response = $this->delete(route('categories.destroy', $category->id));

        // @phpstan-ignore-next-line
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
    }

    public function test_category_can_be_deleted_as_superadmin(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role->name));
        $this->actingAs($this->user);

        $category = Category::factory()->create();

        // @phpstan-ignore-next-line
        $response = $this->delete(route('categories.destroy', $category->id));

        // @phpstan-ignore-next-line
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
    }
}
