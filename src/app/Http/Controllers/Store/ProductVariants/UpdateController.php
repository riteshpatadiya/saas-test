<?php

namespace App\Http\Controllers\Store\ProductVariants;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;

// Requests
use App\Http\Requests\Store\ProductVariants\UpdateRequest;

use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, string $store, ProductVariant $variant)
    {
        abort_if($variant->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $data = $request->validated();

        $variant->update($data);

        flash('Product variant updated successfully')->success();

        return redirect()->route('store.product-variants.index');
    }
}

