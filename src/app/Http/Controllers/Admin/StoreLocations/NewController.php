<?php

namespace App\Http\Controllers\Admin\StoreLocations;

use App\Http\Controllers\Controller;

// Models
use App\Models\Store;

class NewController extends Controller
{
    public function __invoke()
    {
        $stores = Store::orderBy('name')->get();

        return view('admin.store-locations.new', [
            'stores' => $stores,
        ]);
    }
}

