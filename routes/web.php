<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified', 'can:viewAny,App\Models\User'])->group(function () {
    Route::get('users', [SuperadminController::class, 'index'])->name('superadmin.index');
    Route::get('users/{user}', [SuperadminController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [SuperadminController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/create', [CategoryController::class, 'store'])->name('category.store');
})->middleware(['can:create,App\Models\Category']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user-dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
});

require __DIR__ . '/auth.php';
