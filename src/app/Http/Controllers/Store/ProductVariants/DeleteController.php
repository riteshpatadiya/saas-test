<?php

namespace App\Http\Controllers\Store\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;

use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function __invoke(string $variant)
    {
        $storeId = app('currentStore')->id;

        $variantModel = ProductVariant::where('id', $variant)
            ->where('store_id', $storeId)
            ->first();

        abort_if(! $variantModel, Response::HTTP_NOT_FOUND);

        $variantModel->delete();

        flash('Product variant deleted successfully')->success();

        return redirect()->route('store.product-variants.index');
    }
}

