<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApigamesController;

Route::prefix('apigames')->group(function () {
    Route::get('/info', [ApigamesController::class, 'getInfo']);
    Route::post('/cek-username', [ApigamesController::class, 'checkGameAccount']);
});