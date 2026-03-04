<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public const UPDATED_AT = null;

    public const ACTIONS = [
        'product.created'              => 'Product Created',
        'product.updated'              => 'Product Updated',
        'inventory.adjusted'           => 'Inventory Adjusted',
        'checkout.completed'           => 'Checkout Completed',
        'webhook_subscription.created' => 'Webhook Subscription Created',
        'webhook_subscription.updated' => 'Webhook Subscription Updated',
        'webhook_subscription.deleted' => 'Webhook Subscription Deleted',
    ];

    protected $fillable = [
        'store_id',
        'actor_id',
        'actor_type',
        'action',
        'entity_type',
        'entity_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata'   => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function getActionLabelAttribute(): string
    {
        return self::ACTIONS[$this->action] ?? $this->action;
    }
}
