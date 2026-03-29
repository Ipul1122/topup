<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;

Route::get('/', function () {
    // Tarik semua produk yang statusnya aktif untuk ditampilkan di halaman awal
    $products = Product::where('is_active', true)->get();
    return view('welcome', compact('products'));
});

// Route untuk memproses pesanan
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');