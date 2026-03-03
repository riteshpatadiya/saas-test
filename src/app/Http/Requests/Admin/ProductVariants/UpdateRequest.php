<?php

namespace App\Http\Requests\Admin\ProductVariants;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = $this->input('store_id') ?? $this->route('variant')->store_id;

        $rules['sku']['unique'] = Rule::unique('product_variants')
            ->where(fn ($query) => $query->where('store_id', $storeId))
            ->ignore($this->route('variant')->id);

        return $rules;
    }
}

