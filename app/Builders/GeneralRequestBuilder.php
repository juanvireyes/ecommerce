<?php

namespace App\Builders;

use Carbon\Carbon;
use App\Models\Order;
use App\Builders\BuyerRequestBuilder;
use App\Repositories\OrderRepository;
use App\Actions\CreatePlaceToPayAuthAction;

/**
 * @property Order $order
 * @property BuyerRequestBuilder $buyerBuilder
 * @property PaymentRequestBuilder $paymentBuilder
 * @property CreatePlaceToPayAuthAction $auth
 * @property OrderRepository $orderRepository
 * @property Carbon $expiration
 * @property string $returnUrl
 * @property string $ipAddress
 * @property string $userAgent
 * @property array $autArray
 * @property array $buyer
 * @property array $payment
 * @property array $request
 * @property array $response
 * @property array $result
 * @property User $user
 */
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

}