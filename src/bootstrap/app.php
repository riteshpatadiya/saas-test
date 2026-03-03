<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'store' => \App\Http\Middleware\StoreMiddleware::class,
            'resolve_store_domain' => \App\Http\Middleware\ResolveStoreFromSubdomain::class
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {

            if ($request->routeIs('admin.*')) {
                return route('admin.auth.login');
            }
    
            if ($request->routeIs('store.*')) {
                return route('store.auth.login', [
                    'store' => current_store_slug($request)
                ]);
            }
    
            return route('admin.auth.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();
