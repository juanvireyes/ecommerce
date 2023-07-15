<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class SubcategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public Role $superadminRole;
    public Role $adminRole;
    public User $user;
    public Category $category;
    public Subcategory $subcategory;

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
    }

    /** @test */
    public function superadmin_can_see_subcategories_list(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $this->getJson(route('api.subcategories.index'))
            ->assertOk()
            ->assertJsonStructure([
                'subcategories'
            ]);
    }

    /** @test */
    public function admin_can_see_subcategories_list(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $this->getJson(route('api.subcategories.index'))
            ->assertOk()
            ->assertJsonStructure([
                'subcategories'
            ]);
    }

    /** @test */
    public function superadmin_can_create_subcategories(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->postJson(route('api.subcategories.store'), [
            'name' => 'Subcategory test',
            'slug' => 'subcategory-test',
            'description' => 'Created test subcategory',
            'image' => $file,
            'order' => 1,
            'category_id' => $this->category->id
        ])->assertStatus(201)->assertJsonStructure([
            'created_subcategory'
        ]);

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Subcategory test',
        ]);
    }

    /** @test */
    public function admin_can_create_subcategories(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->postJson(route('api.subcategories.store'), [
            'name' => 'Subcategory test',
            'slug' => 'subcategory-test',
            'description' => 'Created test subcategory',
            'image' => $file,
            'order' => 1,
            'category_id' => $this->category->id
        ])->assertStatus(201)->assertJsonStructure([
            'created_subcategory'
        ]);

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Subcategory test',
        ]);
    }

    /** @test */
    public function subcategory_can_be_created_without_image(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $this->postJson(route('api.subcategories.store'), [
            'name' => 'Subcategory test',
            'slug' => 'subcategory-test',
            'description' => 'Created test subcategory',
            'order' => 1,
            'category_id' => $this->category->id
        ])->assertStatus(201)->assertJsonStructure([
            'created_subcategory'
        ]);

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Subcategory test',
        ]);
    }

    /** @test */
    public function subcategory_cant_be_created_without_name(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->postJson(route('api.subcategories.store'), [
            'slug' => 'subcategory-test',
            'description' => 'Created test subcategory',
            'image' => $file,
            'order' => 1,
            'category_id' => $this->category->id
        ])->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function subcategory_cant_be_created_with_an_invalid_file_format(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->create('image', 2048, 'pdf');

        $this->postJson(route('api.subcategories.store'), [
            'name' => 'Subcategory test',
            'slug' => 'subcategory-test',
            'description' => 'Created test subcategory',
            'image' => $file,
            'order' => 1,
            'category_id' => $this->category->id
        ])->assertStatus(422)->assertJsonValidationErrors([
            'image'
        ]);
    }

    /** @test */
    public function superadmin_can_update_subcategories(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->putJson(route('api.subcategories.update', $this->subcategory), [
            'name' => 'Updated Subcategory test',
            'slug' => 'updated-subcategory-test',
            'description' => 'Updated test subcategory',
            'image' => $file
        ])->assertOk()->assertJsonStructure([
            'updated_subcategory'
        ]);

        $this->assertDatabaseHas('subcategories', [
           'name' => 'Updated Subcategory test'
        ]);
    }

    /** @test */
    public function admin_can_update_subcategories(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $file = UploadedFile::fake()->image('image.png');

        $this->putJson(route('api.subcategories.update', $this->subcategory), [
            'name' => 'Updated Subcategory test',
            'slug' => 'updated-subcategory-test',
            'description' => 'Updated test subcategory',
            'image' => $file
        ])->assertOk()->assertJsonStructure([
            'updated_subcategory'
        ]);

        $this->assertDatabaseHas('subcategories', [
            'name' => 'Updated Subcategory test'
        ]);
    }

    /** @test */
    public function superadmin_can_delete_subcategories(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $this->deleteJson(route('api.subcategories.destroy', $this->subcategory))
            ->assertOk()->assertJsonStructure([
                'deleted_subcategory'
            ]);

        $this->assertDatabaseMissing('subcategories',[
            'id' => $this->subcategory->id,
            'name' => $this->subcategory->name
        ]);
    }

    /** @test */
    public function admin_can_delete_subcategories(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->assertTrue($this->user->hasRole($this->adminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        $this->deleteJson(route('api.subcategories.destroy', $this->subcategory))
            ->assertOk()->assertJsonStructure([
                'deleted_subcategory'
            ]);

        $this->assertDatabaseMissing('subcategories',[
            'id' => $this->subcategory->id,
            'name' => $this->subcategory->name
        ]);
    }
}
