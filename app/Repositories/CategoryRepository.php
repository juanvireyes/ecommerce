<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    private string $cacheKey = 'categories';

    public function getAllCategories(): Collection
    {
        Cache::forget($this->cacheKey);

        return Cache::remember($this->cacheKey, 60, function () {
            return Category::orderBy('order')->get();
        });
    }

    public function getCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function getCategoryByName(string $name): Builder
    {
        return Category::query()
            ->where('name', 'like', '%'.$name.'%');
    }

    public function getCategoryBySlug(string $slug): Category
    {
        return Category::where('slug', $slug)->first();
    }

    public function createCategory(array $data): Category
    {
        $category = Category::create($data);
        Cache::forget($this->cacheKey);

        return $category;
    }

    public function updateCategory(array $data, Category $category): Category
    {
        $category->update($data);
        Cache::forget($this->cacheKey);

        return $category;
    }

    public function deleteCategory(Category $category): bool
    {
        try {

            $category->delete();
            Cache::forget($this->cacheKey);

            return true;

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return false;

        }
    }
}
