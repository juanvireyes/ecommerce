<?php

namespace App\Repositories\ApiRepositories\ApiContracts;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryApiRepositoryInterface
{
    public function getAllCategories(): LengthAwarePaginator;

    public function createCategory(array $data): Category;

    public function updateCategory(Category $category, array $data): Category;

    public function deleteCategory(Category $category): Category;
}
