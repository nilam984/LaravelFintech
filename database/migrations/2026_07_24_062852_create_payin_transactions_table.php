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
        Schema::create('payin_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('payer_name');
            $table->string('payer_mobile');
            $table->string('payer_email');
            $table->string('user_order_id')->unique();   
            $table->string('payment_reference_id')->unique();     
            $table->string('gateway_transaction_id')->nullable();   
            $table->string('utr')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
           $table->enum('status', ['initiated','pending','processing','success','failed','expired'])->default('initiated');
            $table->boolean('callback_received')->default(false);
            $table->boolean('is_auto_settlement')->default(false);
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->json('callback_payload')->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payin_transactions');
    }
};
