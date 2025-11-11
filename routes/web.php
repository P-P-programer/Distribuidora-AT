<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalyticsController;

// Inicio
Route::get('/', function () {
    $products = Product::orderBy('id')->limit(5)->get();
    return view('welcome', ['products' => $products]);
})->name('welcome');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Productos y carrito (solo autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/api/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/buy', [CartController::class, 'buy'])->name('cart.buy');

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inventario (solo autenticados; rol se valida en el controlador)
Route::middleware('auth')->group(function () {
    // Editar inventario
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
});

// Inventario (validación de rol dentro del controlador)
Route::get('/inventario', [ProductController::class, 'inventario'])
    ->middleware('auth')
    ->name('inventario.index');

Route::middleware('auth')->get('/users', [UserController::class, 'index'])->name('users.index');
Route::middleware('auth')->post('/users', [UserController::class, 'store'])->name('users.store');
Route::middleware('auth')->patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::middleware('auth')->patch('/users/{user}/toggle-estado', [UserController::class, 'toggleEstado'])->name('users.toggleEstado');

Route::middleware('auth')->get('/analytics', [AnalyticsController::class, 'index'])
    ->name('analytics.index');

require __DIR__.'/auth.php';
