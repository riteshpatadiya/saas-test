<?php

namespace App\Http\Requests\Admin\Stores;

use Illuminate\Validation\Rule;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
     protected array $rules = [
        'name' => [
            'required' => 'required',
            'max'      => 'max:100',
            'unique'   => 'unique:stores,name'
        ]
    ];
}
