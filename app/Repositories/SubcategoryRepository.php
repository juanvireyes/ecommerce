<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\SubcategoryRepositoryInterface;

class SubcategoryRepository implements SubcategoryRepositoryInterface
{
    private string $cacheKey = 'subcategories';

    public function getSubcategories(): Collection
    {
        Cache::forget($this->cacheKey);

        return Cache::remember($this->cacheKey, 10, function () {
            return Subcategory::with('category')->orderBy('order')->get();
        });
    }

    public function getSubcategoriesFromCategory(Category $category): Collection
    {
        $category->load('subcategories');
        return $category->subcategories;
    }

    public function getSubcategoryById(int $id): Subcategory
    {
        return Subcategory::findOrFail($id);
    }

    public function getSubcategoryBySlug(string $slug): Subcategory
    {
        return Subcategory::where('slug', $slug)->first();
    }

    public function getSubcategoryByName(string $name): Subcategory
    {
        return Subcategory::where('name', $name)->first();
    }

    public function storeSubcategory(array $data): Subcategory
    {
        $subcategory = Subcategory::create($data);
        Cache::forget($this->cacheKey);

        return $subcategory;
    }

    public function updateSubcategory(Subcategory $subcategory, array $data): Subcategory
    {
        $subcategory->update($data);
        Cache::forget($this->cacheKey);

        return $subcategory;
    }

    public function deleteSubcategory(Subcategory $subcategory): bool
    {
        try {

            $subcategory->delete();

            Cache::forget($this->cacheKey);

            return true;

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return false;
        };
    }
}
