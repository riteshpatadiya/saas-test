<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Store;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = Product::query()
            ->with('store');

        $search = request('search');
        $storeId = request('store_id');

        if ($search) {
            $query->where('name', 'ILIKE', '%' . $search . '%');
        }

        if ($storeId) {
            $query->where('store_id', $storeId);
        }

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stores = Store::orderBy('name')->get();

        return view('admin.products.index', [
            'products' => $products,
            'stores' => $stores,
            'search' => $search,
            'storeId' => $storeId,
        ]);
    }
}

