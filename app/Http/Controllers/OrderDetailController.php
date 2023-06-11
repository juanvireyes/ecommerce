<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function show(Order $order)
    {
        $orderItems = $order->orderItems;

        $user = auth()->user();

        return view('orders.show', compact('order', 'orderItems', 'user'));
    }
}
