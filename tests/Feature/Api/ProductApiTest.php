<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public Role $superadminRole;
    public Role $adminRole;
    public User $user;
    public Category $category;
    public Subcategory $subcategory;
    public Product $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->superadminRole = Role::where('name', 'superadmin')->first();
        $this->adminRole = Role::where('name', 'admin')->first();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->subcategory = Subcategory::factory()->create(['category_id' => $this->category->id]);
        $this->product = Product::factory()->create(['subcategory_id' => $this->subcategory->id]);
    }

    /** @test */
    public function superadmin_can_see_products_list(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk()
            ->assertJsonStructure([
            'products'
        ]);
    }

    /** @test */
    public function admin_can_see_products_list(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'products'
            ]);
    }

    /** @test */
    public function superadmin_can_create_products(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('product.png');

        $response = $this->postJson(route('api.products.store'), [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Product test description',
            'image' => $file,
            'price' => 100.15,
            'stock' => 4,
            'active' => 1,
            'order' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'created_product'
        ]);

        $this->assertDatabaseHas('products', [
           'name' => 'Test Product'
        ]);
    }

    /** @test */
    public function admin_can_create_products(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('product.png');

        $response = $this->postJson(route('api.products.store'), [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Product test description',
            'image' => $file,
            'price' => 100.15,
            'stock' => 4,
            'active' => 1,
            'order' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'created_product'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product'
        ]);
    }

    /** @test */
    public function product_can_be_created_without_image(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $response = $this->postJson(route('api.products.store'), [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Product test description',
            'price' => 100.15,
            'stock' => 4,
            'active' => 1,
            'order' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'created_product'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product'
        ]);
    }

    /** @test */
    public function product_cant_be_created_with_invalid_file_format(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->create('product', 2048, 'pdf');

        $response = $this->postJson(route('api.products.store'), [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Product test description',
            'image' => $file,
            'price' => 100.15,
            'stock' => 4,
            'active' => 1,
            'order' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors([
            'image'
        ]);
    }

    /** @test */
    public function product_cant_be_created_without_name(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('product.png');

        $response = $this->postJson(route('api.products.store'), [
            'slug' => 'test-product',
            'description' => 'Product test description',
            'image' => $file,
            'price' => 100.15,
            'stock' => 4,
            'active' => 1,
            'order' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors([
            'name'
        ]);
    }

    /** @test */
    public function superadmin_can_update_products(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('product.png');

        $response = $this->postJson(route('api.products.update', $this->product), [
            'name' => 'Updated Test Product',
            'slug' => 'updated-test-product',
            'description' => 'Product test description updated',
            'image' => $file,
            'price' => 95.15,
            'stock' => 7,
            'active' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertOk()->assertJsonStructure([
            'updated_product'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Updated Test Product',
            'slug' => 'updated-test-product',
            'description' => 'Product test description updated',
            'price' => 95.15,
            'stock' => 7
        ]);
    }

    /** @test */
    public function admin_can_update_products(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('product.png');

        $response = $this->postJson(route('api.products.update', $this->product), [
            'name' => 'Updated Test Product',
            'slug' => 'updated-test-product',
            'description' => 'Product test description updated',
            'image' => $file,
            'price' => 95.15,
            'stock' => 7,
            'active' => 1,
            'subcategory_id' => $this->subcategory->id
        ]);

        $response->assertOk()->assertJsonStructure([
            'updated_product'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Updated Test Product',
            'slug' => 'updated-test-product',
            'description' => 'Product test description updated',
            'price' => 95.15,
            'stock' => 7,
        ]);
    }

    /** @test */
    public function superadmin_can_delete_products(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $response = $this->deleteJson(route('api.products.destroy', $this->product));

        $response->assertOk()->assertJsonStructure([
            'message',
            'deleted_product'
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $this->product->id
        ]);
    }

    /** @test */
    public function admin_can_delete_products(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $response = $this->deleteJson(route('api.products.destroy', $this->product));

        $response->assertOk()->assertJsonStructure([
            'message',
            'deleted_product'
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $this->product->id
        ]);
    }
}
