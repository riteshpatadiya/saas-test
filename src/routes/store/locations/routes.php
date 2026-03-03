<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Locations\{
    IndexController,
    NewController,
    StoreController,
    EditController,
    UpdateController,
    DeleteController
};

Route::prefix('locations')
    ->name('store_locations.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::prefix('{storeLocation}/edit')
            ->group(function () {
                Route::get('/', EditController::class)->name('edit');
                Route::put('/', UpdateController::class);
            });

        Route::delete('{storeLocation}/delete', DeleteController::class)->name('delete');
    });

