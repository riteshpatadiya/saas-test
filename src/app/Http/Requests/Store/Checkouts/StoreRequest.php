<?php

namespace App\Http\Requests\Store\Checkouts;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
{
    /**
     * Fields whose nested structure should not be purifier-sanitized as plain text.
     */
    protected array $excludeSanitize = ['idempotency_key'];

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $rules = [
        'store_location_id'          => ['required' => 'required', 'integer' => 'integer'],
        'idempotency_key'             => ['required' => 'required', 'string' => 'string', 'max' => 'max:128'],
        'items'                       => ['required' => 'required', 'array' => 'array', 'min' => 'min:1'],
        'items.*.product_variant_id'  => ['required' => 'required', 'integer' => 'integer'],
        'items.*.quantity'            => ['required' => 'required', 'integer' => 'integer', 'min' => 'min:1'],
    ];

    public function rules(): array
    {
        $rules = parent::rules();

        $storeId = app('currentStore')->id;

        $rules['store_location_id']['exists'] = Rule::exists('store_locations', 'id')
            ->where('store_id', $storeId);

        $rules['items.*.product_variant_id']['exists'] = Rule::exists('product_variants', 'id')
            ->where('store_id', $storeId);

        return $rules;
    }
}
