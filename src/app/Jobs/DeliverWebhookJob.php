<?php

namespace App\Jobs;

use App\Models\WebhookDelivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DeliverWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // max attempts

    protected WebhookDelivery $delivery;

    public function __construct(WebhookDelivery $delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * Exponential backoff: 1m, 5m, 15m
     */
    public function backoff(): array
    {
        return [60, 300, 900];
    }

    public function handle(): void
    {
        // Prevent duplicate delivery if already completed
        if ($this->delivery->status === 'DELIVERED') {
            return;
        }

        $subscription = $this->delivery->subscription;

        $payload = $this->delivery->payload_json;
        $rawPayload = json_encode($payload);

        $signature = hash_hmac(
            'sha256',
            $rawPayload,
            $subscription->secret
        );

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'X-Webhook-Signature' => 'sha256=' . $signature,
                    'Content-Type' => 'application/json',
                ])
                ->post($subscription->endpoint_url, $payload);

            // Increment attempts
            $this->delivery->increment('attempts');

            if ($response->successful()) {
                $this->delivery->update([
                    'status' => 'DELIVERED',
                    'http_status' => $response->status(),
                    'response_body' => $response->body(),
                    'delivered_at' => now(),
                    'last_error' => null,
                ]);

                return;
            }

            // Non-2xx response
            $this->handleFailure(
                $response->status(),
                $response->body()
            );

        } catch (Throwable $e) {

            $this->delivery->increment('attempts');

            $this->handleFailure(
                null,
                $e->getMessage()
            );

            throw $e; // rethrow so Laravel retries
        }
    }

    protected function handleFailure(?int $status, string $error): void
    {
        $this->delivery->update([
            'status' => 'PENDING',
            'http_status' => $status,
            'response_body' => $status ? $error : null,
            'last_error' => $error,
        ]);

        // If this was final attempt
        if ($this->attempts() >= $this->tries) {
            $this->delivery->update([
                'status' => 'FAILED'
            ]);
        }
    }

    /**
     * Ensure job is unique per delivery
     */
    public function uniqueId(): string
    {
        return 'webhook_delivery_' . $this->delivery->id;
    }
}
