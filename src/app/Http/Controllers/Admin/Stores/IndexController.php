<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;

// Models
use App\Models\Store;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = Store::query();

        $search = request('search');

        if ($search) {
            $query->where('name', 'ILIKE', '%' . $search . '%');
        }

        $stores = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.stores.index', [
            'stores' => $stores,
            'search' => $search,
        ]);
    }
}
