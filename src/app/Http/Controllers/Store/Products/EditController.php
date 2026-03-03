<?php

namespace App\Http\Controllers\Store\Products;

use App\Http\Controllers\Controller;

// Models
use App\Models\Product;

use Symfony\Component\HttpFoundation\Response;

class EditController extends Controller
{
    public function __invoke(string $store, Product $product)
    {
        abort_if($product->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);
        
        return view('store.products.edit', [
            'product' => $product,
        ]);
    }
}
