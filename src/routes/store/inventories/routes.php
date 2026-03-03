<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Inventories\{
    IndexController,
    AdjustController,
    ShowController
};

Route::prefix('inventories')
    ->name('inventories.')
    ->group(function () {
        Route::get('/', IndexController::class)->name('index');
        Route::get('/{variant}', ShowController::class)->name('show');
        Route::post('/adjust', AdjustController::class)->name('adjust');
    });

