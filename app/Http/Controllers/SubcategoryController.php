<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Subcategory;
use Illuminate\Http\Request;

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

    
    public function store(Request $request)
    {
        
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
