<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductFormRequest;
use App\Http\Requests\UpdateProductFormRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SubcategoryRepository;

class ProductController extends Controller
{
    private $categoryRepository;
    private $subcategoryRepository;
    private $productRepository;

    public function __construct(CategoryRepository $categoryRepository, SubcategoryRepository $subcategoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
    }


    public function index(Request $request): View
    {
        $categories = $this->categoryRepository->getAllCategories();
        
        $categoryId = $request->categoryId;

        if ($categoryId) {

            $category = $this->categoryRepository->getCategoryById($categoryId);
            
            $subcategories = $this->subcategoryRepository->getSubcategoriesFromCategory($category);

            $subcategoryId = $request->subcategoryId;

            if ($subcategoryId) {
    
                $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategoryId);

                $products = $this->productRepository->getProductsBySubcategory($subcategory);

                return view('products.index', compact('categories', 'categoryId', 'subcategories', 'subcategoryId', 'products'));

            } else {

                $products = $this->productRepository->getAllProducts();

                return view('products.index', compact('categories', 'categoryId', 'subcategories', 'products', 'subcategoryId'));
            };
        } else {

            $products = $this->productRepository->getAllProducts();

            return view('products.index', compact('categories', 'categoryId', 'products'));
        };

    }


    public function create(Request $request): View
    {
        $categories = $this->categoryRepository->getAllCategories();

        $categoryId = $request->categoryId;

        if ($categoryId) {
            $subcategories = $this->subcategoryRepository->getSubcategoriesFromCategory($categoryId);

            $subcategory_id = $request->subcategory_id;

            return view('products.create', compact('categories', 'categoryId', 'subcategories', 'subcategory_id'));
            
        } else {

            return view('products.create', compact('categories', 'categoryId'));
        };
    }


    public function store(StoreProductFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');

        if ($request->hasFile('image')) {

            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->withErrors($request->validator());
            };

            $validated['image'] = $request->file('image')->store('products');
        };

        if ($validated['stock'] > 0) {
            $validated['active'] = true;
        };

        $product = $this->productRepository->createProduct($validated);

        $product->save();

        return redirect()->route('products.index');
        
    }

    public function edit(Product $product, Request $request): View
    {
        $product->find($product->id);

        $categories = $this->categoryRepository->getAllCategories();

        $categoryId = $request->categoryId;

        if ($categoryId) {

            $category = $this->categoryRepository->getCategoryById($categoryId);

            $subcategories = $this->subcategoryRepository->getSubcategoriesFromCategory($category);

            $subcategory_id = $request->subcategory_id;

            if ($subcategory_id) {

                $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategory_id);

                return view('products.edit', compact('categories', 'categoryId', 'subcategories', 'subcategory_id', 'product'));
            } else {

                return view('products.edit', compact('categories', 'categoryId', 'subcategories', 'product'));

            };
        } else {

            return view('products.edit', compact('categories', 'categoryId', 'product'));

        };
    }

    public function update(UpdateProductFormRequest $request, Product $product): RedirectResponse
    {
        $product = Product::find($product->id);

        $this->authorize('update', $product);
        
        $validated = $request->validated();

        if ($request->hasFile('image')) {

            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->withErrors($request->validator());
            };

            $validated['image'] = $request->file('image')->store('products');
        };

        if ($validated['stock'] > 0) {
            $validated['active'] = true;
        };

        $product->update($validated);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product = Product::find($product->id);

        $product->delete();

        return  redirect()->route('products.index');
    }
}
