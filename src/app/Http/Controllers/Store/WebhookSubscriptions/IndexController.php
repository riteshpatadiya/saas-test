<?php

namespace App\Http\Controllers\Store\WebhookSubscriptions;

use App\Http\Controllers\Controller;
use App\Models\WebhookSubscription;

class IndexController extends Controller
{
    public function __invoke()
    {
        $webhookSubscriptions = WebhookSubscription::query()
            ->where('store_id', app('currentStore')->id)
            ->latest()
            ->paginate(15);

        return view('store.webhook_subscriptions.index', [
            'webhookSubscriptions' => $webhookSubscriptions,
        ]);
    }
}
