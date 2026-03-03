<?php

namespace App\Http\Controllers\Admin\ProductVariants;

use App\Http\Controllers\Controller;

use App\Models\ProductVariant;
use App\Models\Store;
use App\Models\Product;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = ProductVariant::query()
            ->with(['store', 'product']);

        $sku = request('sku');
        $storeId = request('store_id');
        $productId = request('product_id');
        $status = request('status');

        if ($sku) {
            $query->where('sku', 'ILIKE', '%' . $sku . '%');
        }

        if ($storeId) {
            $query->where('store_id', $storeId);
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $variants = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stores = Store::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('admin.product-variants.index', [
            'variants' => $variants,
            'stores' => $stores,
            'products' => $products,
            'filters' => [
                'sku' => $sku,
                'store_id' => $storeId,
                'product_id' => $productId,
                'status' => $status,
            ],
        ]);
    }
}

