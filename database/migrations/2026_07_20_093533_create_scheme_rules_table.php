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
        Schema::create('scheme_rules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id');
            $table->bigInteger('product_id');
            $table->enum('fee_type', ['Fixed', 'Percent']);
            $table->decimal('start_value', 13, 2)->default(0);
            $table->decimal('end_value', 13, 2)->default(0);
            $table->decimal('fee', 13, 2)->default(0);
            $table->decimal('min_fee', 13, 2)->default(0);
            $table->decimal('max_fee', 13, 2)->default(0);
            $table->boolean('status')->default(1);
            $table->bigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheme_rules');
    }
};
