<?php

namespace App\Http\Controllers\Store\Checkouts;

use App\Http\Controllers\Controller;

// Models
use App\Models\Checkout;

// Service
use App\Services\Store\CompleteCheckoutService;

use Symfony\Component\HttpFoundation\Response;

class CompleteController extends Controller
{
    public function __invoke(
        string $store,
        Checkout $checkout,
        CompleteCheckoutService $service
    ) {
        abort_if(
            $checkout->store_id !== app('currentStore')->id,
            Response::HTTP_NOT_FOUND
        );

        $order = $service->handle($checkout);

        flash("Order #{$order->number} placed successfully.")
            ->success();

        return redirect()->route('store.orders.show', [
            'order' => $order->id
        ]);
    }
}
