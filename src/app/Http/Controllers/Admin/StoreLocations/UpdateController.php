<?php

namespace App\Http\Controllers\Admin\StoreLocations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

// Requests
use App\Http\Requests\Admin\StoreLocations\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, StoreLocation $store_location)
    {
        $requestData = $request->validated();

        $store_location->update($requestData);

        flash('Store Location updated successfully')->success();

        return redirect()->route('admin.store-locations.index');
    }
}

