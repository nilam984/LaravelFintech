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
        Schema::create('payout_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('beneficiary_name');
            $table->string('beneficiary_mobile')->nullable();
            $table->string('beneficiary_email')->nullable();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('ifsc_code');             
            $table->string('client_ref_id')->nullable();  
            $table->string('contact_id')->nullable();                  
            $table->string('gateway_transaction_id')->nullable();   
            $table->string('bank_reference')->nullable();           
            $table->string('utr')->nullable();
            $table->string('batch_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
            $table->enum('mode', ['IMPS','NEFT','RTGS','UPI'])->default('IMPS');
            $table->string('purpose')->nullable();
            $table->string('narration')->nullable();
            $table->enum('status', ['initiated','pending','processing','success','failed'])->default('initiated');
            $table->string('status_code')->nullable();
            $table->text('status_response')->nullable();
            $table->boolean('callback_received')->default(false);
            $table->string('gateway_type');
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('failed_status')->nullable();
            $table->string('failed_status_code')->nullable();
            $table->text('failed_message')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_transactions');
    }
};
