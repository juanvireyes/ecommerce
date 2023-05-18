<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAllProducts() : LengthAwarePaginator;

    public function getProductById(int $id) : Product;

    public function createProduct(array $data) : Product;

    public function updateProduct(Product $product, array $data) : Product;

    public function deleteProduct(Product $product) : bool;
}