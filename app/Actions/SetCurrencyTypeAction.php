<?php

namespace App\Actions;

class SetCurrencyTypeAction
{
    public static function execute(float|int $ammount)
    {
        $ammountLenght = strlen((string)$ammount);

        if ($ammountLenght >= 6) {

            return 'COP';

        } else {

            return 'USD';

        };

        return 'EUR';
    }
}