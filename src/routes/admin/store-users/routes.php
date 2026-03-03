<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Admin\StoreUsers\{
    IndexController,
    NewController,
    StoreController,
    EditController,
    UpdateController,
    DeleteController
};

Route::prefix('store-users')
    ->name('store-users.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::prefix('{user}/edit')
            ->group(function () {
                Route::get('/', EditController::class)->name('edit');
                Route::put('/', UpdateController::class);
            });

        Route::delete('{user}/delete', DeleteController::class)->name('delete');
    });

