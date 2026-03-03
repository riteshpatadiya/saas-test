<?php

namespace App\Http\Controllers\Store\Inventories;

use App\Http\Controllers\Controller;

// Models
use App\Models\Inventory;
use App\Models\ProductVariant;

// Requests
use App\Http\Requests\Store\Inventories\AdjustRequest;

class AdjustController extends Controller
{
    public function __invoke(AdjustRequest $request)
    {
        $data = $request->validated();

        /** @var ProductVariant $variant */
        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        $currentQty = Inventory::where('product_variant_id', $variant->id)
            ->where('store_location_id', $data['store_location_id'])
            ->sum('quantity');

        $delta = 0;

        if ($data['mode'] === 'set') {
            $target = (int) $data['quantity'];
            $delta = $target - $currentQty;
        } elseif ($data['mode'] === 'increment') {
            $delta = (int) $data['quantity'];
        } elseif ($data['mode'] === 'decrement') {
            $delta = -1 * (int) $data['quantity'];
        }

        if ($delta !== 0) {
            Inventory::create([
                'product_variant_id' => $variant->id,
                'store_location_id'  => $data['store_location_id'],
                'order_id'           => null,
                'quantity'           => $delta,
                'note'               => $data['note'] ?? null,
            ]);
        }

        flash('Inventory updated successfully')->success();

        return redirect()->route('store.inventories.show', ['variant' => $variant->id]);
    }
}

