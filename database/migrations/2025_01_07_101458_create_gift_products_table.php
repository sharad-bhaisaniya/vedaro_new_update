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
            $table->string('product_image1')->nullable();
            $table->string('product_image2')->nullable();
            $table->string('product_image3')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gift_products');
    }
}
