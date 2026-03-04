<?php

namespace App\Http\Requests\Store\WebhookSubscriptions;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    protected array $rules = [
        'topic'        => ['required' => 'required'],
        'endpoint_url' => ['required' => 'required', 'url' => 'url', 'max' => 'max:2048'],
        'is_active'    => ['boolean' => 'boolean'],
    ];

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $webhookSubscription = $this->route('webhookSubscription');

        $this->rules['topic']['unique'] = Rule::unique('webhook_subscriptions')
            ->where(fn($query) => $query->where('store_id', app('currentStore')->id))
            ->ignore($webhookSubscription->id);
    }
}
