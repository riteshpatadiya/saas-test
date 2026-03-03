<?php

namespace App\Http\Controllers\Store\Auth\Login;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

// Models
use App\Models\User;

// Requests
use App\Http\Requests\Store\Auth\LoginRequest;

class PostController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $requestData = $request->validated();
        $requestData['role'] = User::ROLE_STORE;
        $requestData['store_id'] = app('currentStore')->id;

        if (! Auth::guard('store')->attempt($requestData)) {
            return back()
                ->withErrors([
                    'email' => 'Invalid credentials.',
                ])
                ->onlyInput('email');
        }


        $request->session()->regenerate();

        return redirect()->intended(route('store.dashboard.index'));
    }
}
