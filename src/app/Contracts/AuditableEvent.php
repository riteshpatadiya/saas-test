<?php

namespace App\Contracts;

interface AuditableEvent
{
    public function auditAction(): string;

    public function auditEntityType(): string;

    public function auditEntityId(): ?int;

    public function auditMetadata(): array;

    public function auditStoreId(): ?int;

    public function auditActorId(): ?int;
}
