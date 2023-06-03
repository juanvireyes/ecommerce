<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CartController;
use App\Http\Requests\StoreCartItemRequest;
use Livewire\Component;

class CartItems extends Component
{
    public $products;
    public $product;

    public function render()
    {
        return view('livewire.cart-items');
    }

    public function addToCart(StoreCartItemRequest $request, int $productId, int $quantity)
    {
        $cart = new CartController();
        $cart = $cart->addToCart($request, $productId, $quantity);

        $this->product = $cart;

        return redirect()->route('cart');
    }
}
