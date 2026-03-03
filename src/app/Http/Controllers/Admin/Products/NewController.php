<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Store;

class NewController extends Controller
{
    public function __invoke()
    {
        $stores = Store::query()
            ->orderBy('name')
            ->get();

        return view('admin.products.new', [
            'stores' => $stores,
        ]);
    }
}

