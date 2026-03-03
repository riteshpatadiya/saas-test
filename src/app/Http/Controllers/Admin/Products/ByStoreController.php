<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Store;

class ByStoreController extends Controller
{
    public function __invoke(Store $store)
    {
        $products = $store->products()
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'data' => $products,
        ]);
    }
}

