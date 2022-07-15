<?php

use App\Modules\Product\Controller\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('product')->group(function () {
    Route::post('', [ProductController::class, 'create']);
});