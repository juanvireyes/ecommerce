<?php

namespace App\Repositories\ApiRepositories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SubcategoryApiRepository implements ApiContracts\SubcategoryApiRepositoryInterface
{

    public function getAllSubcategories(): LengthAwarePaginator
    {
        return Subcategory::query()->with('category')
            ->orderBy('id')
            ->paginate(10);
    }

    public function filterSubcategoryByName(string $name): Builder
    {
        return Subcategory::query()->with('category')
            ->where('name', 'like', '%'.$name.'%');
    }

    public function getSubcategoriesFromCategory(string $name): Builder
    {
        return Subcategory::query()->whereHas('category', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->with('category');
    }

    public function createSubcategory(array $data): Subcategory
    {
        return Subcategory::create($data);
    }

    public function updateSubcategory(Subcategory $subcategory, array $data): Subcategory
    {
        $subcategory->update($data);
        return $subcategory;
    }

    public function deleteSubcategory(Subcategory $subcategory): Subcategory
    {
        $subcategory->delete();
        return $subcategory;
    }
}
