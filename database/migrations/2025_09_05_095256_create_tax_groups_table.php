<?php

// database/migrations/2025_08_19_000000_create_tax_groups_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tax_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tax_group_tax', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('tax_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_group_tax');
        Schema::dropIfExists('tax_groups');
    }
};
