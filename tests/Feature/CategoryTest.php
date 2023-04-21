<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_categories_list_page_loads_successfully(): void
    {
        $response = $this->get('/categories');

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
    }
}
