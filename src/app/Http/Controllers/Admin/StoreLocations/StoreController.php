<?php

namespace App\Http\Controllers\Admin\StoreLocations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

// Requests
use App\Http\Requests\Admin\StoreLocations\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();

        StoreLocation::create($requestData);

        flash('Store Location created successfully')->success();

        return redirect()->route('admin.store-locations.index');
    }
}

