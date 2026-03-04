<?php

namespace App\Events;

use App\Contracts\AuditableEvent;
use App\Models\WebhookSubscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebhookSubscriptionUpdatedEvent implements AuditableEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WebhookSubscription $subscription,
        public array $changes
    ) {}

    public function auditAction(): string
    {
        return 'webhook_subscription.updated';
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
            'changes' => $this->changes,
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
