<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Admin\Auth\Login\ {
    IndexController,
    PostController
};

use App\Http\Controllers\Admin\Auth\LogoutController;

Route::name('auth.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('login');
        Route::post('/', PostController::class);

        Route::get('/logout', LogoutController::class)->name('logout')->middleware(['auth:admin', 'admin']);
    });
