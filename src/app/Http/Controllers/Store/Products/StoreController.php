<?php

namespace App\Http\Controllers\Store\Products;

use App\Events\ProductCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Products\StoreRequest;
use App\Models\Product;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['store_id'] = app('currentStore')->id;

        $product = Product::create($data);

        event(new ProductCreatedEvent($product));

        flash('Product created successfully')->success();

        return redirect()->route('store.products.index');
    }
}
