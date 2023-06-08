<?php

namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Str;

class CreatePlaceToPayAuthAction
{
    public function execute(): array
    {
        return $this->createAuth();
    }

    private function createAuth(): array
    {
        $nonce = Str::random();
        $seed = Carbon::now()->toIso8601String();
        
        return [
            'login' => config('placetopay.login'),
            'tranKey' => base64_encode(
                hash(
                    'sha256',
                    $nonce . $seed . config('placetopay.trankey'),
                    true 
                )
            ),
            'nonce' => base64_encode($nonce),
            'seed' => $seed
        ];
    }
}