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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->string('expense_type'); // e.g. Rent, Courier, Marketing
            $table->text('description')->nullable(); // optional details

            $table->decimal('amount', 10, 2); // expense amount
            $table->date('expense_date'); // expense date

            $table->string('payment_type')->nullable(); // e.g. Cash, UPI, Bank
            $table->string('transaction_number')->nullable(); // optional transaction ref

            $table->string('bill_image')->nullable(); // image path for uploaded bill
            $table->text('note')->nullable(); // optional note or remarks

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
