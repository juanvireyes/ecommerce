<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;

class ClientSubcategoryController extends ClientController
{
    private $categoryRepository;
    private $subcategoryRepository;

    public function __construct(CategoryRepository $categoryRepository, SubcategoryRepository $subcategoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function subCategories(string $categorySlug): View
    {
        $category = $this->categoryRepository->getCategoryBySlug($categorySlug);
        $subCategories = $this->subcategoryRepository->getSubcategoriesFromCategory($category);

        return view('clients.subCategories', ['subCategories' => $subCategories], compact('category'));
    }
}
