<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class TestingController extends Controller
{
    public function index(Request $request, ProductRepository $productRepository): View
    {
        $products = $productRepository->getAllProducts();

        if($request->search) {
            $products = $productRepository->getProductsByName($request->search);
        }

        return view('testing.testing-index', compact('products'));
    }
}
