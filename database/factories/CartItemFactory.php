<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $subcategory = Subcategory::all()->random()->id;
        $product = Product::factory()->create(['subcategory_id' => $subcategory]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $quantity = rand(1, 5);

        return [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $product->price,
            'item_total_amount' => $product->price * $quantity,
        ];
    }
}
