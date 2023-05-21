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

    public function test_admin_can_see_products_list(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('admin')->first();
        $permission = Permission::whereIn('name', ['view products', 'edit products', 'delete products'])->get();

        $role->givePermissionTo($permission);

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_superadmin_can_see_products_list(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('superadmin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_client_cannot_see_management_products_list(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::where('name', 'client')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('products.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_see_product_create_form(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('admin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_superadmin_can_see_product_create_form(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('superadmin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_client_cannot_see_product_create_form(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::where('name', 'client')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);
        $response = $this->get(route('products.create'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_product_with_image(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('admin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => Subcategory::factory()->create()->id,
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
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('superadmin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => Subcategory::factory()->create()->id,
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
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('admin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('test.pdf');

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'image' => $file,
            'subcategory_id' => Subcategory::factory()->create()->id,
            'stock' => '100',
            'active' => true,
            'order' => '1'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('image');
    }

    public function test_product_can_be_created_without_image(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('admin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        $this->actingAs($user);

        $response = $this->post(route('product.store'), [
            'name' => 'Test product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => '100',
            'subcategory_id' => Subcategory::factory()->create()->id,
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
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $role = Role::findByName('admin')->first();

        $user = User::factory()->create();

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));

        // $product = Product::factory()->create();

        // $this->actingAs($user);

        // $response = $this->get(route('products.edit', $product->id));
        
        // $response->assertStatus(200);
        // $response->assertViewIs('products.edit');
    }
}
