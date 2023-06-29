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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

            $subcategories = $this->getFilteredSubcategories($categoryId);
            $subcategoryId = $request->subcategoryId;
            $products = $this->getFilteredProducts($subcategoryId);

            return view('products.index', compact('categories', 'categoryId', 'subcategories', 'subcategoryId', 'products'));

        } else {

            if ($request->search) {
                $products = $this->productRepository->getProductsByName($request->search);
            }

            $products = $this->productRepository->getAllProducts();

            if ($request->price == 'asc') {   
                $products = $this->productRepository->orderProductsByPrice($request->price);
            } elseif ($request->price == 'desc') {
                $products = $this->productRepository->orderProductsByPrice($request->price);
            }

            return view('products.index', compact('categories', 'categoryId', 'products'));
        }
    }

    private function getFilteredSubcategories(?int $categoryId): Collection
    {
        $category = $this->categoryRepository->getCategoryById($categoryId);
                
        return $this->subcategoryRepository->getSubcategoriesFromCategory($category);
    }

    private function getFilteredProducts(?int $subcategoryId): LengthAwarePaginator
    {
        if ($subcategoryId) {
            $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategoryId);

            return $this->productRepository->getProductsBySubcategory($subcategory);
        }

        return $this->productRepository->getAllProducts();
    }

    public function create(Request $request): View
    {
        $categories = $this->categoryRepository->getAllCategories();
        $categoryId = $request->categoryId;

        if ($categoryId) {
            $subcategories = $this->getFilteredSubcategories($categoryId);
            $subcategory_id = $request->subcategory_id;

            return view('products.create', compact('categories', 'categoryId', 'subcategories', 'subcategory_id'));
        }

        return view('products.create', compact('categories', 'categoryId'));
    }

    public function store(StoreProductFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');

        if ($request->hasFile('image')) {

            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->withErrors($request->validator()); // @phpstan-ignore-line
            }

            $validated['image'] = $request->file('image')->store('public/products');
        }

        if ($validated['stock'] > 0) {
            $validated['active'] = true;
        }

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
            $subcategories = $this->getFilteredSubcategories($categoryId);
            $subcategory_id = $request->subcategory_id;

            if ($subcategory_id) {
                $subcategory = $this->subcategoryRepository->getSubcategoryById($subcategory_id);

                return view('products.edit', compact('categories', 'categoryId', 'subcategories', 'subcategory_id', 'product'));

            } else {

                return view('products.edit', compact('categories', 'categoryId', 'subcategories', 'product'));

            }
        }

        return view('products.edit', compact('categories', 'categoryId', 'product'));
    }

    public function update(UpdateProductFormRequest $request, Product $product): RedirectResponse
    {
        $product = Product::find($product->id);
        $this->authorize('update', $product);
        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');

        if ($request->hasFile('image')) {

            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->withErrors($request->validator()); // @phpstan-ignore-line
            }

            $validated['image'] = $request->file('image')->store('public/products');
        }

        if ($validated['stock'] > 0) {
            $validated['active'] = true;
        }

        $product->update($validated);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return  redirect()->route('products.index');
    }
}
