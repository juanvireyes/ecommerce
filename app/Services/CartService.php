<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\ProductRepository;

class CartService
{
    protected int $userId;
    protected ProductRepository $productRepository;

    public function __construct(int $userId, ProductRepository $productRepository)
    {
        $userId = auth()->id();
        $this->userId = $userId;
        $this->productRepository = $productRepository;
    }

    public function getCurrentCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => $this->userId]);
    }

    public function createCartItem(int $productId, int $quantity): CartItem
    {

        $cart = $this->getCurrentCart();
        $cartId = $cart->id;
        $product = $this->productRepository->getProductById($productId);

        $cartItem = CartItem::Create([
            'cart_id' => $cartId,
                'product_id' => $productId,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'item_total_amount' => $product->price * $quantity,
        ]);

        $this->updateCartTotalAmount($cart);

        return $cartItem;
    }

    protected function updateCartTotalAmount(Cart $cart): void
    {
        $totalAmount = collect($cart->cartItems)->sum('item_total_amount');
        $cart->total_amount = $totalAmount;
        $cart->save();
    }

    public function getCartItems(): array
    {
        $cart = $this->getCurrentCart();
        $cartItems = $cart->cartItems;

        return $cartItems;
    }

    public function updateCartItemQuantity(int $cartItemId, int $quantity): bool
    {
        $cartItem = CartItem::find($cartItemId);

        if($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->item_total_amount = $cartItem->price * $quantity;
            $cartItem->save();

            return true;
        }

        return false;
    }

    public function removeCartItem(int $cartItemId): bool
    {
        $cartItem = CartItem::find($cartItemId);

        if ($cartItem) {
            $cartItem->delete();
            $cart = $cartItem->cart;
            $this->updateCartTotalAmount($cart);

            return true;
        }

        return false;
    }

    public function clearCart(): bool
    {
        $cart = $this->getCurrentCart();
        $cart->cartItems()->delete();
        $cart->total_amount = 0;
        $cart->save();

        return true;
    }
}