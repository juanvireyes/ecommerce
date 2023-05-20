<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;

class TestingController extends Controller
{
    private $subcategoryRepository;
    private $productRepository;
    private $categoriesRepository;

    public function __construct(CategoryRepository $categoryRepository, SubcategoryRepository  $subcategoryRepository, ProductRepository $productRepository)
    {
        $this->categoriesRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request, Subcategory $subcategory): View
    {
        // dd($request->all());
        
        $categories = $this->categoriesRepository->getAllCategories();

        $categoryId = $request->categoryId;

        // dd($categoryId);

        if ($categoryId != null) {

            $category = $this->categoriesRepository->getCategoryById($categoryId);

            // dd($category);

            $subcategories = $this->subcategoryRepository->getSubcategoriesFromCategory($category);

            // dd($subcategories);

            $subcategoryId = $request->subcategoryId;
            
            if ($subcategoryId) {

                $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategoryId);

                $products = $this->productRepository->getProductsBySubcategory($subcategory);
                
                return view('testing', compact('categories', 'categoryId', 'subcategories', 'subcategoryId', 'products', 'subcategory'));
            };

        };
        
        $products = $this->productRepository->getAllProducts();

        // dd($request->order);
        if ($request->price == 'asc') {
            $products = $this->productRepository->orderProductsByPrice($request->price);
        } elseif ($request->price == 'desc') {
            $products = $this->productRepository->orderProductsByPrice($request->price);
        };

        return view('testing', compact('categories', 'products'));
        
    }
}
