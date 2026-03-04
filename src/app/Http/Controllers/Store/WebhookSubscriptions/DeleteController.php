<?php

namespace App\Http\Controllers\Store\WebhookSubscriptions;

use App\Http\Controllers\Controller;
use App\Models\WebhookSubscription;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function __invoke(WebhookSubscription $webhookSubscription)
    {
        abort_if($webhookSubscription->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $webhookSubscription->delete();

        flash('Webhook subscription deleted successfully.')->success();

        return redirect()->route('store.webhook_subscriptions.index');
    }
}
