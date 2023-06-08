<?php

namespace App\Builders;

use Carbon\Carbon;
use App\Models\Order;
use App\Builders\BuyerRequestBuilder;
use App\Repositories\OrderRepository;
use App\Actions\CreatePlaceToPayAuthAction;

class GeneralRequestBuilder
{
    public function build(Order $order): array
    {
        $auth = new CreatePlaceToPayAuthAction();

        $autArray = $auth->execute();

        $buyerBuilder = new BuyerRequestBuilder();

        $user = auth()->user();

        if ($user) {

            $orderRepository = new OrderRepository();

            $order = $orderRepository->getOrderById($order->id);

            $buyer = $buyerBuilder->build($user);

            $paymentBuilder = new PaymentRequestBuilder();

            $payment = $paymentBuilder->build($order, $user);


            return [
                'auth' => $autArray,
                'buyer' => $buyer,
                'payment' => $payment,
                'expiration' => Carbon::now()->addHour()->toString(),
                'returnUrl' => route('payment.processed'),
                'ipAddress' => request()->ip(),
                'userAgent' => request()->userAgent(),
            ];
        };

        return [];
    }

    public function addField(string $key = null, string $value): string
    {
        return $key . ':' . $value;
    }

    public function getOrder(): Order
    {
        $order = auth()->user()->orders->last();

        return $order;
    }
}