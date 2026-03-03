<?php

namespace App\Http\Controllers\Admin\StoreUsers;

use App\Http\Controllers\Controller;

use App\Models\User;

use App\Http\Requests\Admin\StoreUsers\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user)
    {
        $requestData = $request->validated();

        if (empty($requestData['password'])) {
            unset($requestData['password']);
        }

        $requestData['role'] = User::ROLE_STORE;

        $user->update($requestData);

        flash('Store user updated successfully')->success();

        return redirect()->route('admin.store-users.index');
    }
}

