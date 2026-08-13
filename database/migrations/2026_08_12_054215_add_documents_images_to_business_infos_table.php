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
        Schema::table('business_infos', function (Blueprint $table) {
            $table->string('inside_image')->nullable()->after('owner_pan_image');
            $table->string('outside_image')->nullable()->after('inside_image');
            $table->string('signed_moa_image')->nullable()->after('outside_image');
            $table->string('signed_aoa_image')->nullable()->after('signed_moa_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_infos', function (Blueprint $table) {
            $table->dropColumn('inside_image');
            $table->dropColumn('outside_image');
            $table->dropColumn('signed_moa_image');
            $table->dropColumn('signed_aoa_image');
        });
    }
};
