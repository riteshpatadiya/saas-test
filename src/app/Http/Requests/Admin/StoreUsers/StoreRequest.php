<?php

namespace App\Http\Requests\Admin\StoreUsers;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    protected array $rules = [
        'name' => [
            'required' => 'required',
            'max'      => 'max:100',
        ],
        'email' => [
            'required' => 'required',
            'email'    => 'email',
            'unique'   => 'unique:users,email',
        ],
        'password' => [
            'required' => 'required',
            'min'      => 'min:8',
        ],
        'store_id' => [
            'required' => 'required',
            'exists'   => 'exists:stores,id',
        ],
    ];
}

