<?php

namespace App\Http\Controllers\Store\WebhookSubscriptions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\WebhookSubscriptions\UpdateRequest;
use App\Models\WebhookSubscription;
use Symfony\Component\HttpFoundation\Response;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, string $store, WebhookSubscription $webhookSubscription)
    {
        abort_if($webhookSubscription->store_id !== app('currentStore')->id, Response::HTTP_NOT_FOUND);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $webhookSubscription->update($data);

        flash('Webhook subscription updated successfully.')->success();

        return redirect()->route('store.webhook_subscriptions.index');
    }
}
