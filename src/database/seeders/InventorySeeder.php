<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Models
use App\Models\ProductVariant;
use App\Models\StoreLocation;
use App\Models\Inventory;
use App\Models\InventoryLevel;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $variants = ProductVariant::with('store')->get();

        if ($variants->isEmpty()) {
            return;
        }

        foreach ($variants as $variant) {
            if (!$variant->store) {
                continue;
            }

            $locations = StoreLocation::where('store_id', $variant->store_id)->get();

            if ($locations->isEmpty()) {
                continue;
            }

            foreach ($locations as $index => $location) {
                // Simple demo pattern: 10, 20, 30... units per location
                $quantity = ($index + 1) * 10;

                Inventory::create([
                    'product_variant_id' => $variant->id,
                    'store_location_id'  => $location->id,
                    'order_id'           => null,
                    'quantity'           => $quantity,
                    'note'               => 'Seeded initial stock',
                ]);

                InventoryLevel::create([
                    'store_id' => $variant->store_id,
                    'store_location_id' => $location->id,
                    'product_variant_id' => $variant->id,
                    'qty' => $quantity
                ]);
            }
        }
    }
}

