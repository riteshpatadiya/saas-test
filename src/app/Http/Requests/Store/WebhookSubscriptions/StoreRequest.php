<?php

namespace App\Http\Requests\Store\WebhookSubscriptions;

use Illuminate\Validation\Rule;

use App\Http\Requests\BaseRequest;
use App\Models\WebhookSubscription;

class StoreRequest extends BaseRequest
{
    protected array $excludeSanitize = ['endpoint_url'];

    protected array $rules = [
        'topic'        => ['required' => 'required'],
        'endpoint_url' => ['required' => 'required', 'url' => 'url', 'max' => 'max:2048'],
    ];

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->rules['topic']['in'] = Rule::in(array_keys(WebhookSubscription::TOPICS));

        $this->rules['topic']['unique'] = Rule::unique('webhook_subscriptions')
            ->where(fn($query) => $query->where('store_id', app('currentStore')->id));
    }
}
