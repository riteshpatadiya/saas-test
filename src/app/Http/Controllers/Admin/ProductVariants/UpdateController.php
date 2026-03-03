<?php

namespace App\Http\Controllers\Admin\ProductVariants;

use App\Http\Controllers\Controller;

use App\Models\ProductVariant;

use App\Http\Requests\Admin\ProductVariants\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, ProductVariant $variant)
    {
        $requestData = $request->validated();

        $variant->update($requestData);

        flash('Product variant updated successfully')->success();

        return redirect()->route('admin.product-variants.index');
    }
}

