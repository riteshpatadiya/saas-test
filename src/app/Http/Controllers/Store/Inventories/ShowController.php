<?php

namespace App\Http\Controllers\Store\Inventories;

use App\Http\Controllers\Controller;

// Models
use App\Models\ProductVariant;
use App\Models\StoreLocation;
use App\Models\Inventory;

use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{
    public function __invoke(string $store, ProductVariant $variant)
    {
        abort_if($variant->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $variant->load(['product']);

        $locations = StoreLocation::where('store_id', app('currentStore')->id)
            ->orderBy('name')
            ->get();

        $locationStocks = [];

        foreach ($locations as $location) {
            $locationStocks[$location->id] = Inventory::where('product_variant_id', $variant->id)
                ->whereHas('storeLocation', function ($query) use ($location) {
                    $query->where('id', $location->id);
                })
                ->sum('quantity');
        }

        $history = Inventory::with('storeLocation')
            ->whereHas('storeLocation', function ($query) {
                $query->where('store_id', app('currentStore')->id);
            })
            ->where('product_variant_id', $variant->id)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('store.inventories.show', [
            'variant'        => $variant,
            'locations'      => $locations,
            'locationStocks' => $locationStocks,
            'history'        => $history,
        ]);
    }
}

