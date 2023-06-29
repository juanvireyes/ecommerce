<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductRepositoryInterface
{
    private $cacheKey = 'products';

    public function getAllProducts(): LengthAwarePaginator
    {
        $products = Cache::remember($this->cacheKey, 15, function () {
            return Product::with('subcategory')->orderBy('order')->paginate(20);
        });

        return $products;
    }

    public function getProductById(int $id): Product
    {
        $product = Product::with('subcategory')->findOrFail($id);

        return $product;
    }

    public function orderProductsByPrice(string $sortBy): LengthAwarePaginator
    {
        $products = Product::with('subcategory')->orderBy('price', $sortBy);

        return $products->paginate(20);
    }

    public function orderFilteredProductsByPrice(Subcategory $subcategory, string $sortBy): LengthAwarePaginator
    {
        return $subcategory->products()->orderBy('price', $sortBy)->paginate(20);
    }

    public function getProductsBySubcategory(Subcategory $subcategory): LengthAwarePaginator
    {
        return $subcategory->products()->with('subcategory')->orderBy('order')->paginate(20);
        
    }

    public function getProductsByName(string $name): LengthAwarePaginator
    {
        return Product::where('name', 'LIKE', '%' . $name . '%')
                ->with('subcategory')->paginate(20);
    }

    public function getProductBySlug(string $slug): Product
    {
        return Product::where('slug', $slug)->firstOrFail();
    }

    public function getProductsByStock(): Collection
    {
        return Product::where('stock', '>', 0)->get();
    }

    public function createProduct(array $data): Product
    {
        $product = Product::create($data);

        Cache::forget($this->cacheKey);

        return $product;
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->update($data);

        Cache::forget($this->cacheKey);

        return $product;
    }

    public  function deleteProduct(Product $product): bool
    {
        try {

            $product->delete();

            Cache::forget($this->cacheKey);

            return true;

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return false;

        };
    }
}