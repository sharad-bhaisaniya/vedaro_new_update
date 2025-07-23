<?php

// database/migrations/xxxx_xx_xx_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('productName');
            $table->string('coupon_code');
            $table->string('category');
            $table->string('size');
            $table->string('weight');
            $table->text('productDescription1');
            $table->text('productDescription2')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discountPercentage', 5, 2);
            $table->decimal('discountPrice', 10, 2)->nullable();
            $table->string('image1');
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->integer('stock');
            $table->decimal('shipping_fee', 10, 2);
            $table->boolean('availability')->default(1);
            $table->boolean('on_sell')->default(1);
            $table->boolean('add_timer')->default(0);
            $table->timestamp('timer_end_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
