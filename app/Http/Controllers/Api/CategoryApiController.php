<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCategoryApiRequest;
use App\Http\Requests\Api\UpdateCategoryApiRequest;
use App\Models\Category;
use App\Repositories\ApiRepositories\CategoryApiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryApiController extends Controller
{
    public function __construct(public CategoryApiRepository $data)
    {}

    public function index(): JsonResponse
    {
        $categories = $this->data->getAllCategories();
        return response()->json([
            'data' => $categories
        ]);
    }

    public function store(StoreCategoryApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name'], '-');

        if ($request->hasFile('image')) {
            if  (!$request->file('image')->isValid()) {
                return response()->json([
                    'Error' => 'El formato de la imagen no es válido'
                ]);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $category = $this->data->createCategory($validated);
        return response()->json([
            'created_category' => $category
        ], 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'category' => $category
        ]);
    }

    public function update(Category $category, UpdateCategoryApiRequest $req): JsonResponse
    {
        $updated = $req->validated();
        $updated['slug'] = Str::slug($updated['name'], '-');

        if ($req->hasFile('image')) {
            if  (!$req->file('image')->isValid()) {
                return response()->json([
                    'Error' => 'El formato de la imagen no es válido'
                ]);
            }

            $updated['image'] = $req->file('image')->store('public');
        }

        $updatedCategory = $this->data->updateCategory($category, $updated);

        return response()->json([
            'updated_category' => $updatedCategory
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category = $this->data->deleteCategory($category);
        return response()->json([
            'message' => 'Categoría eliminada correctamente',
            'deleted_category' => $category
        ]);
    }
}
