<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DigiflazzController;
use App\Http\Controllers\Api\CallbackController;

Route::prefix('digiflazz')->group(function () {
    Route::get('/info', [DigiflazzController::class, 'getInfo']);
    Route::post('/cek-username', [DigiflazzController::class, 'checkGameAccount']);
});
   
Route::post('/callback/midtrans', [CallbackController::class, 'midtrans']);