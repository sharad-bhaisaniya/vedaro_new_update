<?php


// Step 1: Update migration to support multiple size stock tracking
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableAddSizeStocks extends Migration
{

    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('size_stock')->nullable()->after('multiple_sizes');
            $table->renameColumn('stock', 'current_stock');
            $table->integer('total_stock')->default(0)->after('current_stock');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('size_stock');
            $table->dropColumn('total_stock');
            $table->renameColumn('current_stock', 'stock');
        });
    }
}
