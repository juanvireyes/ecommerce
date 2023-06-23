<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Builders\GeneralRequestBuilder;
use App\Services\PlaceToPayPaymentService;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function paymentProcess(Request $request, PlaceToPayPaymentService $service): RedirectResponse
    {
        $builtRequest = new GeneralRequestBuilder();
        $process = $service->pay($request, $builtRequest);

        return $process;
    }

    public function processReturn(PlaceToPayPaymentService $service): View
    {
        Log::info('Llega al processReturn del PaymentController');
        return $service->getPaymentStatus();
    }
}
