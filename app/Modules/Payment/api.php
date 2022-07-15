<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Payment\Controller\PaymentController;



Route::prefix('coupon')->group(function () {
    Route::post('/create',     [PaymentController::class, 'create']);
});