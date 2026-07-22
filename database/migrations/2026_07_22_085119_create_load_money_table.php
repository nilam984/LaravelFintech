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
        Schema::create('load_money', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->decimal('amount', 13, 2,);
            $table->string('utr');
            $table->string('request_id')->unique();
            $table->enum('mode', ['cash', 'online']);
            $table->string('pay_receipt')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->bigInteger('updated_by');
            $table->string('rejection_remark', 300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('load_money');
    }
};
