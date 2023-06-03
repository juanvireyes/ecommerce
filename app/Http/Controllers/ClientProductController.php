<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;

class ClientProductController extends ClientSubcategoryController
{
    private $categoryRepository;
    private $subcategoryRepository;
    private $productRepository;

    public function __construct(CategoryRepository $categoryRepository, 
    SubcategoryRepository $subcategoryRepository, 
    ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;

        $this->subcategoryRepository = $subcategoryRepository;

        $this->productRepository = $productRepository;
    }
    
    public function products(string $categorySlug, string $subcategorySlug): View
    {
        $category = $this->categoryRepository->getCategoryBySlug($categorySlug);
        
        $subcategory = $this->subcategoryRepository->getSubcategoryBySlug($subcategorySlug);

        $products = $this->productRepository->getProductsBySubcategory($subcategory);

        return view('clients.products', compact('category', 'subcategory', 'products'));
    }

    public function show(string $categorySlug, string $subcategorySlug, string $productSlug): View
    {
        $category = $this->categoryRepository->getCategoryBySlug($categorySlug);
        $subcategory = $this->subcategoryRepository->getSubcategoryBySlug($subcategorySlug);
        $product = $this->productRepository->getProductBySlug($productSlug);
        
        return view('clients.product-detail', compact('product',  'category', 'subcategory'));
    }

    
}
