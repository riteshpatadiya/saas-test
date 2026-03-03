<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;

class NewController extends Controller
{
    public function __invoke()
    {
        return view('admin.stores.new');
    }
}
