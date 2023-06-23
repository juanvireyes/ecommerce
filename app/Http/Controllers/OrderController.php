<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    private OrderService $orderService;
    private OrderRepository $orderRepository;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->orderRepository = new OrderRepository();
    }

    public function index(Request $request): View
    {
        $user = auth()->user();
        $orders = $this->orderRepository->getOrdersList($user);

        if ($user->cart) {
            $order = $this->orderService->createOrder($user);
        }

        if($request->filter_orders != null){
            $orders = $this->filterOrderStatus($request, $user);
        } 

        return view('orders.index', compact('orders', 'user'));
    }

    private function filterOrderStatus(Request $request, User $user): LengthAwarePaginator
    {
        $status = $request->filter_orders;
        $filtered_orders = $this->orderRepository->getUserOrdersByStatus($user, $status);

        return $filtered_orders;
    }
}
