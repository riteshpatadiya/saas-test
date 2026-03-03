<?php

namespace App\Http\Controllers\Admin\ProductVariants;

use App\Http\Controllers\Controller;

use App\Models\ProductVariant;
use App\Models\Store;
use App\Models\Product;

class EditController extends Controller
{
    public function __invoke(ProductVariant $variant)
    {
        $stores = Store::query()
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->where('store_id', $variant->store_id)
            ->orderBy('name')
            ->get();

        return view('admin.product-variants.edit', [
            'variant' => $variant,
            'stores' => $stores,
            'products' => $products,
        ]);
    }
}

