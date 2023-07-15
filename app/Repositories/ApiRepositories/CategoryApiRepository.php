<?php

namespace App\Repositories\ApiRepositories;

use App\Models\Category;
use App\Repositories\ApiRepositories\ApiContracts\CategoryApiRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryApiRepository implements CategoryApiRepositoryInterface
{
    public function getAllCategories(): LengthAwarePaginator
    {
        return Category::query()
            ->latest()
            ->paginate(12);
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category): Category
    {
        $category->delete();
        return $category;
    }
}
