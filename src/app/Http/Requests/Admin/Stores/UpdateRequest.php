<?php

namespace App\Http\Requests\Admin\Stores;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $storeId = $this->route('store')->id;

        $this->rules['name']['unique'] = Rule::unique('stores')->ignore($storeId);
    }
}
