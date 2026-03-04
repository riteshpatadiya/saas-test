<?php

namespace App\Http\Controllers\Store\Inventories;

use App\Events\InventoryAdjustedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Inventories\AdjustRequest;
use App\Models\Inventory;
use App\Models\ProductVariant;

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

            event(new InventoryAdjustedEvent(
                variant: $variant,
                mode: $data['mode'],
                delta: $delta,
                storeLocationId: $data['store_location_id'],
                note: $data['note'] ?? null,
            ));
        }

        flash('Inventory updated successfully')->success();

        return redirect()->route('store.inventories.show', ['variant' => $variant->id]);
    }
}
