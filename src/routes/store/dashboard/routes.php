<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\Dashboard\ {
    IndexController
};

Route::prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');
    });
