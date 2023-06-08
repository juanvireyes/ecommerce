<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Builders\GeneralRequestBuilder;
use Illuminate\Support\Facades\Redirect;
use App\Services\PlaceToPayPaymentService;

class PaymentController extends Controller
{
    public function paymentProcess(Request $request, PlaceToPayPaymentService $service): RedirectResponse
    {
        // dd($request->all());

        $builtRequest = new GeneralRequestBuilder();

        $process = $service->pay($request, $builtRequest);

        // dd($process);

        return $process;
    }


    public function processReturn(PlaceToPayPaymentService $service)
    {
        Log::info('Llega al processReturn del PaymentController');

        // dd('Hello');
        
        return $service->getPaymentStatus();
    }
}
