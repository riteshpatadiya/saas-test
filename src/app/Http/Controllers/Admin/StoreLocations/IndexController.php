<?php

namespace App\Http\Controllers\Admin\StoreLocations;

use App\Http\Controllers\Controller;

// Models
use App\Models\StoreLocation;
use App\Models\Store;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = StoreLocation::query()->with('store');

        $search = request('search');
        $storeId = request('store_id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', '%' . $search . '%')
                  ->orWhere('address', 'ILIKE', '%' . $search . '%');
            });
        }

        if ($storeId) {
            $query->where('store_id', $storeId);
        }

        $locations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stores = Store::orderBy('name')->get();

        return view('admin.store-locations.index', [
            'locations' => $locations,
            'stores'    => $stores,
            'search'    => $search,
            'storeId'   => $storeId,
        ]);
    }
}

