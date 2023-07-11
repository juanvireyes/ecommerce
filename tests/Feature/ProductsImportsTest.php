<?php

namespace Tests\Feature;

use App\Jobs\SuccessImportProductsNotificationJob;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductsImportsTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Role $superadminRole;
    public Role $adminRole;
    public Role $clientRole;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->user = User::factory()->create();
        $this->superadminRole = Role::where('name', 'superadmin')->first();
        $this->adminRole = Role::where('name', 'admin')->first();
        $this->clientRole = Role::where('name', 'client')->first();
    }

    /** @test  */
    public function superadmin_can_import_products_list(): void
    {
        Excel::fake();
        $this->user->assignRole($this->superadminRole);
        $file = UploadedFile::fake()->create('FormatoProductos.xlsx');

        $response = $this->actingAs($this->user)->post(route('products.import'), [
            'productsFile' => $file
        ]);

        Excel::assertQueuedWithChain([
            new SuccessImportProductsNotificationJob($this->user)
        ]);

        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function admin_can_import_products_list(): void
    {
        Excel::fake();
        $this->user->assignRole($this->adminRole);
        $file = UploadedFile::fake()->create('FormatoProductos.xlsx');

        $response = $this->actingAs($this->user)->post(route('products.import'), [
            'productsFile' => $file
        ]);

        Excel::assertQueuedWithChain([
            new SuccessImportProductsNotificationJob($this->user)
        ]);

        $response->assertRedirect(route('products.index'));
    }

    /** @test */
    public function client_cant_upload_products_list(): void
    {
        $this->user->assignRole($this->clientRole);
        $file = UploadedFile::fake()->create('FormatoProductos.xlsx');

        $response = $this->actingAs($this->user)->post(route('products.import'), [
            'productsFile' => $file
        ]);

        $response->assertForbidden();
    }
}
