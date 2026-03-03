<?php

namespace App\Http\Controllers\Store\Checkouts;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\StoreLocation;

class NewController extends Controller
{
    public function __invoke()
    {
        $storeId = app('currentStore')->id;

        $locations = StoreLocation::where('store_id', $storeId)
            ->orderBy('name')
            ->get();

        $variants = ProductVariant::with('product')
            ->where('store_id', $storeId)
            ->where('status', 'ACTIVE')
            ->orderBy('sku')
            ->get();

        // Format options for the select: "SKU — Product Name"
        $variantOptions = $variants->mapWithKeys(function ($variant) {
            $label = $variant->sku . ' — ' . optional($variant->product)->name;
            return [$variant->id => $label];
        })->all();

        return view('store.checkouts.new', [
            'locations'      => $locations,
            'variantOptions' => $variantOptions,
        ]);
    }
}
