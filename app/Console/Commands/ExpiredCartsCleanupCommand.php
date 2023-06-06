<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Console\Command;

class ExpiredCartsCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:cleanup-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired carts';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $expiredCarts = Cart::where('expires_at', '<=', Carbon::now())->get();

        foreach ($expiredCarts as $cart) {

            $cart->clearCart();
            
            $cart->delete();

        };

        $this->info('Expired carts deleted');
    }
}
