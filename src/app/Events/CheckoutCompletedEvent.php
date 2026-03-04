<?php

namespace App\Events;

use App\Contracts\AuditableEvent;
use App\Models\Checkout;
use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutCompletedEvent implements AuditableEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Checkout $checkout,
        public Order $order
    ) {}

    public function auditAction(): string
    {
        return 'checkout.completed';
    }

    public function auditEntityType(): string
    {
        return 'checkout';
    }

    public function auditEntityId(): ?int
    {
        return $this->checkout->id;
    }

    public function auditMetadata(): array
    {
        return [
            'order_id'     => $this->order->id,
            'order_number' => $this->order->number,
            'total'        => $this->order->total,
        ];
    }

    public function auditStoreId(): ?int
    {
        return $this->checkout->store_id;
    }

    public function auditActorId(): ?int
    {
        return auth('store')->id();
    }
}
