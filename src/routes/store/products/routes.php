<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Products\{
    IndexController,
    NewController,
    StoreController,
    EditController,
    UpdateController,
    DeleteController
};

Route::prefix('products')
    ->name('products.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::prefix('{product}/edit')
            ->group(function () {
                Route::get('/', EditController::class)->name('edit');
                Route::put('/', UpdateController::class);
            });

        Route::delete('{product}/delete', DeleteController::class)->name('delete');
    });

