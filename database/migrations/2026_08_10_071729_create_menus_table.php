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
        Schema::create('menus', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('parent_id')->nullable();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('route')->nullable();

            $table->string('icon')->nullable();

            //  default      = Everyone can see
            //  admin        = Admin users
            //  user         = Normal users
            //  reseller     = Reseller users
            //  verification = Verification users
            // 
            //  SET allows multiple roles:
            // 
            //  admin,verification
            //  admin,reseller
            //  admin,user,verification

            $table->set('visible_for', ['default', 'admin', 'user', 'reseller', 'verification',])->default('default');

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index('parent_id');
            $table->index(['parent_id', 'sort_order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
