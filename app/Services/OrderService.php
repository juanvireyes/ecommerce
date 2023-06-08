<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderDetail;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function createOrder(User $user): Order
    {
        $cart = $user->cart;

        $totalAmmount = $this->getTotalAmmount($user);

        $order = Order::create([
            'user_id' => $user->id,
            'total' => $totalAmmount
        ]);

        $this->createOrderDetails($user,$order);

        $cart->delete();

        return $order;
    }


    private function getTotalAmmount(User $user): float
    {
        $cart = $user->cart;

        $totalAmmount = $cart->total_amount;
        
        return $totalAmmount;
    }


    private function createOrderDetails(User $user, Order $order): void
    {
        $cart = $user->cart;

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