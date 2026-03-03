<?php

namespace App\Http\Controllers\Store\Locations;

use App\Http\Controllers\Controller;

class NewController extends Controller
{
    public function __invoke()
    {
        return view('store.store_locations.new');
    }
}
