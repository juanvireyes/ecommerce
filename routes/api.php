<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ProductsImportApiController;
use App\Http\Controllers\Api\SubcategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('token', [LoginController::class, 'index'])->name('user.token');

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('categories', CategoryApiController::class)->names([
        'index' => 'api.categories.index',
        'store' => 'api.categories.store',
        'show' => 'api.categories.show',
        'destroy' => 'api.categories.destroy'
    ])->except(['update']);
    Route::match(['PUT', 'POST'], 'categories/{category}', [CategoryApiController::class, 'update'])
        ->name('api.categories.update');

    Route::apiResource('subcategories', SubcategoryApiController::class)->names([
        'index' => 'api.subcategories.index',
        'store' => 'api.subcategories.store',
        'show' => 'api.subcategories.show',
        'destroy' => 'api.subcategories.destroy'
    ])->except(['update']);
    Route::match(['PUT', 'POST'], 'subcategories/{subcategory}', [SubcategoryApiController::class, 'update'])
        ->name('api.subcategories.update');

    Route::post('products/import', [ProductsImportApiController::class, 'uploadProductsList'])
        ->name('api.products.import');

    Route::apiResource('products', ProductApiController::class)->names([
        'index' => 'api.products.index',
        'store' => 'api.products.store',
        'show' => 'api.products.show',
        'destroy' => 'api.products.destroy'
    ])->except('update');
    Route::match(['PUT', 'POST'], 'products/{product}', [ProductApiController::class, 'update'])
        ->name('api.products.update');
});
