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

Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

Route::get('/home-page', [HomepageController::class, 'index'])->name('home-page');

// Route Product
Route::get('/produk/all', [ProductController::class, 'index'])->name('produk.all');
Route::get('/produk/detail/{id}', [ProductController::class, 'detail'])->name('produk.detail');

Route::prefix('/backend')->middleware('auth')->group(function () {
    // Dashboard backend
    Route::get('/dashboard', [DashboardController::class, 'backendIndex'])->name('backend.dashboard');

    // Product
    Route::resource('/product', ProductController::class);
    // Order backend
    Route::get('pesanan-proses', [OrderController::class, 'statusProses'])->name('pesanan.proses');
});
