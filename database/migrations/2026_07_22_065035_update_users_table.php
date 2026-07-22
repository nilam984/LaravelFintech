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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('payin_wallet', 13, 2)->default(0)->after('status');
            $table->decimal('payout_wallet', 13, 2)->default(0)->after('payin_wallet');
            $table->decimal('main_wallet', 13, 2)->default(0)->after('payout_wallet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'payin_wallet',
                'payout_wallet',
                'main_wallet',
            ]);
        });
    }
};
