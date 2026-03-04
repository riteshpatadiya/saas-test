<?php

namespace App\Events;

use App\Contracts\AuditableEvent;
use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCreatedEvent implements AuditableEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Product $product
    ) {}

    public function auditAction(): string
    {
        return 'product.created';
    }

    public function auditEntityType(): string
    {
        return 'product';
    }

    public function auditEntityId(): ?int
    {
        return $this->product->id;
    }

    public function auditMetadata(): array
    {
        return [
            'name' => $this->product->name,
        ];
    }

    public function auditStoreId(): ?int
    {
        return $this->product->store_id;
    }

    public function auditActorId(): ?int
    {
        return auth('store')->id();
    }
}
