<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftProductsTable extends Migration
{
    public function up()
    {
        Schema::create('gift_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->string('size');
            $table->string('weight');
            $table->text('product_description1');
            $table->text('product_description2')->nullable();
            $table->string('product_image1');
            $table->string('product_image2')->nullable();
            $table->string('product_image3')->nullable();

            // New fields for gift management
            $table->boolean('is_active')->default(false);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('minimum_cart_amount', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gift_products');
    }
}
