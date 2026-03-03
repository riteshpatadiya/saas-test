<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Admin\StoreLocations\{
    IndexController,
    NewController,
    StoreController,
    EditController,
    UpdateController,
    DeleteController
};

Route::prefix('store-locations')
    ->name('store-locations.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::prefix('{store_location}/edit')
            ->group(function () {
                Route::get('/', EditController::class)->name('edit');
                Route::put('/', UpdateController::class);
            });

        Route::delete('{store_location}/delete', DeleteController::class)->name('delete');
    });

