<?php

namespace App\Services\Store;

use App\Events\OrderCreatedEvent;
use App\Events\OrderPaidEvent;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DomainException;

class CompleteCheckoutService
{
    public function handle(Checkout $checkout): Order
    {
        // Idempotency
        if ($checkout->isCompleted()) {
            return $checkout->order;
        }

        // Expiration guard
        if ($checkout->isExpiredState()) {
            $this->releaseReservations($checkout);

            throw new DomainException(
                'Checkout expired. Please create a new checkout.'
            );
        }

        $checkout->loadMissing('items');

        return DB::transaction(function () use ($checkout) {

            $order = $this->createOrder($checkout);

            event(new OrderCreatedEvent($order));

            $this->snapshotItems($checkout, $order);

            $this->convertReservationsToSales($checkout, $order);

            $checkout->markCompleted($order);

            $order->markPaid();

            event(new OrderPaidEvent($order));

            return $order;
        });
    }

    private function createOrder(Checkout $checkout): Order
    {
        return Order::create([
            'store_id' => $checkout->store_id,
            'number'   => $this->generateNumber(),
            'status'   => Order::STATUS_CREATED,
            'subtotal' => $checkout->subtotal,
            'tax'      => $checkout->tax,
            'discount' => 0,
            'total'    => $checkout->total,
        ]);
    }

    private function snapshotItems(Checkout $checkout, Order $order): void
    {
        foreach ($checkout->items as $item) {
            OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'sku'                => $item->sku,
                'product_name'       => str($item->product_name)->limit(50),
                'variant_name'       => $item->variant_name
                    ? str($item->variant_name)->limit(50)
                    : null,
                'quantity'           => $item->quantity,
                'unit_price'         => $item->unit_price,
                'line_total'         => $item->line_total,
            ]);
        }
    }

    private function convertReservationsToSales(
        Checkout $checkout,
        Order $order
    ): void {
        Inventory::where('checkout_id', $checkout->id)
            ->update([
                'order_id'    => $order->id,
                'checkout_id' => null,
                'note'        => "Sold — Order #{$order->number}",
            ]);
    }

    private function releaseReservations(Checkout $checkout): void
    {
        Inventory::where('checkout_id', $checkout->id)->delete();

        $checkout->markExpired();
    }

    private function generateNumber(): string
    {
        do {
            $number = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('number', $number)->exists());

        return $number;
    }
}
