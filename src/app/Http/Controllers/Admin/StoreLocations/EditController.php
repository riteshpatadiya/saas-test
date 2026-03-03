<?php

namespace App\Http\Controllers\Admin\StoreLocations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;
use App\Models\Store;

class EditController extends Controller
{
    public function __invoke(StoreLocation $store_location)
    {
        $stores = Store::orderBy('name')->get();

        return view('admin.store-locations.edit', [
            'storeLocation' => $store_location,
            'stores'        => $stores,
        ]);
    }
}

