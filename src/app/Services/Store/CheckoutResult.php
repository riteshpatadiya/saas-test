<?php

namespace App\Services\Store;

class CheckoutResult
{
    public function __construct(
        protected ?int $checkoutId = null,
        protected array $errors = [],
        protected bool $redirect = false
    ) {}

    public static function success(int $id): self
    {
        return new self($id);
    }

    public static function redirect(int $id): self
    {
        return new self($id, [], true);
    }

    public static function error(array $errors): self
    {
        return new self(null, $errors);
    }

    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function checkoutId(): ?int
    {
        return $this->checkoutId;
    }

    public function isRedirect(): bool
    {
        return $this->redirect;
    }
}
