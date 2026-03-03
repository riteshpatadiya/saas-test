<?php

namespace App\Http\Requests\Store\Locations;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $storeLocation = $this->route('storeLocation');

        $this->rules['name']['unique'] = Rule::unique('store_locations')
        ->where(fn($query) => $query->where('store_id', app('currentStore')->id))
        ->ignore($storeLocation->id);
    }
}
