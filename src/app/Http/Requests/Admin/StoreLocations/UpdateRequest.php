<?php

namespace App\Http\Requests\Admin\StoreLocations;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $storeLocation = $this->route('store_location');

        $storeId = $this->input('store_id') ?? $storeLocation->store_id;

        $this->rules['name']['unique'] = Rule::unique('store_locations')
            ->where(fn ($query) => $query->where('store_id', $storeId))
            ->ignore($storeLocation->id);
    }
}

