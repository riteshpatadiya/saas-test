<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Checkouts\{
    IndexController,
    NewController,
    StoreController,
    ShowController,
    CompleteController
};

Route::prefix('checkouts')
    ->name('checkouts.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::get('/{checkout}', ShowController::class)->name('show');
        Route::post('/{checkout}/complete', CompleteController::class)->name('complete');
    });
