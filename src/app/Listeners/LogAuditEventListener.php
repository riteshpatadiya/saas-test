<?php

namespace App\Listeners;

use App\Contracts\AuditableEvent;
use App\Models\AuditLog;

class LogAuditEventListener
{
    public function handle(AuditableEvent $event): void
    {
        AuditLog::create([
            'store_id'    => $event->auditStoreId(),
            'actor_id'    => $event->auditActorId(),
            'actor_type'  => 'user',
            'action'      => $event->auditAction(),
            'entity_type' => $event->auditEntityType(),
            'entity_id'   => $event->auditEntityId(),
            'metadata'    => $event->auditMetadata() ?: null,
        ]);
    }
}
