<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public Role $superadminRole;
    public Role $adminRole;
    public User $superadmin;
    public User $admin;
    public User $client;
    public Category $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->superadminRole = Role::where('name', 'superadmin')->first();
        $this->adminRole = Role::where('name', 'admin')->first();

        $this->superadmin = User::factory()->create();
        $this->admin = User::factory()->create();
        $this->client = User::factory()->create();

        $this->category = Category::factory()->create();
    }

    /** @test */
    public function superadmin_can_see_list_categories(): void
    {
        $this->superadmin->assignRole($this->superadminRole);
        $this->assertTrue($this->superadmin->hasRole($this->superadminRole));
        Sanctum::actingAs($this->superadmin);
        $token = $this->superadmin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $this->getJson(route('categories.index'))
            ->assertOk();
    }

    /** @test */
    public function admin_can_see_categories_list(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $this->getJson(route('api.categories.index'))
            ->assertOk()
            ->assertJsonStructure([
                'data'
            ]);
    }

    /** @test  */
    public function superadmin_can_create_categories(): void
    {
        $this->superadmin->assignRole($this->superadminRole);
        $this->assertTrue($this->superadmin->hasRole($this->superadminRole));
        Sanctum::actingAs($this->superadmin);
        $token = $this->superadmin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->postJson(route('api.categories.store'), [
            'name' => 'Test Category',
            'description' => 'A description for test category',
            'image' => $file,
            'order' => 1
        ])->assertStatus(201)->assertJsonStructure([
            'created_category'
        ]);
    }

    /** @test */
    public function admin_can_create_category(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->postJson(route('api.categories.store'), [
            'name' => 'Test Category',
            'description' => 'A description for test category',
            'image' => $file,
            'order' => 1
        ])->assertStatus(201)->assertJsonStructure([
            'created_category'
        ]);
    }

    /** @test */
    public function category_can_be_created_without_image(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $this->postJson(route('api.categories.store'), [
            'name' => 'Test Category',
            'description' => 'A description for test category',
            'order' => 1
        ])->assertStatus(201)->assertJsonStructure([
            'created_category'
        ]);
    }

    /** @test */
    public function category_cant_be_created_with_an_invalid_image(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->create('archivo', 2048, 'pdf');

        $this->postJson(route('api.categories.store'), [
            'name' => 'Test Category',
            'description' => 'A description for test category',
            'image' => $file,
            'order' => 1
        ])->assertStatus(422)
            ->assertJsonValidationErrors('image');
    }

    /** @test */
    public function superadmin_can_update_category_info(): void
    {
        $this->superadmin->assignRole($this->superadminRole);
        $this->assertTrue($this->superadmin->hasRole($this->superadminRole));
        Sanctum::actingAs($this->superadmin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->putJson(route('api.categories.update', $this->category), [
            'name' => 'Updated category',
            'slug' => 'updated-category',
            'description' => 'The category was updated',
            'image' => $file
        ])->assertOk()
            ->assertJsonStructure(['updated_category']);
    }

    /** @test */
    public function admin_can_update_category_data(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->putJson(route('api.categories.update', $this->category), [
            'name' => 'Updated category',
            'slug' => 'updated-category',
            'description' => 'The category was updated',
            'image' => $file
        ])->assertOk()
            ->assertJsonStructure(['updated_category']);
    }

    /** @test */
    public function category_cant_be_updated_without_name_through_api(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->putJson(route('api.categories.update', $this->category), [
            'slug' => 'updated-category',
            'description' => 'The category was updated',
            'image' => $file
        ])->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function category_cant_be_updated_with_an_invalid_image_format(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->create('archivo', 2048, 'pdf');

        $this->postJson(route('api.categories.update', $this->category), [
            'name' => 'Test Category',
            'description' => 'A description for test category',
            'image' => $file
        ])->assertStatus(422)
            ->assertJsonValidationErrors('image');
    }

    /** @test */
    public function superadmin_can_delete_a_category(): void
    {
        $this->superadmin->assignRole($this->superadminRole);
        $this->assertTrue($this->superadmin->hasRole($this->superadminRole));
        Sanctum::actingAs($this->superadmin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $this->deleteJson(route('api.categories.destroy', $this->category))
            ->assertOk()->assertJsonStructure([
                'message',
                'deleted_category'
            ]);
    }

    /** @test */
    public function admin_can_delete_categories(): void
    {
        $this->admin->assignRole($this->adminRole);
        $this->assertTrue($this->admin->hasRole($this->adminRole));
        Sanctum::actingAs($this->admin);
        $token = $this->admin->createToken('access_token')->plainTextToken;
        $this->assertNotNull($token);

        $this->deleteJson(route('api.categories.destroy', $this->category))
            ->assertOk()->assertJsonStructure([
                'message',
                'deleted_category'
            ]);
    }
}
