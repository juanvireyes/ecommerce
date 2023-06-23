<?php

namespace App\Services;

use App\Actions\SetCurrencyTypeAction;

class ExchangeCurrencyService
{
    /**
     * @return string newAmount
     */
    public static function exchange($fromCurrency, $toCurrency, $ammount): string
    {
        $newAmount = $ammount;

        if ($fromCurrency == 'USD' && $toCurrency == 'COP') {

            $newAmount = number_format($ammount * 4189.00, 2);
            SetCurrencyTypeAction::execute(floatval($newAmount));

            return $newAmount;
            
        } elseif ($fromCurrency == 'COP' && $toCurrency == 'USD') {

            $newAmount = number_format($ammount / 4189.00, 2);
            SetCurrencyTypeAction::execute(floatval($newAmount));

            return $newAmount;
        } elseif ($fromCurrency == 'USD' && $toCurrency == 'EUR') {

            $newAmount = number_format($ammount * 0.93, 2);
            SetCurrencyTypeAction::execute(floatval($newAmount));

            return $newAmount;
        } elseif ($fromCurrency == 'EUR' && $toCurrency == 'USD') {

            $newAmount = number_format($ammount / 0.93, 2);
            SetCurrencyTypeAction::execute(floatval($newAmount));

            return $newAmount;
        }

        return $newAmount;
    }
}