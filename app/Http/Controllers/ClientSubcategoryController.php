<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ClientSubcategoryController extends ClientController
{
    public function subCategories(string $categorySlug): View
    {
        $category = $this->getCategoryBySlug($categorySlug);
        $subCategories = $this->getSubCategories($category);

        return view('clients.subCategories', ['subCategories' => $subCategories], compact('category'));
    }

    private function getSubCategories(Category $category): array
    {
        return $category->subCategories()->get()->sortBy('order')->toArray();
    }

}
