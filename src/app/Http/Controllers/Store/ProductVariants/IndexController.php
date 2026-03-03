<?php

namespace App\Http\Controllers\Store\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;
use App\Models\Product;

class IndexController extends Controller
{
    public function __invoke()
    {
        $storeId = app('currentStore')->id;

        $query = ProductVariant::query()
            ->where('store_id', $storeId)
            ->with('product');

        $sku = request('sku');
        $productId = request('product_id');

        if ($sku) {
            $query->where('sku', 'ILIKE', '%' . $sku . '%');
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $variants = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $products = Product::where('store_id', $storeId)
            ->orderBy('name')
            ->get();

        return view('store.product-variants.index', [
            'variants' => $variants,
            'products' => $products,
        ]);
    }
}

