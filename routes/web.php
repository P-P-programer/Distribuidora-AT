<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::orderBy('id')->limit(5)->get();
    return view('welcome', ['products' => $products]);  
})->middleware('guest')->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/inventario', [ProductController::class, 'index'])
        ->middleware('role:admin|superadmin')
        ->name('inventario.index');

    Route::get('/api/products/search', action: [ProductController::class, 'search'])
        ->middleware('can:view products')
        ->name('products.search');

    Route::view('/analytics', 'analytics.index')
        ->middleware('role:superadmin')
        ->name('analytics.index');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])
        ->name('profile.edit');
});

Route::middleware(['role:superadmin'])->group(function () {
    Route::view('/analytics', 'analytics.index')->name('analytics.index');
});

Route::middleware(['role:admin|superadmin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/inventario', [ProductController::class, 'index'])->name('inventario.index');
});

require __DIR__.'/auth.php';
