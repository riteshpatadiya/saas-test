<?php

namespace App\Listeners;

// Events
use App\Events\OrderCreatedEvent;
use App\Events\OrderPaidEvent;

// Job
use App\Jobs\DeliverWebhookJob;

// Models
use App\Models\WebhookDelivery;
use App\Models\WebhookSubscription;

use Illuminate\Support\Str;

class DispatchWebhookForOrderListener
{
    public function handle(OrderCreatedEvent|OrderPaidEvent $event): void
    {
        $topic = $event instanceof OrderCreatedEvent
            ? 'order.created'
            : 'order.paid';

        $order = $event->order;

        $subscriptions = WebhookSubscription::query()
            ->where('store_id', $order->store_id)
            ->where('topic', $topic)
            ->where('is_active', true)
            ->get();

        if ($subscriptions->isEmpty()) {
            return;
        }

        $eventId = (string) Str::uuid();

        $payload = [
            'id' => $eventId,
            'type' => $topic,
            'occurred_at' => now()->toISOString(),
            'store_id' => $order->store_id,
            'data' => [
                'order' => [
                    'id' => $order->id,
                    'number' => $order->number,
                    'status' => $order->status,
                    'total' => $order->total,
                    'currency' => $order->currency,
                ],
            ],
        ];

        foreach ($subscriptions as $subscription) {

            $delivery = WebhookDelivery::firstOrCreate(
                [
                    'subscription_id' => $subscription->id,
                    'event_id' => $eventId,
                ],
                [
                    'event_type' => $topic,
                    'payload_json' => $payload,
                    'status' => 'PENDING',
                ]
            );

            DeliverWebhookJob::dispatch($delivery);
        }
    }
}
