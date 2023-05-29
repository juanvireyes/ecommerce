<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;
use Illuminate\Database\Eloquent\Casts\Json;

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

    // public function index(Request $request, Subcategory $subcategory): View
    // {
    //     // dd($request->all());
        
    //     $categories = $this->categoriesRepository->getAllCategories();

    //     $categoryId = $request->categoryId;

    //     if ($categoryId != null) {

    //         $category = $this->categoriesRepository->getCategoryById($categoryId);

    //         // dd($category);

    //         $subcategories = $this->subcategoryRepository->getSubcategoriesFromCategory($category);

    //         // dd($subcategories);

    //         $subcategoryId = $request->subcategoryId;
            
    //         if ($subcategoryId) {

    //             $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategoryId);

    //             $products = $this->productRepository->getProductsBySubcategory($subcategory);
                
    //             return view('testing', compact('categories', 'categoryId', 'subcategories', 'subcategoryId', 'products', 'subcategory'));
    //         };

    //     };
        
    //     $products = $this->productRepository->getAllProducts();

    //     // dd($request->order);
    //     if ($request->price == 'asc') {
    //         $products = $this->productRepository->orderProductsByPrice($request->price);
    //     } elseif ($request->price == 'desc') {
    //         $products = $this->productRepository->orderProductsByPrice($request->price);
    //     };

    //     return view('testing', compact('categories', 'products'));
        
    // }

    public function index(Request $request): View
    {
        $products = $this->loadProducts();

        return view('testing', compact('products'));
    }

    public function loadProducts(): JsonResponse
    {
        $products = $this->productRepository->getAllProducts();

        return response()->json($products);
    }
}
