<?php

namespace App\Http\Requests\Admin\ProductVariants;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    protected array $excludeSanitize = [
        'attributes',
    ];

    protected array $rules = [
        'store_id' => [
            'required' => 'required',
            'exists'   => 'exists:stores,id',
        ],
        'product_id' => [
            'required' => 'required',
            'exists'   => 'exists:products,id',
        ],
        'sku' => [
            'required' => 'required',
            'max'      => 'max:50',
        ],
        'price' => [
            'required' => 'required',
            'numeric'  => 'numeric',
            'min'      => 'min:0',
        ],
        'attributes' => [
            'nullable' => 'nullable',
            'json'    => 'json',
        ],
        'status' => [
            'required' => 'required',
            'in'       => 'in:ACTIVE,INACTIVE',
        ],
    ];

    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = $this->input('store_id');

        $rules['sku']['unique'] = Rule::unique('product_variants')
            ->where(fn ($query) => $query->where('store_id', $storeId));

        return $rules;
    }
}

