<?php

namespace App\Http\Controllers\Store\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\Product;

class NewController extends Controller
{
    public function __invoke()
    {
        $products = Product::where('store_id', app('currentStore')->id)
            ->orderBy('name')
            ->get();

        return view('store.product-variants.new', [
            'products' => $products,
        ]);
    }
}

