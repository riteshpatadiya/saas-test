<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Product;

use App\Http\Requests\Admin\Products\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Product $product)
    {
        $requestData = $request->validated();

        $product->update($requestData);

        flash('Product updated successfully')->success();

        return redirect()->route('admin.products.index');
    }
}

