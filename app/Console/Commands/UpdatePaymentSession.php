<?php

namespace App\Console\Commands;

use App\Models\Order;
use Google\CRC32\PHP;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Actions\CreatePlaceToPayAuthAction;

/**
 * @property string $signature
 * @property string $description
 * @property Model $order
 * @property string $status
 * @property string $order_number
 */
class UpdatePaymentSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-payment-session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for a checkout existing session and update it';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $orders = Order::query()->where('status', '=', 'PENDING')->get();

        $placeToPayAuthAction = new CreatePlaceToPayAuthAction();

        $response = null;

        foreach ($orders as $order) {
            
            echo $order->order_number.PHP_EOL;

            
            $response = Http::post(config('placetopay.url').'/api/session/'.$order->order_number, 
                [
                    'auth' => $placeToPayAuthAction->execute()
                ]);
        };

        if ($response->ok()) {

            $status = $response->json()['status']['status'];

            if ($status == 'APPROVED') {

                // @phpstan-ignore-next-line
                $order->completed();

            } elseif ($status == 'REJECTED') {

                // @phpstan-ignore-next-line
                $order->rejected();


            } elseif ($status == 'CANCELLED') {

                // @phpstan-ignore-next-line
                $order->cancelled();

            } elseif ($status == 'APPROVED_PARTIAL') {

                // @phpstan-ignore-next-line
                $order->approved();

            };

        };
    }
}
