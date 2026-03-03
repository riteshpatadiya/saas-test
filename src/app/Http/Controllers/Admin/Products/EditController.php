<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Store;

class EditController extends Controller
{
    public function __invoke(Product $product)
    {
        $stores = Store::query()
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', [
            'product' => $product,
            'stores' => $stores,
        ]);
    }
}

