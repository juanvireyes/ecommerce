<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubcategoryRequest;

class SubcategoryController extends Controller
{
    
    public function index(): View
    {
        $subcategories = Subcategory::all();

        return view('subcategories.index', compact('subcategories'));
    }


    public function create(Category $category): View
    {
        $categories = Category::all();

        return view('subcategories.create', compact('categories'));
    }

    
    public function store(StoreSubcategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::of($validated['name'])->slug('-');
        $validated['category_id'] = $request->category_id;

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

    
    public function show(Subcategory $subcategory)
    {
        //
    }

    
    public function edit(Subcategory $subcategory)
    {
        //
    }

    
    public function update(Request $request, Subcategory $subcategory)
    {
        //
    }

    
    public function destroy(Subcategory $subcategory)
    {
        //
    }
}
