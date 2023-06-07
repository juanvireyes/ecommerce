<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ClientProductController;
use App\Http\Controllers\ClientSubcategoryController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('user/info', 'user_info')->name('user.info');
});

Route::middleware(['web'])->group(function () {
    Route::get('vitrina', [ClientController::class, 'index'])->name('clients.index');
    Route::get('vitrina/{category_slug}', [ClientSubcategoryController::class, 'subcategories'])->name('clients.subcategories');
    Route::get('vitrina/{category_slug}/{subcategory_slug}/products', [ClientProductController::class, 'products'])->name('clients.products');
    Route::get('vitrina/{category_slug}/{subcategory_slug}/{product_slug}', [ClientProductController::class, 'show'])->name('clients.product');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('cart/clear/{cart}', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::patch('cart/{cartItem}', [CartItemController::class, 'update'])->name('cart.update');
    Route::delete('cart/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.destroy');
});


Route::middleware(['web'])->group(function () {
    Route::get('testing', [TestingController::class, 'index'])->name('testing');
    Route::post('testing', [TestingController::class, 'addToCartTest'])->name('testingcart.add');
    Route::get('testing/cart', [TestingController::class, 'showCartContentTest'])->name('testingcart.show');
    Route::patch('testing/cart/{cartItem}', [CartItemController::class, 'update'])->name('testingcart.update');
    Route::delete('testing/cart/{cartItem}', [CartItemController::class, 'destroy'])->name('testingcart.destroy');
    Route::post('testing/cart/clear/{cart}', [TestingController::class, 'clearCartTest'])->name('testingcart.clear');
});

Route::middleware(['auth', 'verified', 'can:viewAny,App\Models\User'])->group(function () {
    Route::get('users', [SuperadminController::class, 'index'])->name('superadmin.index');
    Route::get('users/{user}', [SuperadminController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [SuperadminController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'verified', 'can:viewAny,App\Models\Category'])->group( function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/create', [CategoryController::class, 'store'])->name('category.store');
    Route::get('categories/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
})->middleware(['can:create,App\Models\Category', 'can:update,App\Models\Category']);

Route::middleware(['auth', 'verified', 'can:viewAny,App\Models\Subcategory'])->group( function () {
    Route::get('subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::get('subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::post('subcategories/create', [SubcategoryController::class, 'store'])->name('subcategory.store');
    Route::get('subcategories/{subcategory}', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');
})->middleware(['can:create,App\Models\Subcategory', 'can:update,App\Models\Subcategory']);

Route::middleware(['auth', 'verified', 'can:viewAny,App\Models\Product'])->group( function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/create', [ProductController::class, 'store'])->name('product.store');
    Route::get('products/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
})->middleware(['can:create,App\Models\Product', 'can:update,App\Models\Product']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
