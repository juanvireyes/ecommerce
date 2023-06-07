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

        if ($user->cart) {
            $order = $this->orderService->createOrder($user);
        };

        $orders = $user->orders;

        return view('orders.index', compact('orders'));
    }

    private function getTotalAmmount(User $user): float
    {
        $cart = $user->cart;

        $totalAmmount = $cart->total_amount;
        
        return $totalAmmount;
    }

    private function createOrder(User $user): Order
    {
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $this->getTotalAmmount($user),
        ]);

        return $order;
    }
}
