<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\SubcategoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreProductFormRequest;
use App\Http\Requests\UpdateProductFormRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ProductController extends Controller implements CategoryInterface, SubcategoryInterface
{
    
    public function index(Request $request): View
    {
        $categories = $this->getAllCategories();
        
        $categoryId = $request->categoryId;

        if ($categoryId) {

            $subcategories = $this->getSubcategoriesFromCategory($categoryId);

            $subcategoryId = $request->subcategoryId;

            if ($subcategoryId) {

                $products = $this->getProductsBySubcategory($subcategoryId);

                return view('products.index', compact('categories', 'categoryId', 'subcategories', 'subcategoryId', 'products'));

            } else {

                $products = $this->getProducts();

                return view('products.index', compact('categories', 'categoryId', 'subcategories', 'products'));
            };
        } else {

            $products = $this->getProducts();

            return view('products.index', compact('categories', 'categoryId', 'products'));
        };

    }

    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    public function getCategoryBySlug(?string $slug):  Category
    {
        return Category::where('slug', $slug)->first();
    }

    public function getSubcategoriesFromCategory(int $categoryId): Collection
    {
        $categoryId = Category::find($categoryId);

        return $categoryId->subcategories;
    }

    public function getSubcategory(Subcategory $subcategory): int
    {
        $subcategoyId = $subcategory->id;

        return $subcategoyId;
    }

    private function getProductsBySubcategory(int $subcategoryId): EloquentBuilder
    {
        return  Product::where('subcategory_id', $subcategoryId)->orderBy('order')->paginate(12);
    }

    private function getProducts(): LengthAwarePaginator
    {
        return Product::orderBy('order')->paginate(12);
    }


    public function create(Request $request): View
    {
        $categories = $this->getAllCategories();

        $categoryId = $request->categoryId;

        if ($categoryId) {
            $subcategories = $this->getSubcategoriesFromCategory($categoryId);

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

        $product = Product::create($validated);

        $product->save();

        return redirect()->route('products.index');
        
    }

    public function edit(Product $product, Request $request): View
    {
        $product->find($product->id);

        $categories = $this->getAllCategories();

        $categoryId = $request->categoryId;

        if ($categoryId) {

            $subcategories = $this->getSubcategoriesFromCategory($categoryId);

            $subcategory_id = $request->subcategory_id;

            if ($subcategory_id) {

                $subcategory = $this->getSubcategory($subcategory_id);

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

        if ($validated['stock'] == 0) {
            $validated['active'] = false;
        } else {
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
