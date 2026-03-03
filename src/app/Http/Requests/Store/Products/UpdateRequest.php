<?php

namespace App\Http\Requests\Store\Products;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = app('currentStore')->id;
        $product = $this->route('product');

        $rules['name'] = [
            'required',
            'string',
            Rule::unique('products')
                ->where(fn ($q) => $q->where('store_id', $storeId))
                ->ignore($product->id),
        ];

        return $rules;
    }
}

