<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    const STATUS_CREATED = 'CREATED';
    const STATUS_PAID    = 'PAID';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'store_id',
        'number',
        'status',
        'currency',
        'subtotal',
        'tax',
        'discount',
        'total',
        'paid_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function markPaid(): void
    {
        $this->update([
            'status'  => self::STATUS_PAID,
            'paid_at' => now(),
        ]);
    }
}
