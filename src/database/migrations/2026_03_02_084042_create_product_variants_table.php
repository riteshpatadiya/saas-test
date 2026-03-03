<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('sku', 50);
            $table->decimal('price', 12, 2);
            $table->jsonb('attributes')->nullable();
            $table->string('status', 20)->default('ACTIVE');
            $table->timestamps();

            $table->unique(['store_id', 'sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
