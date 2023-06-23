<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrderRepository;
use Illuminate\Http\RedirectResponse;

class OrderAdminController extends Controller
{
    private OrderRepository $orderRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }

    public function index(User $user)
    {
        $this->authorize('viewAny', Order::class);
        $orders = $this->orderRepository->getAllOrders($user);

        return view('superadmin.orders.index', compact('orders', 'user'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $order = Order::with('orderItems')->find($request->order_id);
        $user = $order->user;
        $orderItems = $order->orderItems;
        $product = null;

        foreach ($orderItems as $orderItem) {
            
            $product = $orderItem->product;
            Log::info('El producto que va a aumentar el stock es: ' . $product->name . ' el stock es: ' . $product->stock . ' y va a aumentar a: ' . $orderItem->quantity . ' unidades');
            $product->increaseStock($orderItem->quantity);
            
            if($product->active == false) {
                $product->updateStatus();
            }
        };

        $order->orderItems()->delete();
        $order->delete();

        Log::info('El pedido fue eliminado');
        Log::info('El producto fue actualizado');
        Log::info('El nuevo stock es: ' . $product->stock);

        return redirect()->route('user.orders', compact('user'))->with('success', 'Pedido eliminado');
    }
}
