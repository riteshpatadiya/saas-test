<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Auth\Login\ {
    IndexController,
    PostController
};

use App\Http\Controllers\Store\Auth\LogoutController;

Route::name('auth.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('login');
        Route::post('/', PostController::class);

        Route::get('/logout', LogoutController::class)->name('logout')->middleware(['auth:store', 'store']);
    });
