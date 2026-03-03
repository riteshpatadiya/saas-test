<?php

use Illuminate\Support\Facades\Route;

Route::name('admin.')
    ->group(function () {

        // Auth
        require __DIR__ . '/auth/routes.php';

        Route::middleware(['auth:admin', 'admin'])
        ->group(function(){
            // Dashboard
            require __DIR__ . '/dashboard/routes.php';

            // Stores
            require __DIR__ . '/stores/routes.php';

            // Store Locations
            require __DIR__ . '/store-locations/routes.php';

            // Store Users
            require __DIR__ . '/store-users/routes.php';

            // Products
            require __DIR__ . '/products/routes.php';

            // Product Variants
            require __DIR__ . '/product-variants/routes.php';

            // Inventories
            require __DIR__ . '/inventories/routes.php';
        });
    });