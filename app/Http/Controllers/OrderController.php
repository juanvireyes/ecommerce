<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): View
    {
        $user = auth()->user();
        $orders = $user->orders;

        if ($user->cart) {
            $order = $this->orderService->createOrder($user);
        };


        return view('orders.index', compact('orders'));
    }
}
