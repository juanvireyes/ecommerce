<?php

namespace App\Http\Controllers;

use App\Actions\UpdateProductStatusAction;
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

    public function updateAllProducts(UpdateProductStatusAction $action)
    {
        return $action->execute();
    }
}
