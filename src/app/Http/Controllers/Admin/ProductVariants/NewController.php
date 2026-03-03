<?php

namespace App\Http\Controllers\Admin\ProductVariants;

use App\Http\Controllers\Controller;

use App\Models\Store;

class NewController extends Controller
{
    public function __invoke()
    {
        $stores = Store::query()
            ->orderBy('name')
            ->get();

        return view('admin.product-variants.new', [
            'stores' => $stores,
            'products' => collect(),
        ]);
    }
}

