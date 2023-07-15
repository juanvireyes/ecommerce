<?php

namespace App\Repositories\ApiRepositories;

use App\Models\Product;
use App\Repositories\ApiRepositories\ApiContracts\ProductApiRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductApiRepository implements ProductApiRepositoryInterface
{

    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::query()->with('subcategory')
            ->latest()
            ->paginate(12);
    }

    public function getProductByName(string $name): Builder
    {
        return Product::query()
            ->where('name', 'like', '%' . $name . '%')
            ->with('subcategory');
    }

    public function getProductsBySubcategory(string $name): Builder
    {
        return Product::query()
            ->whereHas('subcategory', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->with('subcategory');
    }

    public function getProductsUnderPrice(string $price): LengthAwarePaginator
    {
        return Product::query()
            ->where('price', '<=', $price)
            ->orderBy('price', 'desc')
            ->with('subcategory')->paginate(10);
    }

    public function getProductsOverPrice(string $price): LengthAwarePaginator
    {
        return Product::query()->where('price', '>=', $price)
            ->orderBy('price')
            ->with('subcategory')->paginate(10);
    }

    public function getProductsByPriceRange(string $min, string $max): Builder
    {
        return Product::query()->whereBetween('price', [$min, $max])
            ->orderBy('price')
            ->with('subcategory');
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function deleteProduct(Product $product): Product
    {
        $product->delete();
        return $product;
    }
}
