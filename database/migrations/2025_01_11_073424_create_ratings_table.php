<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        // Check if the table doesn't exist before creating it
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->integer('product_id'); // ID of the product being reviewed
                $table->integer('user_id'); // ID of the product being reviewed
                $table->integer('rating'); // Star rating (1-5)
                $table->text('review')->nullable(); // Review text
                $table->string('name')->nullable(); // Name of the reviewer
                $table->string('review_title')->nullable(); // Review title
                $table->string('image')->nullable(); // Image uploaded with the review
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
