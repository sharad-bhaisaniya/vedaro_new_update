<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shiprocket_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unique();
            $table->bigInteger('shipment_id')->nullable();
            $table->string('awb_code')->nullable();
            $table->string('courier_name')->nullable();
            $table->string('destination')->nullable();
            $table->string('origin')->nullable();
            $table->integer('packages')->default(1);
            $table->string('pod')->nullable();
            $table->string('pod_status')->nullable();
            $table->string('status')->nullable();
            $table->string('tracking_url')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shiprocket_orders');
    }
};
