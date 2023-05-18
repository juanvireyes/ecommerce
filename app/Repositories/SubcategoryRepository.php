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
    private $cacheKey = 'subcategories';

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getSubcategories(): Collection
    {
        $subcategories = Cache::remember($this->cacheKey, 10, function () {
            return Subcategory::with('category')->orderBy('order')->get();
        });

        return $subcategories;
    }

    public function getSubcategoriesFromCategory(Category $category): Collection
    {
        $category = $this->categoryRepository->getCategoryById($category->id);

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