<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;

class SubcategoryController extends Controller
{
    public function __construct(private CategoryRepository $categoryRepository, private SubcategoryRepository $subcategoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function index(Request $request): View
    {
        $categories = $this->categoryRepository->getAllCategories();
        $subcategories = $this->getSubcategories($request->input('categoryId'));
        $subcategories->load('category');

        return view('subcategories.index', compact('subcategories', 'categories'));
    }

    private function getSubcategories(int $categoryId = null): Collection
    {
        if ($categoryId) {
            $category = $this->categoryRepository->getCategoryById($categoryId);
            return $this->subcategoryRepository->getSubcategoriesFromCategory($category);
        }

        return $this->subcategoryRepository->getSubcategories();
    }

    public function create(Category $category): View
    {
        $categories = $this->categoryRepository->getAllCategories();

        return view('subcategories.create', compact('categories'));
    }

    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');
        $validated['category_id'] = $request->category_id;


        if ($request->hasFile('image')) {
            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->with('error', 'El archivo no es válido');
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $subcategory = $this->subcategoryRepository->storeSubcategory($validated);
        $subcategory->save();

        return redirect()->route('subcategories.index');
    }

    public function edit(Subcategory $subcategory): View
    {
        $categories = $this->categoryRepository->getAllCategories();
        $this->authorize('update', $subcategory);

        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $this->authorize('update', $subcategory);

        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        };

        $this->subcategoryRepository->updateSubcategory($subcategory, $validated);

        return redirect()->route('subcategories.index')->with('success', 'Información actualizada correctamente');
    }

    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $this->authorize('delete', $subcategory);
        $this->subcategoryRepository->deleteSubcategory($subcategory);

        return redirect()->route('subcategories.index');
    }
}
