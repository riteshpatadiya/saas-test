<?php

namespace App\Http\Controllers\Store\Products;

use App\Http\Controllers\Controller;

class NewController extends Controller
{
    public function __invoke()
    {
        return view('store.products.new');
    }
}

