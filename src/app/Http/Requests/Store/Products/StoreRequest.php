<?php

namespace App\Http\Requests\Store\Products;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    /**
     * @var array<string, array<string, string>>
     */
    protected array $rules = [
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

        $storeId = app('currentStore')->id;

        $rules['name']['unique'] = Rule::unique('products')
            ->where(fn ($query) => $query->where('store_id', $storeId));

        return $rules;
    }
}

