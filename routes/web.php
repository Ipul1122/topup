<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mobile-legends', function () {
    // Tarik semua produk kategori Mobile Legends yang aktif
    $products = Product::whereHas('category', function ($q) {
        $q->where('brand_code', 'mobilelegend');
    })->where('is_active', true)->get();
    
    return view('mobileLegends.index', compact('products'));
})->name('mobile-legends.index');

Route::get('/free-fire', function () {
    // Tarik semua produk kategori Free Fire yang aktif
    $products = Product::whereHas('category', function ($q) {
        $q->where('brand_code', 'freefire');
    })->where('is_active', true)->get();
    
    return view('freeFire.index', compact('products'));
})->name('free-fire.index');

// Route untuk memproses pesanan
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

Route::get('/rules/terms', function () {
    return view('rules.terms');
})->name('rules.terms');

Route::get('/rules/conditions', function () {
    return view('rules.conditions');
})->name('rules.conditions');