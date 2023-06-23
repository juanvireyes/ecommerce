<?php

namespace App\Services;

use App\Actions\CreatePlaceToPayAuthAction;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Actions\OrderUpdateAction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Repositories\OrderRepository;
use App\Builders\GeneralRequestBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PlaceToPayPaymentService extends PaymentService
{
    private OrderRepository $orderRepository;
    private CreatePlaceToPayAuthAction $placeToPayAuthAction;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->placeToPayAuthAction = new CreatePlaceToPayAuthAction(); 
    }

    public function pay(Request $request, GeneralRequestBuilder $builtRequest): RedirectResponse
    {
        Log::info('Paying with PlaceToPay');

        $orderRepository = $this->orderRepository;

        $orderId = $request->order_id;

        $order = $orderRepository->getOrderById($orderId);
        
        $result = Http::post(config('placetopay.url').'/api/session', $builtRequest->build($order));

        Log::info('Response: '.print_r($result->json()['requestId'], true));
        
        if ($result->ok()) {

            $data = [
                $order->order_number = $result->json()['requestId'],
                $order->url = $result->json()['processUrl']
            ];

            $orderRepository->updateOrder($data, $order);

            return redirect()->to($order->url);

        }

        return back()->with('error', 'Error al realizar el pago');
    }

    public function getPaymentStatus(): View | RedirectResponse
    {
        Log::info('Getting payment status with PlaceToPay');

        $user = auth()->user();

        $lastOrder = $this->orderRepository->getUserLastOrder($user);

        $response = Http::post(config('placetopay.url').'/api/session/'.$lastOrder->order_number, 
            [
                'auth' => $this->placeToPayAuthAction->execute()
            ]
        );

        Log::info('Response: '.print_r($response->json()['status'], true));

        if ($response->ok()) {

            $status = $response->json()['status']['status'];

            if ($status == 'APPROVED') {

                $lastOrder->completed();

                $status = $lastOrder->status;

                OrderUpdateAction::execute($lastOrder);

                Log::info('Order status: '.$status);

            } elseif ($status == 'REJECTED') {

                $lastOrder->rejected();

                $status = $lastOrder->status;

                Log::info('Order status: '.$status);

            } elseif ($status == 'CANCELLED') {

                $lastOrder->cancelled();

                $status = $lastOrder->status;

                Log::info('Order status: '.$status);

            } elseif ($status == 'PENDING') {

                $lastOrder->approved();

                $status = $lastOrder->status;

                Log::info('Order status: '.$status);

            };

            return view('orders.processed', compact('status'));

        };

        return back()->with('error', 'Error al obtener el estado del pago');
    }
}