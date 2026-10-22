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
            $table->string('phone')->nullable()->after('email');
            $table->string('affiliate_id', 50)->nullable()->unique()->after('phone');
            $table->string('sponsor_id', 50)->nullable()->default('SL-ADMIN')->after('affiliate_id');
            $table->string('active_package')->default('Advance Package')->after('sponsor_id');
            $table->decimal('wallet_balance', 10, 2)->default(0.00)->after('active_package');
            $table->decimal('today_earning', 10, 2)->default(0.00)->after('wallet_balance');
            $table->decimal('weekly_earning', 10, 2)->default(0.00)->after('today_earning');
            $table->decimal('total_earning', 10, 2)->default(0.00)->after('weekly_earning');
            $table->string('kyc_status', 50)->default('Pending Verification')->after('total_earning');
            $table->string('avatar')->nullable()->after('kyc_status');
            $table->string('role', 30)->default('affiliate')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'affiliate_id',
                'sponsor_id',
                'active_package',
                'wallet_balance',
                'today_earning',
                'weekly_earning',
                'total_earning',
                'kyc_status',
                'avatar',
                'role',
            ]);
        });
    }
};
