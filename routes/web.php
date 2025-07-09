<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;

Route::get('/', function () {
    return redirect()->route('home-page');
});

Route::get('login', [LoginController::class, 'loginBackend'])->name('login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

Route::get('/home-page', [HomepageController::class, 'index'])->name('home-page');

// Route Product
Route::get('/produk/all', [ProductController::class, 'index'])->name('produk.all');
Route::get('/produk/detail/{id}', [ProductController::class, 'detail'])->name('produk.detail');

Route::prefix('/backend')->middleware('auth:admin')->group(function () {
    // Dashboard backend
    Route::get('/dashboard', [DashboardController::class, 'backendIndex'])->name('backend.dashboard');

    // Product
    Route::get('/product', [ProductController::class, 'indexbackend'])->name('product.index');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('backend.product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('backend.product.update');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('backend.product.show');
    Route::get('/product-data', [ProductController::class, 'data'])->name('backend.product.data');

    // Order backend
    Route::get('pesanan-proses', [OrderController::class, 'statusProses'])->name('pesanan.proses');
});
