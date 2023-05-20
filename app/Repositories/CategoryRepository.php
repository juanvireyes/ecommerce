<?php

namespace App\Repositories;

use App\Models\Category;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $cacheKey = 'categories';

    public function getAllCategories(): Collection
    {
        $categories = Cache::remember($this->cacheKey, 60, function () {
            return Category::orderBy('order')->get();
        });

        return $categories;
    }

    public function getCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function getCategoryByName(string $name): Category
    {
        return Category::where('name', $name)->first();
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

        };
    }
}