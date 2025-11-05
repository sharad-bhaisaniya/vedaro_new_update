<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tax name e.g., GST, VAT
            $table->string('tax_group')->nullable(); // Tax group e.g., Goods, Services
            $table->decimal('rate', 10, 2); // Tax rate in percentage
            $table->boolean('is_active')->default(true);
            $table->string('code')->nullable(); // Optional tax code
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxes');
    }
};
