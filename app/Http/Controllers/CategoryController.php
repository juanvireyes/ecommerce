<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request): RedirectResponse
    {   
        $request->validate([
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'order' => 'integer|unique:categories,order',
        ],  [
            'name.regex' => 'El nombre solo puede contener letras y espacios',
            'order.unique' => 'El orden en el display que quieres asignar ya está ocupado'
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
        $category->find($category->id);

        $this->authorize('update', $category);

        return view('categories.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->find($category->id);

        $this->authorize('update', $category);

        $request->validate([
            'name' => ['string', 'regex:/^[\pL\s]+$/u', 'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'order' => 'integer|unique:categories,order',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public');

            $category->update([
                'name' => $request->name,
                'slug' => Str::of($request->name)->slug(''),
                'description' => $request->description,
                'image' => $path,
                'order' => $request->order,
            ]);
        };

        $category->update([
            'name' => $request->name,
            'slug' => Str::of($request->name)->slug(''),
            'description' => $request->description,
            'order' => $request->order,
        ]);

        session()->flash('success', 'Categoría actualizada correctamente');

        return redirect()->route('categories.edit', $category->id)->with('success', 'Categoría actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
