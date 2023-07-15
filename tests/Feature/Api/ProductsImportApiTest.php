<?php

namespace Tests\Feature\Api;

use App\Jobs\SuccessImportProductsNotificationJob;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductsImportApiTest extends TestCase
{
    use RefreshDatabase;

    public Role $superadminRole;
    public Role $adminRole;
    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);
        $this->superadminRole = Role::where('name', 'superadmin')->first();
        $this->adminRole = Role::where('name', 'admin')->first();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function superadmin_can_import_products_list(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->assertTrue($this->user->hasRole($this->superadminRole));
        Sanctum::actingAs($this->user);
        $token = $this->user->createToken('token')->plainTextToken;
        $this->assertNotNull($token);

        Excel::fake();

        $file = UploadedFile::fake()->create('ProductsFormat.xlsx');

        $response = $this->postJson(route('api.products.import'), [
            'productsList' => $file
        ]);

        $response->assertOk()->assertJsonStructure([
            'message'
        ]);

        Excel::assertQueuedWithChain([
            new SuccessImportProductsNotificationJob($this->user)
        ]);
    }
}
