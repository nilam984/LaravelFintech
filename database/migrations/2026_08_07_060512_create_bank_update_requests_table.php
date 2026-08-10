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
        Schema::create('bank_update_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('request_remark', 300);
            $table->string('reject_remark', 300)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'updated'])->default('pending');
            $table->bigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_update_requests');
    }
};
