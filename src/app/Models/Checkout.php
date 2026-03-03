<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Checkout extends Model
{
    use HasFactory;

    const STATUS_OPEN      = 'OPEN';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_EXPIRED   = 'EXPIRED';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'store_id',
        'store_location_id',
        'order_id',
        'token',
        'idempotency_key',
        'status',
        'subtotal',
        'tax',
        'total',
        'expires_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subtotal'   => 'decimal:2',
            'tax'        => 'decimal:2',
            'total'      => 'decimal:2',
            'expires_at' => 'datetime',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function storeLocation(): BelongsTo
    {
        return $this->belongsTo(StoreLocation::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CheckoutItem::class);
    }

    public function inventoryReservations(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isOpen(): bool
    {
        return $this->status === self::STATUS_OPEN && ! $this->isExpired();
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isExpiredState(): bool
    {
        return $this->isExpired() || $this->status === self::STATUS_EXPIRED;
    }

    public function markCompleted(Order $order): void
    {
        $this->update([
            'status'   => self::STATUS_COMPLETED,
            'order_id' => $order->id,
        ]);
    }

    public function markExpired(): void
    {
        if ($this->status !== self::STATUS_EXPIRED) {
            $this->update(['status' => self::STATUS_EXPIRED]);
        }
    }
}
