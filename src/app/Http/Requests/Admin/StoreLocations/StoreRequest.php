<?php

namespace App\Http\Requests\Admin\StoreLocations;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    /**
     * @var array<string, array<string, string>>
     */
    protected array $rules = [
        'store_id' => [
            'required' => 'required',
            'exists'   => 'exists:stores,id',
        ],
        'name' => [
            'required' => 'required',
            'max'      => 'max:100',
        ],
        'address' => [
            'required' => 'required',
            'max'      => 'max:255',
        ],
    ];

    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = $this->input('store_id');

        if ($storeId) {
            $rules['name']['unique'] = Rule::unique('store_locations')
                ->where(fn ($query) => $query->where('store_id', $storeId));
        }

        return $rules;
    }
}

