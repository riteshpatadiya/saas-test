<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;

// Models
use App\Models\Store;

// Requests
use App\Http\Requests\Admin\Stores\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();

        Store::create($requestData);
        
        flash('Store created successfully')->success();

        return redirect()->route('admin.stores.index');
    }
}
