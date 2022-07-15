<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Purchase\Controller\CartController;

Route::prefix('cart')->group(function () {
    Route::post('/create',     [CartController::class, 'createNewCart']);
    Route::post('/add-item', [CartController::class, 'addItemInCart']);
    Route::post('/remove-item', [CartController::class, 'removeItenInCart']);
    Route::post('/add-payment', [CartController::class, 'addPayment']);
    Route::get('/{id}', [CartController::class, 'getCart']);
    Route::get('/{id}/clear', [CartController::class, 'clearAllItensInCart']);
});