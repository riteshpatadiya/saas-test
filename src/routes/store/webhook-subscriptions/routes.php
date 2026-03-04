<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Store\WebhookSubscriptions\{
    IndexController,
    NewController,
    StoreController,
    EditController,
    UpdateController,
    DeleteController
};

Route::prefix('webhook-subscriptions')
    ->name('webhook_subscriptions.')
    ->group(function () {

        Route::get('/', IndexController::class)->name('index');

        Route::prefix('/new')
            ->group(function () {
                Route::get('/', NewController::class)->name('new');
                Route::post('/', StoreController::class);
            });

        Route::prefix('{webhookSubscription}/edit')
            ->group(function () {
                Route::get('/', EditController::class)->name('edit');
                Route::put('/', UpdateController::class);
            });

        Route::delete('{webhookSubscription}/delete', DeleteController::class)->name('delete');
    });
