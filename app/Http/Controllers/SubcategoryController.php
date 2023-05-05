<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreSubcategoryRequest;
use Illuminate\Database\Eloquent\Collection;

class SubcategoryController extends Controller
{
    
    public function index(): View
    {
        $subcategories = $this->getSubcategory();

        return view('subcategories.index', compact('subcategories'));
    }

    private function getSubcategory(): Collection
    {
        return Subcategory::with('category')->get();
    }


    public function create(Category $category): View
    {
        $categories = Category::all();

        return view('subcategories.create', compact('categories'));
    }

    
    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');
        $validated['category_id'] = $request->category_id;
        // dd($validated);
        if ($request->hasFile('image')) {
            if  (!$request->file('image')->isValid()) {
                return redirect()->back()->withErrors($request->validator());
            };

            $validated['image'] = $request->file('image')->store('public');
        };

        

        $subcategory = Subcategory::create($validated);

        $subcategory->save();

        return redirect()->route('subcategories.index');
    }

    
    public function edit(Subcategory $subcategory): View
    {
        $subcategory->find($subcategory->id);

        $categories = Category::all();

        $this->authorize('update', $subcategory);

        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    
    public function update(StoreSubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $subcategory->find($subcategory->id);

        $this->authorize('update', $subcategory);

        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        };

        $subcategory->update($validated);

        session()->flash('success', 'Información actualizada correctamente');

        return redirect()->route('subcategories.index')->with('success', 'Información actualizada correctamente');
    }

    
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->find($subcategory->id);

        $subcategory->delete();

        return redirect()->route('subcategories.index');
    }
}