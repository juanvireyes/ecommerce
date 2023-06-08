<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{    
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
        $orders = $user->orders;
        $orderStatus = '';

        foreach($orders as $order) {
            $orderStatus = $order->status;
        };

        if($orderStatus == 'pending') {
            $order = Order::query()
            ->where('user_id' , '=' ,  $userId)
            ->where('status' , '=' , $orderStatus)
            ->latest()->first();
        };

        $order = Order::query()
            ->where('status' , '!=' , 'pending')
            ->latest()->first();

        return $order;
    }

    public function getOrdersList(): LengthAwarePaginator
    {
        $orders = Order::query()
            ->with('user')
            ->latest()->paginate(10);

        return $orders;
    }
}