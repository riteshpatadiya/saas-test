<?php

namespace App\Http\Controllers\Store\Dashboard;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('store.dashboard.index');
    }
}
