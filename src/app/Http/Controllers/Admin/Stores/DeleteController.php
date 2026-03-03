<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;

// Models
use App\Models\Store;

class DeleteController extends Controller
{
    public function __invoke(Store $store)
    {
        $store->delete();

        flash('Store deleted successfully.')->success();

        return redirect()->route('admin.stores.index');
    }
}
