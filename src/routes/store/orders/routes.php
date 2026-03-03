<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Orders\{
    IndexController,
    ShowController
};

Route::prefix('orders')
    ->name('orders.')
    ->group(function () {
        Route::get('/', IndexController::class)->name('index');
        Route::get('/{order}', ShowController::class)->name('show');
    });
