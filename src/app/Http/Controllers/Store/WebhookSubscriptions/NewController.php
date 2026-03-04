<?php

namespace App\Http\Controllers\Store\WebhookSubscriptions;

use App\Http\Controllers\Controller;
use App\Models\WebhookSubscription;

class NewController extends Controller
{
    public function __invoke()
    {
        return view('store.webhook_subscriptions.new', [
            'topics' => WebhookSubscription::TOPICS,
        ]);
    }
}
