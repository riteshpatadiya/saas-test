<?php

use App\Http\Controllers\Admin\AuditLogs\IndexController;
use Illuminate\Support\Facades\Route;

Route::prefix('audit-logs')
    ->name('audit_logs.')
    ->group(function () {
        Route::get('/', IndexController::class)->name('index');
    });
