<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhook_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('store_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->string('topic'); // order.created, order.paid
            $table->text('endpoint_url');
            $table->string('secret');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['store_id', 'topic']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_subscriptions');
    }
};
