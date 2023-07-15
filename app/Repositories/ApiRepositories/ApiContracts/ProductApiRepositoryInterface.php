<?php

namespace App\Repositories\ApiRepositories\ApiContracts;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductApiRepositoryInterface
{
    public function getAllProducts(): LengthAwarePaginator;

    public function createProduct(array $data): Product;

    public function updateProduct(Product $product, array $data): Product;

    public function deleteProduct(Product $product): Product;
}
