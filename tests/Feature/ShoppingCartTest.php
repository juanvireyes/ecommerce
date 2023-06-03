<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    /** @test */
    public function shopping_cart_page_loads_successfully(): void
    {
        $response = $this->get(route('cart.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function shopping_cart_page_has_content(): void
    {
        //
    }
}
