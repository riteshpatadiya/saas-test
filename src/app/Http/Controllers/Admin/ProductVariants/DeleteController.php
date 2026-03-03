<?php

namespace App\Http\Controllers\Admin\ProductVariants;

use App\Http\Controllers\Controller;

use App\Models\ProductVariant;

class DeleteController extends Controller
{
    public function __invoke(ProductVariant $variant)
    {
        $variant->delete();

        flash('Product variant deleted successfully')->success();

        return redirect()->route('admin.product-variants.index');
    }
}

