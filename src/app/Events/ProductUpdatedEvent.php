<?php

namespace App\Events;

use App\Contracts\AuditableEvent;
use App\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdatedEvent implements AuditableEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Product $product,
        public array $before,
        public array $after
    ) {}

    public function auditAction(): string
    {
        return 'product.updated';
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
            'before' => $this->before,
            'after'  => $this->after,
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
