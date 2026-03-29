<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;

// Route sementara untuk menampilkan daftar produk biar lu gampang ngetes
Route::get('/', function () {
    $products = Product::where('is_active', true)->get();
    return view('welcome', compact('products')); // Nanti kita percantik katalognya
});

// Route Checkout
Route::get('/checkout/{product}', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');