<?php

namespace App\Http\Controllers\Store\Products;

use App\Http\Controllers\Controller;

// Models
use App\Models\Product;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = Product::query()
            ->where('store_id', app('currentStore')->id);

        $search = request('search');

        if ($search) {
            $query->where('name', 'ILIKE', '%' . $search . '%');
        }

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('store.products.index', [
            'products' => $products,
            'search'   => $search,
        ]);
    }
}

