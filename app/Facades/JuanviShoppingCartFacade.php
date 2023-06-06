<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class JuanviShoppingCartFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'juanvishoppingcart';
    }

    public static function addToCart($product_id, $quantity)
    {
        //
    }
}