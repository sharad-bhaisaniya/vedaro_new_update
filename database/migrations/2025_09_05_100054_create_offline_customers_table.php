<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offline_customers', function (Blueprint $table) {
            $table->id();

            // Optional relation to users table (nullable)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Customer Details
            $table->string('name'); // required
            $table->string('email')->unique(); // required
            $table->string('phone')->unique(); // required
            $table->text('address'); // required
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offline_customers');
    }
};
