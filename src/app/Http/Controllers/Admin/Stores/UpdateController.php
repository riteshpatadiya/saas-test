<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;

// Models
use App\Models\Store;

// Reqquests
use App\Http\Requests\Admin\Stores\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Store $store)
    {
        $requestData = $request->validated();

        $store->update($requestData);

        flash('Store updated successfully')->success();

        return redirect()->route('admin.stores.index');
    }
}
