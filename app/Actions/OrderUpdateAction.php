<?php

namespace App\Actions;

use App\Models\Order;

class OrderUpdateAction
{
    public static function execute(Order $order): void
    {
        $order->save();
    }
}