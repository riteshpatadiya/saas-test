<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InventoryLevel extends Model
{
    protected $fillable = [
        'store_id',
        'product_variant_id',
        'store_location_id',
        'qty',
    ];


    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function location()
    {
        return $this->belongsTo(StoreLocation::class, 'store_location_id');
    }


    public function scopeForVariant(Builder $query, int $variantId): Builder
    {
        return $query->where('product_variant_id', $variantId);
    }

    public function scopeForLocation(Builder $query, int $locationId): Builder
    {
        return $query->where('store_location_id', $locationId);
    }

    public static function decrementAtomically(
        int $variantId,
        int $locationId,
        int $qty
    ): bool {
        $affected = static::query()
            ->where('product_variant_id', $variantId)
            ->where('store_location_id', $locationId)
            ->where('qty', '>=', $qty)
            ->decrement('qty', $qty);

        return $affected === 1;
    }

    public static function incrementStock(
        int $variantId,
        int $locationId,
        int $qty
    ): void {
        static::query()
            ->where('product_variant_id', $variantId)
            ->where('store_location_id', $locationId)
            ->increment('qty', $qty);
    }
}
