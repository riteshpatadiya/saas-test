<?php

namespace App\Http\Controllers\Admin\StoreUsers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Store;

class IndexController extends Controller
{
    public function __invoke()
    {
        $query = User::query()
            ->where('role', User::ROLE_STORE)
            ->with('store');

        $search = request('search');
        $storeId = request('store_id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', '%' . $search . '%')
                  ->orWhere('email', 'ILIKE', '%' . $search . '%');
            });
        }

        if ($storeId) {
            $query->where('store_id', $storeId);
        }

        $storeUsers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stores = Store::orderBy('name')->get();

        return view('admin.store-users.index', [
            'storeUsers' => $storeUsers,
            'stores' => $stores,
            'search' => $search,
            'storeId' => $storeId,
        ]);
    }
}

