<?php

namespace App\Http\Controllers\Store\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;

// Requests
use App\Http\Requests\Store\ProductVariants\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['store_id'] = app('currentStore')->id;

        ProductVariant::create($data);

        flash('Product variant created successfully')->success();

        return redirect()->route('store.product-variants.index');
    }
}

