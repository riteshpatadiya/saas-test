<?php

namespace App\Http\Controllers\Admin\Auth\Login;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

// Models
use App\Models\User;

// Requests
use App\Http\Requests\Admin\Auth\LoginRequest;

class PostController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $requestData = $request->validated();
        $requestData['role'] = User::ROLE_ADMIN;

        if (! Auth::guard('admin')->attempt($requestData)) {
            return back()
                ->withErrors([
                    'email' => 'Invalid credentials.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard.index'));
    }
}
