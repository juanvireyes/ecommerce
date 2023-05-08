<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientProductController extends ClientSubcategoryController
{
    public function products(string $categorySlug, string $subcategorySlug): View
    {
        $category = $this->getCategoryBySlug($categorySlug);
        
        $subcategory = $this->getSubcategoryBySlug($subcategorySlug);

        $products = $this->getProducts($subcategory);

        return view('clients.products', compact('category', 'subcategory', 'products'));
    }

    private function getProducts(Subcategory $subcategory): array
    {
        return $subcategory->products()->get()->toArray();
    }

    public function show(Product $product)
    {
        $product = Product::find($product->id);
        dd($product);
        return view('clients.product-detail', compact('product'));
    }

    
}
