<?php

namespace App\Http\Controllers\Store\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = Order::where('store_id', app('currentStore')->id);

        $status = request('status');

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.orders.index', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }
}
