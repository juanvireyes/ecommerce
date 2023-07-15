<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductsImportApiRequest;
use App\Imports\ProductsImport;
use App\Jobs\SuccessImportProductsNotificationJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsImportApiController extends Controller
{
    public function uploadProductsList(ProductsImportApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        (new ProductsImport)->queue($validated['productsList'])->chain([
            new SuccessImportProductsNotificationJob(request()->user())
        ]);

        return response()->json([
            'message' => 'Tu archivo se está importando. A tu correo llegará un mensaje cuando esté listo'
        ]);
    }
}
