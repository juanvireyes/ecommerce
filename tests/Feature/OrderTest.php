<?php

namespace Tests\Feature;

use App\Builders\GeneralRequestBuilder;
use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\OrderRepository;
use App\Services\PlaceToPayPaymentService;
use App\Http\Controllers\CartItemController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(RolesSeeder::class);
        
        $this->user = User::factory()->create();

        $this->actingAs($this->user);

        $category = Category::factory()->create();

        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);

        $product = Product::factory()->create(['subcategory_id' => $subcategory->id]);

        $cart = Cart::factory()->create(['user_id' => $this->user->id]);
        $quantity = 2;

        $cartItem = CartItemController::store($cart, $product, $quantity);

        $orderService = new OrderService();

        $this->order = $orderService->createOrder($this->user);
    }

    /**
     * @test
     */
    public function orders_index_load(): void
    {

        $this->assertAuthenticated();

        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertViewIs('orders.index');
    }

    /**
     * @test 
     */
    public function orders_details_load_succesfully(): void
    {
        $this->assertDatabaseHas('orders', ['user_id' => $this->user->id]);
        $this->assertDatabaseHas('order_details', ['order_id' => $this->order->id]);

        $response = $this->get(route('orders.show', $this->order));

        $response->assertStatus(200);
        $response->assertViewIs('orders.show');
    }

    /**
     * @test
     */
    public function orders_can_be_paid_with_place_to_pay(): void
    {
        $orders = $this->user->orders;

        Log::info($orders);

        foreach ($orders as $order) {
            $orderId = $order->id;
            Log::info('El id de la orden es ' . $orderId);
            break;
        };

        $request = Request::create(route('orders.index', [
            'order_id' => $orderId
        ]));

        Log::info('Este es el order_id desde el request: '.$request->order_id);

        $mockResponse = [
            'status' => [
                'status' => 'OK',
                'reason' => 'PC',
                'message' => 'La petición se ha procesado correctamente',
                'date' => '2023-06-08T21:07:27-05:00'
            ],
            'requestId' => 1,
            'processUrl' => 'https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a'
        ];

        Http::fake([config('placetopay.url').'/*' => Http::response($mockResponse)]);

        if ($orderId) {
            $this->postJson(route('orders.payment', $orderId), [
                'total' => $this->order->total,
                'id' => $this->order->getKey(),
                'order_id' => $request->order_id,
            ])->assertStatus(302)
                ->assertRedirect('https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a');
        } else {
            Log::info('No se puede obtener el id de la orden');
        };
    }
}
