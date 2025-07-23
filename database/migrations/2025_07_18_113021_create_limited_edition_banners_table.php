<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitedEditionBannersTable extends Migration
{
    public function up(): void
    {
        Schema::create('limited_edition_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image'); // store path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('limited_edition_banners');
    }
}
