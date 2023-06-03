<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;
use App\Repositories\ProductRepository;

class UpdateProductStatusAction
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        $products = $this->productRepository->getProductsByStock();

        foreach ($products as $product) {

            $product->update([$product->active = true]);

        };
    }
}