<?php

namespace App\Http\Controllers\Store\WebhookSubscriptions;

use App\Http\Controllers\Controller;
use App\Models\WebhookSubscription;
use Symfony\Component\HttpFoundation\Response;

class EditController extends Controller
{
    public function __invoke(string $store, WebhookSubscription $webhookSubscription)
    {
        abort_if($webhookSubscription->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        return view('store.webhook_subscriptions.edit', [
            'webhookSubscription' => $webhookSubscription,
            'topics'              => WebhookSubscription::TOPICS,
        ]);
    }
}
