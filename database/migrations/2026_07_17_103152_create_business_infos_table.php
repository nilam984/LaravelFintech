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
        Schema::create('business_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('business_name')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('pan')->nullable();       
            $table->string('pan_image')->nullable();
            $table->string('gst')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_category')->nullable();
            $table->string('website_url')->nullable();
            $table->string('owner_aadhar')->nullable();       
            $table->string('owner_aadhar_image_front')->nullable(); 
            $table->string('owner_aadhar_image_back')->nullable();  
            $table->string('owner_pan')->nullable();         
            $table->string('owner_pan_image')->nullable();   
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pin_code', 6)->nullable();
            $table->text('full_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_infos');
    }
};
