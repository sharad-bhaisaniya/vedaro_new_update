<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdsToLimitedEditionBannersTable extends Migration
{
    public function up(): void
    {
        Schema::table('limited_edition_banners', function (Blueprint $table) {
            $table->text('product_ids')->nullable()->after('image'); // comma-separated IDs or JSON
        });
    }

    public function down(): void
    {
        Schema::table('limited_edition_banners', function (Blueprint $table) {
            $table->dropColumn('product_ids');
        });
    }
}
