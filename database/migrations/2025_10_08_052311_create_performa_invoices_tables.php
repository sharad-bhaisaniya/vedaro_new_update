<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // performa_invoices table
        Schema::create('performa_invoices', function (Blueprint $table) {
            $table->id();

            // Reference to user (string as in your invoices)
            $table->string('user_id');

            // Offline or online invoice
            $table->enum('offline_online', ['offline', 'online'])->default('online');

            // Customer details
            $table->string('customer_name');
            $table->text('customer_address')->nullable();
            $table->string('customer_gstin')->nullable();
            $table->string('admin_gstin')->nullable();

            // Invoice details
            $table->string('performa_number')->unique(); // unique performa number
            $table->string('order_number')->nullable();
            $table->date('performa_date');

            // Financials
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('offline_online');
        });

        // performa_invoice_items table
        Schema::create('performa_invoice_items', function (Blueprint $table) {
            $table->id();

            // Foreign key to performa_invoices
            $table->unsignedBigInteger('performa_invoice_id');

            // Item details
            $table->string('item_name');
            $table->string('category')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('rate', 12, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);

            // Tax information
            $table->json('taxes')->nullable();

            // ITC and totals
            $table->boolean('eligible_for_itc')->default(false);
            $table->decimal('amount', 12, 2)->default(0);

            // Timestamps
            $table->timestamps();

            // Index + FK
            $table->index('performa_invoice_id');
            $table->foreign('performa_invoice_id')
                  ->references('id')
                  ->on('performa_invoices')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('performa_invoice_items', function (Blueprint $table) {
            $table->dropForeign(['performa_invoice_id']);
        });

        Schema::dropIfExists('performa_invoice_items');
        Schema::dropIfExists('performa_invoices');
    }
};
