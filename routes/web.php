<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('home-page');
});

Route::get('/login', [LoginController::class, 'loginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'unifiedLogin'])->name('login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');
Route::post('/logout', [LoginController::class, 'logoutFrontend'])->name('logout');

Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/home-page', [HomepageController::class, 'index'])->name('home-page');

// Route Product
Route::get('/produk/all', [ProductController::class, 'index'])->name('produk.all');
Route::get('/produk/detail/{id}', [ProductController::class, 'detail'])->name('produk.detail');
Route::get('/produk/kategori/{id}', [ProductController::class, 'produkKategori'])->name('produk.kategori');
Route::get('/produk/cari', [ProductController::class, 'search'])->name('produk.search');


Route::middleware('is.customer')->group(function () {
    //route untuk Menampilkan halaman Akun Customer
    Route::get('/customer/akun/{id}', [CustomerController::class, 'akun'])->name('customer.akun');
    Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun'])->name('customer.updateakun');
});

Route::prefix('/backend')->middleware('auth:admin')->group(function () {
    // Dashboard backend
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

    // Customer
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/{customer}', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('/customer-data', [CustomerController::class, 'data'])->name('backend.customer.data');

    // Product
    Route::get('/product', [ProductController::class, 'indexbackend'])->name('product.index');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product-data', [ProductController::class, 'data'])->name('backend.product.data');

    // category
    Route::resource('category', CategoryController::class);
    Route::get('/category-data', [CategoryController::class, 'data'])->name('backend.category.data');

    // Order backend
    Route::get('pesanan-proses', [OrderController::class, 'statusProses'])->name('pesanan.proses');
    Route::get('pesanan-selesai', [OrderController::class, 'statusSelesai'])->name('pesanan.selesai');
});
