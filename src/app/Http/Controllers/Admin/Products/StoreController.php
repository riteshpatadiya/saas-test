<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;

use App\Models\Product;

use App\Http\Requests\Admin\Products\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();

        Product::create($requestData);

        flash('Product created successfully')->success();

        return redirect()->route('admin.products.index');
    }
}

