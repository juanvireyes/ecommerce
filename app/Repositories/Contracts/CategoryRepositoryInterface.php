<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface {

    public function getAllCategories(): Collection;

    public function getCategoryById(int $id): ?Category;

    public function createCategory(array $data): Category;

    public function updateCategory(array $data, Category $category): Category;

    public function deleteCategory(Category $category): bool;
}