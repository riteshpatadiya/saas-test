<?php

namespace App\Http\Controllers\Store\Checkouts;

use App\Http\Controllers\Controller;
use App\Models\Checkout;

class IndexController extends Controller
{
    public function __invoke()
    {
        $checkouts = Checkout::with(['storeLocation'])
            ->where('store_id', app('currentStore')->id)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.checkouts.index', [
            'checkouts' => $checkouts,
        ]);
    }
}
