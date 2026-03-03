<?php

namespace App\Http\Controllers\Store\Locations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

use Symfony\Component\HttpFoundation\Response;

class EditController extends Controller
{
    public function __invoke(string $store, StoreLocation $storeLocation)
    {
        abort_if($storeLocation->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);
        
        return view('store.store_locations.edit', [
            'storeLocation' => $storeLocation
        ]);
    }
}
