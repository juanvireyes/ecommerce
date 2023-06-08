<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(User $user, array $data): Order
    {
        $userId = $user->auth()->id();

        $cart = $user->cart;

        $cartTotalAmmount = $cart->total_amount;

        $order = Order::create([
            'user_id' => $userId,
            'total' => $cartTotalAmmount,
        ]);

        return $order;
    }

    
    public function getOrderById(int $orderId): Order
    {
        return Order::findOrFail($orderId);
    }


    public function getAllOrders(User $user): Collection
    {
        return $user->orders;
    }


    public function updateOrder(array $data, Order $order): bool
    {
        try {

            $order->update($data);

            return true;

        } catch (\Exception $e) {

            Log::info($e->getMessage());
            
            throw new \Exception('Error updating order');

            return false;

        };
    }


    public function getUserLastOrder(User $user): Order
    {
        $userId = $user->id;

        $order = Order::query()
            ->where('user_id' , '=' ,  $userId)
            ->where('status' , '=' , 'pending')
            ->latest()->first();

        return $order;
    }
}