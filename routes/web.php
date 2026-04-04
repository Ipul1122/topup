<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mobile-legends', function () {
    // Tarik semua produk yang statusnya aktif untuk ditampilkan di halaman awal
    $products = Product::where('is_active', true)->get();
    return view('mobileLegends.index', compact('products'));
})->name('mobile-legends.index');

// Route untuk memproses pesanan
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

Route::get('/rules/terms', function () {
    return view('rules.terms');
})->name('rules.terms');

Route::get('/rules/conditions', function () {
    return view('rules.conditions');
})->name('rules.conditions');