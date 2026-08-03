<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_infos', function (Blueprint $table) {

            $table->renameColumn('kyc_verified', 'kyc_status');
        });

        // Convert boolean column into enum status
        DB::statement("
            ALTER TABLE business_infos
            MODIFY COLUMN kyc_status ENUM(
                'pending',
                'verification_approved',
                'verification_rejected',
                'approved',
                'admin_rejected'
            ) NOT NULL DEFAULT 'pending'
        ");

        Schema::table('business_infos', function (Blueprint $table) {

            $table->json('kyc_verification_data')->after('kyc_status')->nullable();

            $table->bigInteger('verification_by')->after('kyc_verification_data')->nullable();
            $table->timestamp('verification_at')->after('verification_by')->nullable();

            $table->bigInteger('admin_verified_by')->after('verification_at')->nullable();
            $table->timestamp('admin_verified_at')->after('admin_verified_by')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('business_infos', function (Blueprint $table) {

            $table->dropColumn([
                'kyc_verification_data',
                'verification_by',
                'verification_at',
                'admin_verified_by',
                'admin_verified_at',
            ]);
        });

        DB::statement("
            ALTER TABLE business_infos
            MODIFY COLUMN kyc_status BOOLEAN NOT NULL DEFAULT 0
        ");

        Schema::table('business_infos', function (Blueprint $table) {

            $table->renameColumn('kyc_status', 'kyc_verified');
        });
    }
};
