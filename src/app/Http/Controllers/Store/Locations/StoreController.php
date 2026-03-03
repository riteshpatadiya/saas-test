<?php

namespace App\Http\Controllers\Store\Locations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

// Requests
use App\Http\Requests\Store\Locations\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();
        $requestData['store_id'] = app('currentStore')->id;

        StoreLocation::create($requestData);
        
        flash('Store Location created successfully')->success();

        return redirect()->route('store.store_locations.index');
    }
}
