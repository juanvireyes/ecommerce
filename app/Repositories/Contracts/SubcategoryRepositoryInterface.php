<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;

interface SubcategoryRepositoryInterface
{
    public function getSubcategories(): Collection;

    public function getSubcategoriesFromCategory(Category $category): Collection;

    public function storeSubcategory(array $data): Subcategory;

    public function updateSubcategory(Subcategory $subcategory, array $data): Subcategory;

    public function deleteSubcategory(Subcategory $subcategory): bool;
}
