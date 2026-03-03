<?php

namespace App\Http\Controllers\Store\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;
use App\Models\Product;

use Symfony\Component\HttpFoundation\Response;

class EditController extends Controller
{
    public function __invoke(string $store, ProductVariant $variant)
    {
        abort_if($variant->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $products = Product::where('store_id', app('currentStore')->id)
            ->orderBy('name')
            ->get();

        return view('store.product-variants.edit', [
            'variant'  => $variant,
            'products' => $products,
        ]);
    }
}

