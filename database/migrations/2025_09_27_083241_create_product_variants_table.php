<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->string('size')->nullable();          // e.g. "6", "7", "8" or NULL
            $table->decimal('weight', 8, 2)->nullable(); // grams or carats
            $table->decimal('price', 10, 2);             // original price
            $table->integer('stock')->default(0);        // stock for this size
            $table->decimal('discount_price', 10, 2)->nullable(); // optional pre-calculated
            
            $table->string('sku')->unique()->nullable(); // optional unique code
            $table->json('attributes')->nullable();      // extra attributes like purity, color

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
