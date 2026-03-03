<?php

namespace App\Http\Controllers\Store\Products;

use App\Http\Controllers\Controller;

// Models
use App\Models\Product;

use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function __invoke(string $store, Product $product)
    {
        abort_if($product->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $product->delete();

        flash('Product deleted successfully')->success();

        return redirect()->route('store.products.index');
    }
}

