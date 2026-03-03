<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Product;

class DeleteController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->delete();

        flash('Product deleted successfully')->success();

        return redirect()->route('admin.products.index');
    }
}

