<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Subcategory;
use Database\Seeders\RolesSeeder;
use Database\Seeders\PermissionsSeeder;
use App\Http\Controllers\CartItemController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function add_to_cart_test(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $user = User::factory()->create();

        $category = Category::factory()->create();

        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);

        $product = Product::factory()->create(['subcategory_id' => $subcategory->id]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $quantity = 1;

        $response = $this->actingAs($user)->post(route('cart.add', [
            'cart_id' => $cart->id,
            'productId' => $product->id,
            'quantity' => $quantity,
        ]));

        $response->assertRedirect(url()->previous());

    }


    /** @test */
    public function remove_from_cart_test(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $user = User::factory()->create();

        $category = Category::factory()->create();

        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);

        $product = Product::factory()->create(['subcategory_id' => $subcategory->id]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $quantity = 2;

        $cartItem = CartItemController::store($cart, $product, $quantity);

        $response = $this->actingAs($user)->delete(route('cart.destroy', $cartItem));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }


    /** @test */
    public function update_cart_test(): void
    {
        $this->seed(RolesSeeder::class);
        $this->seed(PermissionsSeeder::class);

        $user = User::factory()->create();

        $category = Category::factory()->create();

        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);

        $product = Product::factory()->create(['subcategory_id' => $subcategory->id]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $quantity = 2;

        $cartItem = CartItemController::store($cart, $product, $quantity);

        $response = $this->actingAs($user)->patch(route('cart.update', $cartItem), [
            'quantity' => 3,
            'item_total_amount' => $product->price * 3,
        ]);

        $response->assertRedirect(url()->previous());
    }
}
