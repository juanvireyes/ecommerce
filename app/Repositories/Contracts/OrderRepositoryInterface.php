<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function createOrder(User $user, array $data): Order;

    public function getOrderById(int $orderId): Order;

    public function getAllOrders(User $user): Collection;

    public function updateOrder(array $data, Order $order): bool;
}