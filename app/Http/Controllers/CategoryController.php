<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use App\Repositories\CategoryRepository;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): View
    {
        $categories = $this->categoryRepository->getAllCategories();
        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.category-form');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::of($request->name)->slug('-');

        if ($request->hasFile('image')) {
            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->with('error', 'Error al subir la imagen');
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $category = $this->categoryRepository->createCategory($validated);
        $category->save();

        return redirect()->route('categories.index');
    }

    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.edit-category', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);
        $validated = $request->validated();
        $validated['slug'] = Str::of($request->name)->slug('-');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $category->update($validated);

        return redirect()->route('categories.edit', $category->id)->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
