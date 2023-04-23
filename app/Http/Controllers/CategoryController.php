<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    
    public function index(): View
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        $highestOrder = Category::max('order');

        $orderOptions = [];

        for ($i = 0; $i <= $highestOrder; $i++) {
            $orderOptions[$i] = $i;
        }

        return view('categories.category-form', compact('orderOptions'));
    }

    public function store(Request $request): RedirectResponse
    {   
        $request->validate([
            'name' => 'required|string|alpha|max:100',
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048',
            'order' => 'integer',
        ]);

        // $path = $request->file('image')->store('Categories', 'gcs');
        // $path = Storage::disk('gcs')->put('Categories', $request->file('image'));
        $path = $request->file('image')->store('public');

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::of($request->name)->slug(''),
            'description' => $request->description,
            'image' => $path,
            'order' => $request->order,
        ]);

        $category->save();

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
