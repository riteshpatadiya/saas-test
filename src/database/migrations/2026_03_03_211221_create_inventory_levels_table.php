<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_levels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('store_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('store_location_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('qty')->default(0);

            $table->timestamps();

            $table->unique([
                'product_variant_id',
                'store_location_id'
            ]);

            $table->index([
                'store_id',
                'product_variant_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_levels');
    }
};
