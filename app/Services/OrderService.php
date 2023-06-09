<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;

/**
 * @property Cart $cart
 */
class OrderService
{
    public function createOrder(User $user): Order
    {
        $cart = $user->cart;

        $totalAmmount = $this->getTotalAmmount($cart);

        $order = Order::create([
            'user_id' => $user->id,
            'total' => $totalAmmount
        ]);

        $this->createOrderDetails($cart, $order);

        $cart->delete();

        return $order;
    }


    private function getTotalAmmount(Cart $cart): float
    {
        $totalAmmount = $cart->total_amount;
        
        return $totalAmmount;
    }


    private function createOrderDetails(Cart $cart, Order $order): void
    {
        $cartItems = $cart->cartItems;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $cartItem->product_name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'product_total' => $cartItem->item_total_amount
            ]);
        };
    }
}