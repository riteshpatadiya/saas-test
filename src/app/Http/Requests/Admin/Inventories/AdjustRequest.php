<?php

namespace App\Http\Requests\Admin\Inventories;

use App\Http\Requests\BaseRequest;

class AdjustRequest extends BaseRequest
{
    /**
     * @var array<string, array<string, string>>
     */
    protected array $rules = [
        'product_variant_id' => [
            'required' => 'required',
            'exists'   => 'exists:product_variants,id',
        ],
        'store_location_id' => [
            'required' => 'required',
            'exists'   => 'exists:store_locations,id',
        ],
        'mode' => [
            'required' => 'required',
            'in'       => 'in:set,increment,decrement',
        ],
        'quantity' => [
            'required' => 'required',
            'integer'  => 'integer',
            'min'      => 'min:0',
        ],
        'note' => [
            'nullable' => 'nullable',
            'max'      => 'max:255',
        ],
    ];
}

