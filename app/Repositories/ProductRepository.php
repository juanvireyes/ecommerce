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

    private $subcategoryRepository;

    public function __construct(SubcategoryRepository $subcategoryRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
    }

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

    public function getProductsBySubcategory(Subcategory $subcategory): Collection
    {
        // return $subcategory->products()->orderBy('order')->get();
        $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategory->id);

        return $subcategory->products;
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