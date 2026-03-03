<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{

    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = $this->input('store_id') ?? $this->route('product')->store_id;

        $rules['name']['unique'] = Rule::unique('products')
            ->where(fn ($query) => $query->where('store_id', $storeId))
            ->ignore($this->route('product')->id);

        return $rules;  
    }
}

