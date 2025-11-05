<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableWithBillingBrandRfid extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Billing fields
            $table->decimal('tax_rate', 5, 2)->default(0.00)->after('hsn_code'); // tax %
            $table->decimal('purchase_price', 10, 2)->nullable()->after('tax_rate'); // cost price internal
            $table->decimal('mrp', 10, 2)->nullable()->after('purchase_price'); // maximum retail price
            $table->boolean('is_tax_inclusive')->default(1)->after('mrp'); // price includes tax?

            // Brand
            $table->string('brand')->nullable()->after('barcode'); // Brand Manufactured

            // RFID
            $table->string('rfid')->nullable()->after('brand'); // RFID tag
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'tax_rate',
                'purchase_price',
                'mrp',
                'is_tax_inclusive',
                'brand',
                'rfid',
            ]);
        });
    }
}
