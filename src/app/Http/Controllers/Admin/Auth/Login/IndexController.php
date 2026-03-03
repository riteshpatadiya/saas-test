<?php

namespace App\Http\Controllers\Admin\Auth\Login;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.auth.login');
    }
}
