<?php

namespace App\Repositories\ApiRepositories\ApiContracts;

use App\Models\Subcategory;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubcategoryApiRepositoryInterface
{
    public function getAllSubcategories(): LengthAwarePaginator;

    public function createSubcategory(array $data): Subcategory;

    public function updateSubcategory(Subcategory $subcategory, array $data): Subcategory;

    public function deleteSubcategory(Subcategory $subcategory): Subcategory;
}
