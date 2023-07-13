<?php

namespace Tests\Feature;

use App\Actions\CreateProductReportRegisterAction;
use App\Jobs\ProductRotationRepNotificationJob;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductRotationReport;
use App\Models\Subcategory;
use App\Models\User;
use App\Repositories\ProductRotationRepository;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductRotationReportTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Role $superadmin;
    public Role $admin;
    public Role $client;
    public Category $category;
    public Subcategory $subCategory;
    public Product $product;
    public Order $order;
    public OrderDetail $orderDetail;
    public ProductRotationRepository $productRotationRepository;
    public ProductRotationReport $register;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $this->superadmin = Role::where('name', 'superadmin')->first();
        $this->admin = Role::where('name', 'admin')->first();
        $this->client = Role::where('name', 'client')->first();
        $this->user = User::factory()->create();

        $this->category = Category::factory()->create();
        $this->subCategory = Subcategory::factory()->create([
            'category_id' => $this->category->id
        ]);
        $this->product = Product::factory()->create([
            'subcategory_id' => $this->subCategory->id
        ]);

        $this->productRotationRepository = new ProductRotationRepository();
    }

    /**
     * @test
     */
    public function report_product_data_get_registered(): void
    {
        $this->order = Order::create([
            'user_id' => $this->user->id,
            'currency' => 'USD',
            'status' => 'completed',
            'total' => $this->product->price * 3
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id
        ]);

        $this->orderDetail = OrderDetail::create([
            'order_id' => $this->order->id,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 3,
            'price' => $this->product->price,
            'product_total' => $this->product->price * 3
        ]);

        $this->assertDatabaseHas('order_details', [
           'id' => $this->orderDetail->id
        ]);

        $this->register = new ProductRotationReport();

        $action = new CreateProductReportRegisterAction(
            $this->order,
            $this->productRotationRepository,
            $this->register
        );
        $action->execute();

        $this->assertDatabaseHas('product_rotation_reports', [
            'product_id' => $this->product->id,
            'sold_units' => $this->orderDetail->quantity
        ]);
    }

    /** @test */
    public function superadmin_can_access_online_report_main_page(): void
    {
        $this->user->assignRole($this->superadmin);
        $this->assertTrue($this->user->hasRole($this->superadmin));

        $this->actingAs($this->user)
            ->get(route('reports.products'))
            ->assertOk()
            ->assertViewIs('reports.partials.products-rotation');
    }

    /** @test */
    public function admin_can_access_online_reports_main_page(): void
    {
        $this->user->assignRole($this->admin);
        $this->assertTrue($this->user->hasRole($this->admin));

        $this->actingAs($this->user)
            ->get(route('reports.products'))
            ->assertOk()
            ->assertViewIs('reports.partials.products-rotation');
    }

    /** @test */
    public function client_cant_access_online_reports_main_page(): void
    {
        $this->user->assignRole($this->client);
        $this->assertTrue($this->user->hasRole($this->client));

        $this->actingAs($this->user)
            ->get(route('reports.products'))
            ->assertForbidden();
    }

    /** @test */
    public function superadmin_can_download_online_products_rotation_report_from_mail(): void
    {
        Excel::fake();
        Carbon::setTestNow(now());
        Storage::fake('public');

        $this->user->assignRole($this->superadmin);
        $this->assertTrue($this->user->hasRole($this->superadmin));

        $this->actingAs($this->user)
            ->get(route('rep.products.export'))
            ->assertRedirect(route('reports.products'))
            ->assertSessionHas('success');

        Excel::assertQueuedWithChain([
            new ProductRotationRepNotificationJob($this->user)
        ]);
    }

    /** @test */
    public function admin_can_download_online_products_rotation_report_from_mail(): void
    {
        Excel::fake();
        Carbon::setTestNow(now());
        Storage::fake('public');

        $this->user->assignRole($this->admin);
        $this->assertTrue($this->user->hasRole($this->admin));

        $this->actingAs($this->user)
            ->get(route('rep.products.export'))
            ->assertRedirect(route('reports.products'))
            ->assertSessionHas('success');

        Excel::assertQueuedWithChain([
            new ProductRotationRepNotificationJob($this->user)
        ]);
    }

    /** @test */
    public function client_cant_download_online_products_rotation_report_from_mail(): void
    {
        $this->user->assignRole($this->client);
        $this->assertTrue($this->user->hasRole($this->client));

        $this->actingAs($this->user)
            ->get(route('rep.products.export'))
            ->assertForbidden();
    }
}
