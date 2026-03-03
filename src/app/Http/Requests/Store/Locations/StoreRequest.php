<?php

namespace App\Http\Requests\Store\Locations;

use Illuminate\Validation\Rule;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
     protected array $rules = [
        'name' => [
            'required' => 'required',
            'max'      => 'max:100'
        ],
        'address' => [
            'required' => 'required',
            'max' => 'max:255'
        ]
    ];

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->rules['name']['unique'] = Rule::unique('store_locations')
        ->where(fn($query) => $query->where('store_id', app('currentStore')->id));
    }
}
