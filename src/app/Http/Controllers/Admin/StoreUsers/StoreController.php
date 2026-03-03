<?php

namespace App\Http\Controllers\Admin\StoreUsers;

use App\Http\Controllers\Controller;

use App\Models\User;

use App\Http\Requests\Admin\StoreUsers\StoreRequest;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();

        $requestData['role'] = User::ROLE_STORE;

        User::create($requestData);

        flash('Store user created successfully')->success();

        return redirect()->route('admin.store-users.index');
    }
}

