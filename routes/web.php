<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('user/info', 'userInfo')->name('user.info');
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
})->middleware(['can:create,App\Models\Category', 'can:update,App\Models\Category']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('vitrina', [ClientController::class, 'index'])->name('clients.index');
});

require __DIR__ . '/auth.php';
