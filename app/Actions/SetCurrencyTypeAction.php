<?php

namespace App\Actions;

class SetCurrencyTypeAction
{
    public static function execute(float|int $ammount)
    {
        $ammountLenght = strlen((string)$ammount);

        if ($ammountLenght > 8) {

            return 'COP';

        } else {

            return 'USD';

        };
    }
}