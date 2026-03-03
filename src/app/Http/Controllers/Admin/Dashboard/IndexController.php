<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard.index');
    }
}
