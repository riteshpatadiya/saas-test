<?php

namespace App\Http\Controllers\Admin\StoreUsers;

use App\Http\Controllers\Controller;

use App\Models\User;

class DeleteController extends Controller
{
    public function __invoke(User $user)
    {
        $user->delete();

        flash('Store user deleted successfully')->success();

        return redirect()->route('admin.store-users.index');
    }
}

