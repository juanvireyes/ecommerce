<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Database\Seeders\RolesSeeder;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Database\Seeders\PermissionsSeeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Role $admin_role;
    private Role $superadmin_role;
    private Role $client_role;
    private Category $category;
    private int $subcategoryId;
    private Product $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->admin_role = Role::where('name', 'admin')->first(); // @phpstan ignore-line
        $this->superadmin_role = Role::where('name', 'superadmin')->first(); // @phpstan ignore-line
        $this->client_role = Role::where('name', 'client')->first(); // @phpstan ignore-line

        $this->user = User::factory()->create();

        $categoryId = Category::factory()->create()->id;

        $this->subcategoryId = Subcategory::factory()->create(['category_id' => $categoryId])->id;

        $this->product = Product::factory()->create(['subcategory_id' => $this->subcategoryId]);
    }

    public function test_admin_can_see_products_list(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_superadmin_can_see_products_list(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_client_cannot_see_management_products_list(): void
    {
        $role = $this->client_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);
        
        $response = $this->get(route('products.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_see_product_create_form(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_superadmin_can_see_product_create_form(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_client_cannot_see_product_create_form(): void
    {
        $role = $this->client_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.create'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_product_with_image(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'subcategory_id' => 1,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);
    }

    public function test_superadmin_can_create_product_with_image(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'subcategory_id' => 1,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);
    }

    public function test_product_cannot_be_created_with_invalid_image_format(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.pdf');

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('image');
    }

    public function test_product_can_be_created_without_image(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'subcategory_id' => 1,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);
    }

    public function test_edit_product_form_can_be_seen_by_superadmin(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.edit', $this->product->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
    }

    public function test_edit_product_form_can_be_seen_by_admin(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.edit', $this->product->id));
        
        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
    }

    public function test_edit_product_form_cannot_be_seen_by_client(): void
    {
        $role = $this->client_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->get(route('products.edit', $this->product->id));
        
        $response->assertStatus(403);
    }

    public function test_product_info_can_be_updated(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->put(route('products.update', $this->product->id), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => 1
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
    }

    public function test_product_info_can_be_updated_without_image(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->put(route('products.update', $this->product->id), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => 1
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
    }

    public function test_product_info_cannot_be_updated_with_invalid_image_format(): void
    {
        $role = $this->admin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('test.pdf');

        $response = $this->put(route('products.update', $this->product->id), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => $this->subcategoryId,
            'stock' => '100',
            'active' => true,
            'order' => 1
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('image');
    }

    public function test_product_can_be_deleted_by_superadmin(): void
    {
        $role = $this->superadmin_role;

        $this->user->assignRole($role);

        $this->assertTrue($this->user->hasRole($role));

        $this->actingAs($this->user);

        $response = $this->delete(route('products.destroy', $this->product->id));

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
    }
}
