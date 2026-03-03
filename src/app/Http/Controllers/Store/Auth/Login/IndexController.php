<?php

namespace App\Http\Controllers\Store\Auth\Login;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('store.auth.login');
    }
}
