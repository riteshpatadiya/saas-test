<?php

namespace App\Http\Controllers\Store\Products;

use App\Events\ProductUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Products\UpdateRequest;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, string $store, Product $product)
    {
        abort_if($product->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $data = $request->validated();
        $before = $product->only(array_keys($data));

        $product->update($data);

        event(new ProductUpdatedEvent($product, $before, $data));

        flash('Product updated successfully')->success();

        return redirect()->route('store.products.index');
    }
}
