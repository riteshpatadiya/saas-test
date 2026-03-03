<?php

namespace App\Http\Requests\Store\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
     protected array $rules = [
        'email' => [
            'required' => 'required',
            'email'      => 'email'
        ],
        'password' => [
            'required' => 'required'
        ]
    ];
}
