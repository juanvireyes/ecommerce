<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\OrderService;
use Database\Seeders\RolesSeeder;
use Illuminate\Support\Facades\Log;
use Database\Seeders\PermissionsSeeder;
use App\Http\Controllers\CartItemController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @property Cart $cart
 * @property User $user
 * @property Product $product
 * @property CartItem $cartItem
 */
class CartTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;
    protected Cart $cart;
    protected CartItem $cartItem;
    protected OrderService $orderService;
    protected CartItemController $cartItemController;
    protected Category $category;
    protected Subcategory $subcategory;
    protected int $quantity;
    protected string $productId;
    protected string $cartId;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $this->user = User::factory()->create();

        // @phpstan-ignore-next-line
        $this->category = Category::factory()->create();

        // @phpstan-ignore-next-line
        $this->subcategory = Subcategory::factory()->create(['category_id' => $this->category->id]);

        $this->product = Product::factory()->create(['subcategory_id' => $this->subcategory->id]);
        $this->cart = Cart::factory()->create(['user_id' => $this->user->id]);
        $this->quantity = 2;

        $this->orderService = new OrderService();
    }
    
    /**
     * @test
     */
    public function add_to_cart(): void
    {

        $response = $this->actingAs($this->user)->post(route('cart.add', [
            'cart_id' => $this->cart->id,
            'productId' => $this->product->id,
            'quantity' => $this->quantity,
        ]));

        $response->assertRedirect(url()->previous());

    }


    /** @test */
    public function remove_from_cart(): void
    {
        $cartItem = CartItemController::store($this->cart, $this->product, $this->quantity);

        $response = $this->actingAs($this->user)->delete(route('cart.destroy', $cartItem));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }


    /** @test */
    public function update_cart(): void
    {
        $cartItem = CartItemController::store($this->cart, $this->product, $this->quantity);

        $response = $this->actingAs($this->user)->patch(route('cart.update', $cartItem), [
            'quantity' => 3,
            'item_total_amount' => $this->product->price * 3,
        ]);

        $response->assertRedirect(url()->previous());
    }

    /** @test */
    public function clear_cart(): void
    {
        $response = $this->actingAs($this->user)->post(route('cart.clear', ['cart' => $this->cart]));

        $response->assertRedirect(route('cart.index'));
    }

    /** @test */
    public function checkout_cart_and_order_creation(): void
    {
        $order = $this->orderService->createOrder($this->user);

        Log::info('Esta es la orden del test: ' . $order->id);

        $this->assertDatabaseHas('orders', ['user_id' => $this->user->id]);
    }
}
