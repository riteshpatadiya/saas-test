<?php

namespace App\Http\Controllers\Store\Checkouts;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Inventory;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{
    public function __invoke(string $store, Checkout $checkout)
    {
        abort_if($checkout->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $checkout->load(['storeLocation', 'items', 'order']);

        // Lazily mark an OPEN-but-expired checkout and release its reserved stock
        if ($checkout->status === Checkout::STATUS_OPEN && $checkout->isExpired()) {
            $this->releaseReservations($checkout);
            $checkout->refresh();
        }

        return view('store.checkouts.show', [
            'checkout' => $checkout,
        ]);
    }

    private function releaseReservations(Checkout $checkout): void
    {
        // Delete reservation inventory entries; stock returns to available pool
        Inventory::where('checkout_id', $checkout->id)->delete();

        $checkout->update(['status' => Checkout::STATUS_EXPIRED]);
    }
}
