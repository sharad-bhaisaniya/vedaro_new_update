<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('material')->nullable()->after('productDescription2');
            $table->string('color')->nullable()->after('material');
            $table->text('variants')->nullable()->after('color');
            $table->string('hsn_code')->nullable()->after('variants');
            $table->string('sku')->nullable()->after('hsn_code');
            $table->string('barcode')->nullable()->after('sku');
            $table->string('supplier_name')->nullable()->after('barcode');
            $table->decimal('cost_price_per_unit', 10, 2)->nullable()->after('supplier_name');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'material',
                'color',
                'variants',
                'hsn_code',
                'sku',
                'barcode',
                'supplier_name',
                'cost_price_per_unit',
            ]);
        });
    }
}
