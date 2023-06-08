<?php

namespace App\Services;

use App\Builders\GeneralRequestBuilder;
use Illuminate\Http\Request;

abstract class PaymentService
{
    abstract public function pay(Request $request, GeneralRequestBuilder $builtRequest);
}