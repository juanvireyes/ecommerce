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


    public function getAllOrders(User $user): LengthAwarePaginator
    {
        $userId = $user->id;
        
        $orders = Order::query()
        ->where('user_id', '=', $userId)
        ->with('user')
        ->with('orderItems')
        ->latest()
        ->paginate(10);

        return $orders;
    }


    public function updateOrder(array $data, Order $order): bool
    {
        try {

            $order->update($data);

            Log::info('Order updated: ' . $order);

            return true;

        } catch (\Exception $e) {

            Log::info($e->getMessage());
            
            throw new \Exception('Error updating order');

        };
    }


    public function getUserLastOrder(User $user): Order
    {
        $userId = $user->id;

        $order = $user->orders()->where('user_id', '=', $userId)
            ->where('status', '=', 'pending')
            ->where('order_number', '!=', null)
            ->first();
        
        if($order) {
            Log::info('Id de orden que se está actualizando: ' . $order->id);
        } else {
            Log::info('No se encontrón ninguna orden');
        };

        return $order;
    }

    public function getOrdersList(User $user): LengthAwarePaginator
    {
        $userId = $user->id;

        $orders = Order::query()
            ->where('user_id', '=', $userId)
            ->with('user')
            ->with('orderItems')
            ->latest()->paginate(10);

        return $orders;
    }

    public function getUserOrdersByStatus(User $user, string $status): LengthAwarePaginator
    {
        $userId = $user->id;

        $orders = Order::query()
            ->where('user_id', '=', $userId)
            ->where('status', '=', $status)
            ->with('user')
            ->with('orderItems')
            ->latest()->paginate(10);
        
        return $orders;
    }
}