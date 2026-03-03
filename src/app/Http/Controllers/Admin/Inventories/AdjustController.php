<?php

namespace App\Http\Controllers\Admin\Inventories;

use App\Http\Controllers\Controller;

// Models
use App\Models\Inventory;
use App\Models\ProductVariant;
use App\Models\InventoryLevel;

// Requests
use App\Http\Requests\Admin\Inventories\AdjustRequest;

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
            $inventory = Inventory::create([
                'product_variant_id' => $variant->id,
                'store_location_id'  => $data['store_location_id'],
                'order_id'           => null,
                'quantity'           => $delta,
                'note'               => $data['note'] ?? null,
            ]);

            if ($data['mode'] === 'set') {
                InventoryLevel::create([
                    'store_id' => $variant->store_id,
                    'store_location_id' => $data['store_location_id'],
                    'product_variant_id' => $variant->id,
                    'qty' => $delta
                ]);
            }
        }

        flash('Inventory updated successfully')->success();

        return redirect()->route('admin.inventories.show', ['variant' => $variant->id]);
    }
}

