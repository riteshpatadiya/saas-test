<?php

namespace App\Http\Controllers\Store\Products;

use App\Http\Controllers\Controller;

// Models
use App\Models\Product;

// Requests
use App\Http\Requests\Store\Products\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['store_id'] = app('currentStore')->id;

        Product::create($data);

        flash('Product created successfully')->success();

        return redirect()->route('store.products.index');
    }
}

