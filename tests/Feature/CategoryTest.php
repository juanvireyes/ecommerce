<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Routing\Route;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;

use function PHPUnit\Framework\assertTrue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function test_categories_list_page_loads_successfully_for_admin(): void
    {
        $user = User::where('email', 'admin@mail.com')->first();

        $role = Role::where('name', 'admin')->first();

        $this->assertTrue($user->hasRole($role->name));

        $this->actingAs($user);

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
    }

    public function test_categories_list_page_loads_successfully_for_superadmin(): void
    {
        $user = User::where('email', 'superadmin@mail.com')->first();

        $role = Role::where('name', 'superadmin')->first();

        $this->assertTrue($user->hasRole($role->name));

        $this->actingAs($user);

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
    }

    public function test_user_can_see_create_category_page_as_admin(): void
    {
        $user = User::where('email', 'admin@mail.com')->first();

        $role = Role::where('name', 'admin')->first();

        $this->assertTrue($user->hasRole($role->name));

        $this->actingAs($user);

        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);

        $response->assertViewIs('categories.category-form');
    }

    public function test_user_can_see_category_page_as_superadmin(): void
    {
        $user = User::where('email', 'superadmin@mail.com')->first();

        $role = Role::where('name', 'superadmin')->first();

        $this->assertTrue($user->hasRole($role->name));

        $this->actingAs($user);

        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);

        $response->assertViewIs('categories.category-form');
    }

    public function test_user_cant_see_create_category_page_as_client(): void
    {
        $user = User::where('email', 'amy.kertzmann@example.org')->first();

        $role = Role::where('name', 'client')->first();

        $this->assertTrue($user->hasRole($role->name));

        $this->actingAs($user);

        $response = $this->get(route('categories.create'));
        $response->assertStatus(403);
    }

    public function test_user_can_create_category_as_admin(): void
    {
        $user = User::where('email', 'admin@mail.com')->first();

        $role = Role::where('name', 'admin')->first();

        $this->assertTrue($user->hasRole($role->name));
        $this->actingAs($user);

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
        $user = User::where('email', 'superadmin@mail.com')->first();

        $role = Role::where('name', 'superadmin')->first();

        $this->assertTrue($user->hasRole($role->name));
        $this->actingAs($user);

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
        $user = User::where('email', 'admin@mail.com')->first();

        $role = Role::where('name', 'admin')->first();

        $this->assertTrue($user->hasRole($role->name));
        $this->actingAs($user);

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
        $user = User::where('email', 'admin@mail.com')->first();

        $role = Role::where('name', 'admin')->first();

        $this->assertTrue($user->hasRole($role->name));
        $this->actingAs($user);

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
        $user = User::where('email', 'admin@mail.com')->first();

        $role = Role::where('name', 'admin')->first();

        $this->assertTrue($user->hasRole($role->name));
        $this->actingAs($user);

        // $file = UploadedFile::fake()->image('image.pdf');

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
}
