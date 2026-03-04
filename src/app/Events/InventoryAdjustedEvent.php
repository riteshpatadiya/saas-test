<?php

namespace App\Events;

use App\Contracts\AuditableEvent;
use App\Models\ProductVariant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryAdjustedEvent implements AuditableEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public ProductVariant $variant,
        public string $mode,
        public int $delta,
        public int $storeLocationId,
        public ?string $note
    ) {}

    public function auditAction(): string
    {
        return 'inventory.adjusted';
    }

    public function auditEntityType(): string
    {
        return 'product_variant';
    }

    public function auditEntityId(): ?int
    {
        return $this->variant->id;
    }

    public function auditMetadata(): array
    {
        return [
            'product_variant_id' => $this->variant->id,
            'store_location_id'  => $this->storeLocationId,
            'mode'               => $this->mode,
            'delta'              => $this->delta,
            'note'               => $this->note,
        ];
    }

    public function auditStoreId(): ?int
    {
        return app('currentStore')?->id;
    }

    public function auditActorId(): ?int
    {
        return auth('store')->id();
    }
}
