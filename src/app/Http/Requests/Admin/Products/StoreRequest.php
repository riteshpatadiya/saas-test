<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    protected array $rules = [
        'store_id' => [
            'required' => 'required',
            'exists'   => 'exists:stores,id',
        ],
        'name' => [
            'required' => 'required',
            'max'      => 'max:50',
        ],
        'description' => [
            'nullable' => 'nullable',
        ],
    ];

    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = $this->input('store_id');

        $rules['name']['unique'] = Rule::unique('products')
            ->where(fn ($query) => $query->where('store_id', $storeId));

        return $rules;
    }
}

