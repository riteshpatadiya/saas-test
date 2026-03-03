<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->restrictOnDelete();

            $table->foreignId('store_location_id')
                  ->constrained('store_locations')
                  ->restrictOnDelete();

            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders')
                  ->restrictOnDelete();

            $table->integer('quantity');

            $table->string('note')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
