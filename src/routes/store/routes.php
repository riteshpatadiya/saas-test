<?php

use Illuminate\Support\Facades\Route;

Route::name('store.')
    ->group(function () {

        // Auth
        require __DIR__ . '/auth/routes.php';

        Route::middleware(['auth:store', 'store'])
        ->group(function () {
            // Dashboard
            require __DIR__ . '/dashboard/routes.php';

            // Locations
            require __DIR__ . '/locations/routes.php';

            // Products
            require __DIR__ . '/products/routes.php';

            // Product Variants
            require __DIR__ . '/product-variants/routes.php';

            // Inventories
            require __DIR__ . '/inventories/routes.php';

            // Checkouts
            require __DIR__ . '/checkouts/routes.php';

            // Orders
            require __DIR__ . '/orders/routes.php';
        });
    });