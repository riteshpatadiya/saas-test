<?php

namespace App\Http\Controllers\Admin\StoreLocations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

class DeleteController extends Controller
{
    public function __invoke(StoreLocation $store_location)
    {
        $store_location->delete();

        flash('Store Location deleted successfully.')->success();

        return redirect()->route('admin.store-locations.index');
    }
}

