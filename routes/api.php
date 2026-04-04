<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApigamesController;
use App\Http\Controllers\Api\CallbackController;

Route::prefix('apigames')->group(function () {
    Route::get('/info', [ApigamesController::class, 'getInfo']);
    Route::post('/cek-username', [ApigamesController::class, 'checkGameAccount']);
});
   
Route::post('/callback/midtrans', [CallbackController::class, 'midtrans']);