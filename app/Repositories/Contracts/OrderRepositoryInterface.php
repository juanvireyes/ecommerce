<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getOrderById(int $orderId): Order;

    public function getAllOrders(User $user): LengthAwarePaginator;

    public function updateOrder(array $data, Order $order): bool;
}