<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductApiRequest;
use App\Http\Requests\Api\UpdateProductApiRequest;
use App\Models\Product;
use App\Repositories\ApiRepositories\ProductApiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    public function __construct(public ProductApiRepository $data)
    {}

    public function index(Request $request): JsonResponse
    {
        $subcategoryName = $request->query('subcategory');
        $productName = $request->query('productName');
        $minPrice = $request->query('min');
        $maxPrice = $request->query('max');

        $products = $this->data->getAllProducts();

        if ($subcategoryName) {
            $products = $this->data->getProductsBySubcategory($subcategoryName)->get();
        }

        if ($productName) {
            $products = $this->data->getProductByName($productName)->get();
        }

        if ($minPrice && $maxPrice) {
            $products = $this->data->getProductsByPriceRange($minPrice, $maxPrice)->get();
        } elseif ($minPrice) {
            $products = $this->data->getProductsOverPrice($minPrice);
        } elseif ($maxPrice) {
            $products = $this->data->getProductsUnderPrice($maxPrice);
        }

        return response()->json([
            'products' => $products
        ]);
    }

    public function store(StoreProductApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name'], '-');

        if ($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                return response()->json([
                    'message' => 'La imagen no es válida'
                ]);
            }
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->input('active')) {
            $validated['active'] = $request->input('active');
        }

        $product = $this->data->createProduct($validated);
        return response()->json([
            'created_product' => $product
        ], 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'product' => $product
        ]);
    }

    public function update(UpdateProductApiRequest $req, Product $product): JsonResponse
    {
        $validatedUpdate = $req->validated();
        $validatedUpdate['slug'] = Str::slug($validatedUpdate['name'], '-');

        if ($req->hasFile('image')) {
            if (!$req->file('image')->isValid()) {
                return response()->json([
                    'message' => 'La imagen no es válida'
                ]);
            }
            $validatedUpdate['image'] = $req->file('image')->store('public');
        }

        if ($req->input('active')) {
            $validatedUpdate['active'] = $req->input('active');
        }

        $updatedProduct = $this->data->updateProduct($product, $validatedUpdate);
        return response()->json([
            'updated_product' => $updatedProduct
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product = $this->data->deleteProduct($product);
        return response()->json([
            'message' => 'Producto eliminado correctamente',
            'deleted_product' => $product
        ]);
    }
}
