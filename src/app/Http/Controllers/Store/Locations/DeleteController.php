<?php

namespace App\Http\Controllers\Store\Locations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;

use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function __invoke(StoreLocation $storeLocation)
    {
        abort_if($storeLocation->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $storeLocation->delete();

        flash('Store Location deleted successfully.')->success();

        return redirect()->route('store.store_locations.index');
    }
}
