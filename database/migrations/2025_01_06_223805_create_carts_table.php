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
        Schema::create('carts', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id');
    $table->integer('product_qty')->default(1);
    $table->decimal('total', 10, 2)->nullable(); // Make 'total' nullable
    $table->unsignedBigInteger('customer_id')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

