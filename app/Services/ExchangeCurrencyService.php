<?php

namespace App\Services;

use App\Actions\SetCurrencyTypeAction;
use Hamcrest\Core\Set;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ExchangeCurrencyService
{
    public static function exchange($fromCurrency, $toCurrency, $ammount)
    {
        if ($fromCurrency == 'USD' && $toCurrency == 'COP') {

            $newAmount = number_format($ammount * 4189.00, 2);

            SetCurrencyTypeAction::execute($newAmount);

            return $newAmount;
        } elseif ($fromCurrency == 'COP' && $toCurrency == 'USD') {

            $newAmount = number_format($ammount / 4189.00, 2);

            SetCurrencyTypeAction::execute($newAmount);

            return $newAmount;
        } elseif ($fromCurrency == 'USD' && $toCurrency == 'EUR') {

            $newAmount = number_format($ammount * 0.93, 2);

            SetCurrencyTypeAction::execute($newAmount);

            return $newAmount;
        } elseif ($fromCurrency == 'EUR' && $toCurrency == 'USD') {

            $newAmount = number_format($ammount / 0.93, 2);

            SetCurrencyTypeAction::execute($newAmount);

            return $newAmount;
        }

    }
}