<?php

namespace App\Http\Controllers\Store\Locations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

// Reqquests
use App\Http\Requests\Store\Locations\UpdateRequest;

use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, string $store, StoreLocation $storeLocation)
    {
        abort_if($storeLocation->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $requestData = $request->validated();

        $storeLocation->update($requestData);

        flash('Store Location updated successfully')->success();

        return redirect()->route('store.store_locations.index');
    }
}
