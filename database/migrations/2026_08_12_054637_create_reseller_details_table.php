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
        Schema::create('reseller_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reseller_id');
            $table->string('aadhar_no', 20);
            $table->string('aadhar_front_image', 300);
            $table->string('aadhar_back_image', 300);
            $table->string('pan_no', 20);
            $table->string('pan_image', 300);
            $table->bigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_details');
    }
};
