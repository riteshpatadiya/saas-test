<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;

// Models
use App\Models\Store;

class EditController extends Controller
{
    public function __invoke(Store $store)
    {        
        return view('admin.stores.edit', [
            'store' => $store
        ]);
    }
}
