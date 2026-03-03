<?php

namespace App\Http\Controllers\Admin\Inventories;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;
use App\Models\StoreLocation;
use App\Models\Inventory;

class ShowController extends Controller
{
    public function __invoke(ProductVariant $variant)
    {
        $variant->load(['store', 'product']);

        $locations = StoreLocation::where('store_id', $variant->store_id)
            ->orderBy('name')
            ->get();

        $locationStocks = [];

        foreach ($locations as $location) {
            $locationStocks[$location->id] = Inventory::where('product_variant_id', $variant->id)
                ->where('store_location_id', $location->id)
                ->sum('quantity');
        }

        $history = Inventory::with('storeLocation')
            ->where('product_variant_id', $variant->id)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('admin.inventories.show', [
            'variant'        => $variant,
            'locations'      => $locations,
            'locationStocks' => $locationStocks,
            'history'        => $history,
        ]);
    }
}

