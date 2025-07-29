<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('shiprocket_orders', function (Blueprint $table) {
            $table->string('channel_order_id')->nullable()->after('order_id');
            $table->string('size')->nullable()->after('weight');
            $table->string('pincode')->nullable()->after('destination');
        });
    }

    public function down()
    {
        Schema::table('shiprocket_orders', function (Blueprint $table) {
            $table->dropColumn(['channel_order_id', 'size', 'pincode']);
        });
    }
};
