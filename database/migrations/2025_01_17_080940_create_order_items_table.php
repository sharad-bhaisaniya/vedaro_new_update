<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->integer('order_id'); // Changed from foreignId to integer
        $table->integer('product_id');
        $table->integer('product_qty');
        $table->decimal('price', 8, 2);
        $table->decimal('total', 8, 2); // price * quantity
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
