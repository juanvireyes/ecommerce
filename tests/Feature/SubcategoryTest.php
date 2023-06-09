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
    
    private User $user;
    private Role $admin_role;
    private Role $superadmin_role;
    private Role $client_role;
    private Category $category;
    private int $categoryId;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->admin_role = Role::where('name', 'admin')->first(); // @phpstan ignore-line
        $this->superadmin_role = Role::where('name', 'superadmin')->first(); // @phpstan ignore-line
        $this->client_role = Role::where('name', 'client')->first(); // @phpstan ignore-line

        $this->user = User::factory()->create();

        $this->category = Category::factory()->create()->id();
        $this->categoryId = $this->category->id;
    }

    public function test_ssubcategories_index_page_can_be_rendered_as_admin(): void
    {
        $this->user->assignRole($this->admin_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->admin_role)); // @phpstan ignore-line

        $this->actingAs($this->user);

        $response = $this->get(route('subcategories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.index');
    }

    public function test_subcategories_index_page_can_be_rendered_as_superadmin(): void
    {
        $this->user->assignRole($this->superadmin_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->superadmin_role)); // @phpstan ignore-line

        $this->actingAs($this->user);

        $response = $this->get(route('subcategories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.index');
    }

    public function test_subcategories_index_page_cant_be_rendered_as_client(): void
    {
        $this->user->assignRole($this->client_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->client_role)); // @phpstan ignore-line

        $this->actingAs($this->user);

        $response = $this->get(route('subcategories.index'));

        $response->assertStatus(403);
    }

    public function test_create_subcategory_page_can_be_rendered_as_admin(): void
    {
        $this->user->assignRole($this->admin_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->admin_role)); // @phpstan ignore-line

        $this->actingAs($this->user);

        $response = $this->get(route('subcategories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.create');
    }

    public function test_create_subcategory_page_can_be_rendered_as_superadmin(): void
    {
        $this->user->assignRole($this->superadmin_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->superadmin_role)); // @phpstan ignore-line

        $this->actingAs($this->user);

        $response = $this->get(route('subcategories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('subcategories.create');
    }

    public function test_create_subcategory_page_cant_be_rendered_as_client(): void
    {
        $this->user->assignRole($this->client_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->client_role)); // @phpstan ignore-line

        $this->actingAs($this->user);

        $response = $this->get(route('subcategories.create'));

        $response->assertStatus(403);
    }

    public function test_subcategory_can_be_created_as_admin(): void
    {
        $this->user->assignRole($this->admin_role); // @phpstan ignore-line

        $this->assertTrue($this->user->hasRole($this->admin_role)); // @phpstan ignore-line

        $this->actingAs($this->user);
        
        $file = UploadedFile::fake()->image('image.jpg');
        
        $response = $this->post(route('subcategory.store'), [
            'name' => 'Test Subcategory',
            'slug' => 'test-subcategory',
            'description' => 'test',
            'image' => $file,
            'order' => 1,
            'category_id' => $this->categoryId,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('subcategories.index'));

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Test Subcategory',
            'slug' => 'test-subcategory',
            'description' => 'test',
            'order' => 1,
            'category_id' => $this->categoryId,
        ]);
    }
}
