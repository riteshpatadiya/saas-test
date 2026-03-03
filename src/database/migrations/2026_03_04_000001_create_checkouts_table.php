<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('store_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('store_location_id')
                  ->constrained('store_locations')
                  ->restrictOnDelete();

            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders')
                  ->nullOnDelete();

            $table->string('token', 64)->unique();
            $table->string('idempotency_key', 128)->unique();
            $table->string('status', 15); // OPEN, COMPLETED, EXPIRED

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index(['store_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
