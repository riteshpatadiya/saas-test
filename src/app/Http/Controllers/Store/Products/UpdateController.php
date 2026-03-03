<?php

namespace App\Http\Controllers\Store\Products;

use App\Http\Controllers\Controller;

// Models
use App\Models\Product;

// Requests
use App\Http\Requests\Store\Products\UpdateRequest;

use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, string $store, Product $product) 
    {
        abort_if($product->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $data = $request->validated();  

        $product->update($data);

        flash('Product updated successfully')->success();

        return redirect()->route('store.products.index');
    }
}

