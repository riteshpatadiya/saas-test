<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('checkout_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('checkout_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('product_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->restrictOnDelete();

            $table->string('sku', 50);
            $table->string('product_name', 100);
            $table->string('variant_name', 100)->nullable();

            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkout_items');
    }
};
