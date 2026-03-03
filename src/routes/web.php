<?php

use Illuminate\Support\Facades\Route;


Route::domain(config('app.admin_domain'))
    ->middleware(['web'])
    ->group(function () {
        require __DIR__ . '/admin/routes.php';
    });


Route::domain('{store}.' . config('app.store_domain'))
    ->middleware(['web', 'resolve_store_domain'])
    ->group(function () {
        require __DIR__ . '/store/routes.php';
    });
