<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSubcategoryApiRequest;
use App\Http\Requests\Api\UpdateSubcategoryApiRequest;
use App\Models\Subcategory;
use App\Repositories\ApiRepositories\SubcategoryApiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryApiController extends Controller
{
    public function __construct(private SubcategoryApiRepository $data) {}

    public function index(Request $request): JsonResponse
    {
        $subcategory = $request->query('subcategory');
        $category = $request->query('category');

        if ($subcategory) {
            $filteredSubcategory = $this->data->filterSubcategoryByName($subcategory);

            return response()->json([
               'subcategories' => $filteredSubcategory->get()
            ]);
        }

        if ($category) {
            $filteredSubcategory = $this->data->getSubcategoriesFromCategory($category);

            return response()->json([
               'subcategories' => $filteredSubcategory->get()
            ]);
        }

        return response()->json([
            'subcategories' => $this->data->getAllSubcategories()
        ]);
    }

    public function store(StoreSubcategoryApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name'], '-');

        if ($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                return response()->json([
                    'message' => 'El formato de la imagen es inválido'
                ], 400);
            }
            $validated['image'] = $request->file('image')->store('public');
        }

        $subcategory = $this->data->createSubcategory($validated);
        return response()->json([
            'created_subcategory' => $subcategory
        ], 201);
    }

    public function show(Subcategory $subcategory): JsonResponse
    {
        return response()->json([
            'subcategory' => $subcategory
        ]);
    }

    public function update(UpdateSubcategoryApiRequest $req, Subcategory $subcategory): JsonResponse
    {
        $validated = $req->validated();
        $validated['slug'] = Str::slug($validated['name']);

        if ($req->hasFile('image')) {
            if (!$req->file('image')->isValid()) {
                return response()->json([
                    'message' => 'La imagen no es válida'
                ], 400);
            }
            $validated['image'] = $req->file('image')->store('public');
        }

        $updatedSubcategory = $this->data->updateSubcategory($subcategory, $validated);
        return response()->json([
            'updated_subcategory' => $updatedSubcategory
        ]);
    }

    public function destroy(Subcategory $subcategory)
    {
        $deletedSubcategory = $this->data->deleteSubcategory($subcategory);
        return response()->json([
            'message' => 'La categoría fue eliminada con éxito',
            'deleted_subcategory' => $deletedSubcategory
        ]);
    }
}
