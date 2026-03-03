<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\ProductVariants\{
    IndexController,
    NewController,
    StoreController,
    EditController,
    UpdateController,
    DeleteController
};

Route::prefix('product-variants')
    ->name('product-variants.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::prefix('{variant}/edit')
            ->group(function () {
                Route::get('/', EditController::class)->name('edit');
                Route::put('/', UpdateController::class);
            });

        Route::delete('{variant}/delete', DeleteController::class)->name('delete');
    });

