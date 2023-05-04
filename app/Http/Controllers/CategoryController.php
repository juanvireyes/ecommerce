<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    
    public function index(): View
    {
        $categories = DB::table('categories')->orderBy('order')->limit(10)->get();
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
                return redirect()->back()->withErrors($request->validator());
            };

            $validated['image'] = $request->file('image')->store('public');

        };

        $category = Category::create($validated);

        $category->save();

        return redirect()->route('categories.index');
    }

    
    public function edit(Category $category)
    {
        $category->find($category->id);

        $this->authorize('update', $category);

        return view('categories.edit-category', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->find($category->id);

        $this->authorize('update', $category);

        // $request->validate([
        //     'name' => ['string', 'regex:/^[\pL\s]+$/u', 'max:100'],
        //     'description' => 'string|nullable',
        //     'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
        //     'order' => 'integer|unique:categories,order',
        // ]);

        $request->validated();
        $validated['slug'] = Str::of($request->name)->slug('-');

        if ($request->hasFile('image')) {
            // $path = $request->file('image')->store('public');
            $validated['image'] = $request->file('image')->store('public');

            $category->update($validated);
        };

        $category->update($validated);

        session()->flash('success', 'Categoría actualizada correctamente');

        return redirect()->route('categories.edit', $category->id)->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Category $category)
    {
        $category->find($category->id);

        $category->delete();

        return redirect()->route('categories.index');
    }
}
