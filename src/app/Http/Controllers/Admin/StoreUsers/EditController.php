<?php

namespace App\Http\Controllers\Admin\StoreUsers;

use App\Http\Controllers\Controller;

use App\Models\Store;
use App\Models\User;

class EditController extends Controller
{
    public function __invoke(User $user)
    {
        $stores = Store::query()
            ->orderBy('name')
            ->get();

        return view('admin.store-users.edit', [
            'user' => $user,
            'stores' => $stores,
        ]);
    }
}

