<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setup_cost_orders', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('reseller_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('mobile', 10);
            $table->string('pan_no', 10);
            $table->string('pan_image')->nullable();

            // Selected services
            $table->json('service_ids');

            // Amount
            $table->decimal('total_amount', 12, 2);

            // Order status
            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'cancelled'
            ])->default('pending');

            // Payment gateway information
            $table->string('gateway')->nullable();
            $table->string('gateway_order_id')->nullable();
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_signature')->nullable();

            // Payment timestamps
            $table->timestamp('paid_at')->nullable();

            $table->text('failure_reason')->nullable();

            $table->timestamps();

            $table->index('gateway_order_id');
            $table->index('status');
            $table->index('reseller_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setup_cost_orders');
    }
};
