<?php

namespace App\Events;

use App\Contracts\AuditableEvent;
use App\Models\WebhookSubscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebhookSubscriptionCreatedEvent implements AuditableEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WebhookSubscription $subscription
    ) {}

    public function auditAction(): string
    {
        return 'webhook_subscription.created';
    }

    public function auditEntityType(): string
    {
        return 'webhook_subscription';
    }

    public function auditEntityId(): ?int
    {
        return $this->subscription->id;
    }

    public function auditMetadata(): array
    {
        return [
            'topic'        => $this->subscription->topic,
            'endpoint_url' => $this->subscription->endpoint_url,
        ];
    }

    public function auditStoreId(): ?int
    {
        return $this->subscription->store_id;
    }

    public function auditActorId(): ?int
    {
        return auth('store')->id();
    }
}
