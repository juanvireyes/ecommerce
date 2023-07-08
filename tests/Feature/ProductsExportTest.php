<?php

namespace Tests\Feature;

use App\Exports\ProductsExport;
use App\Jobs\ProductsDownloadNotificationJob;
use App\Jobs\ProductsExportJob;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductsExportTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Role $superadminRole;
    private Role $adminRole;
    private Role $clientRole;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->user = User::factory()->create();
        $this->superadminRole = Role::where('name', 'superadmin')->first();
        $this->adminRole = Role::where('name', 'admin')->first();
        $this->clientRole = Role::where('name', 'client')->first();
    }
   
    /** * @test */
    public function route_export_products_is_working(): void
    {
        $this->user->assignRole($this->superadminRole);
        $this->actingAs($this->user)
            ->get(route('products.export'))
            ->assertRedirect(route('products.index'));;
    }

    /** * @test   */
    public function route_export_products_is_working_for_admin(): void
    {
        $this->user->assignRole($this->adminRole);
        $this->actingAs($this->user)
            ->get(route('products.export'))
            ->assertRedirect(route('products.index'));
    }

    /** * @test  */
    public function route_export_products_is_not_working_for_client(): void
    {
        $this->user->assignRole($this->clientRole);
        $this->actingAs($this->user)
            ->get(route('products.export'))
            ->assertForbidden();
    }

    /** * @test */
    public function it_queued_and_chained_with_download_notification_job_for_superadmin(): void
    {
        Excel::fake();
        Carbon::setTestNow(now());
        Storage::fake('public');

        $this->user->assignRole($this->superadminRole);
        $this->actingAs($this->user)
            ->get(route('products.export'))
            ->assertRedirect(route('products.index'));

        Excel::assertQueuedWithChain([
            new ProductsDownloadNotificationJob($this->user)
        ]);
    }

    /** * @test */
    public function it_queued_and_chained_with_download_notification_job_for_admin(): void
    {
        Excel::fake();
        Carbon::setTestNow(now());
        Storage::fake('public');
        
        $this->user->assignRole($this->adminRole);
        $this->actingAs($this->user)
            ->get(route('products.export'))
            ->assertRedirect(route('products.index'));
        
        Excel::assertQueuedWithChain([
            new ProductsDownloadNotificationJob($this->user)
        ]);
    }

    /** * @test */
    public function it_cant_be_queued_and_chained_with_download_notification_for_client(): void
    {
        Excel::fake();
        Carbon::setTestNow(now());
        Storage::fake('public');

        $this->user->assignRole($this->clientRole);
        $this->actingAs($this->user)
            ->get(route('products.export'))
            ->assertForbidden();
    }
}
