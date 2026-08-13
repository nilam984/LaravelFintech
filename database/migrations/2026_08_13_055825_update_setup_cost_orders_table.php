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
        Schema::table('setup_cost_orders', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->after('service_ids')->default(0.00);
            $table->decimal('gst_amount', 12, 2)->after('amount')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setup_cost_orders', function (Blueprint $table) {
            $table->dropColumn(['amount', 'gst_amount']);
        });
    }
};
