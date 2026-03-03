<?php

namespace App\Http\Controllers\Store\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{
    public function __invoke(string $store, Order $order)
    {
        abort_if($order->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $order->load('items');

        return view('store.orders.show', [
            'order' => $order,
        ]);
    }
}
