<?php

namespace App\Http\Controllers\Store\WebhookSubscriptions;

use App\Events\WebhookSubscriptionCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\WebhookSubscriptions\StoreRequest;
use App\Models\WebhookSubscription;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $requestData = $request->validated();
        $requestData['store_id'] = app('currentStore')->id;
        $requestData['secret']   = Str::random(32);
        $requestData['is_active'] = true;

        $subscription = WebhookSubscription::create($requestData);

        event(new WebhookSubscriptionCreatedEvent($subscription));

        flash('Webhook subscription created successfully.')->success();

        return redirect()->route('store.webhook_subscriptions.index');
    }
}
