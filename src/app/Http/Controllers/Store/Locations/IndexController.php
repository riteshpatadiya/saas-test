<?php

namespace App\Http\Controllers\Store\Locations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

class IndexController extends Controller
{
    public function __invoke()
    {
        $storeLocations = StoreLocation::query()
            ->where('store_id', app('currentStore')->id)
            ->latest()
            ->paginate(10);

        return view('store.store_locations.index', [
            'storeLocations' => $storeLocations
        ]);
    }
}
