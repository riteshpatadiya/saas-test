<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhook_deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subscription_id')
                  ->constrained('webhook_subscriptions')
                  ->restrictOnDelete();

            $table->string('event_id');
            $table->string('event_type');

            $table->json('payload_json');

            $table->integer('http_status')->nullable();
            $table->text('response_body')->nullable();

            $table->integer('attempts')->default(0);

            $table->string('status')->default('PENDING');
            // PENDING, DELIVERED, FAILED

            $table->text('last_error')->nullable();
            $table->timestamp('next_retry_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();

            $table->unique(['subscription_id', 'event_id']);
            $table->index(['status', 'next_retry_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_deliveries');
    }
};
