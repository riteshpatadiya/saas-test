<?php

namespace App\Http\Controllers\Admin\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;

// Requests
use App\Http\Requests\Admin\ProductVariants\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();

        ProductVariant::create($requestData);

        flash('Product variant created successfully')->success();

        return redirect()->route('admin.product-variants.index');
    }
}

