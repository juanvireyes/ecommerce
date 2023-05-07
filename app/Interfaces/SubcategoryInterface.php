<?php

namespace App\Interfaces;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;

interface SubcategoryInterface {
    public function getSubcategoriesFromCategory(int $categoryId): Collection;

    public function getSubcategory(Subcategory $subcategory): int;
}