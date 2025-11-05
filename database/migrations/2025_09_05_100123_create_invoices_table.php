<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // invoices table
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // User reference (kept as string since you already made it so)
            $table->string('user_id');

            // 🔹 New column: offline or online invoice
            $table->enum('offline_online', ['offline', 'online'])->default('online');

            // Customer information (stored directly for historical preservation)
            $table->string('customer_name');
            $table->text('customer_address')->nullable();
            $table->string('customer_gstin')->nullable();
            $table->string('admin_gstin')->nullable();

            // Invoice details
            $table->string('invoice_number')->unique();
            $table->string('order_number')->nullable();
            $table->date('invoice_date');

            // Financial information
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('offline_online');
        });

        // invoice_items table
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            // Foreign key linking to invoices table
            $table->unsignedBigInteger('invoice_id');

            // Item details
            $table->string('item_name');
            $table->string('category')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('rate', 12, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0); // percentage

            // Tax information stored as JSON
            $table->json('taxes')->nullable();

            // ITC eligibility and amount
            $table->boolean('eligible_for_itc')->default(false);
            $table->decimal('amount', 12, 2)->default(0);

            // Timestamps
            $table->timestamps();

            // Index
            $table->index('invoice_id');

            // Foreign key constraint
            $table->foreign('invoice_id')
                  ->references('id')
                  ->on('invoices')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        // Drop foreign keys first
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
        });

        // Then drop the tables
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
