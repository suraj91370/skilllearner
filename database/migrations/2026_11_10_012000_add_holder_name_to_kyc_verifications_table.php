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
        Schema::table('kyc_verifications', function (Blueprint $table) {
            if (! Schema::hasColumn('kyc_verifications', 'holder_name')) {
                $table->string('holder_name')->nullable()->after('bank_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('kyc_verifications', 'holder_name')) {
                $table->dropColumn('holder_name');
            }
        });
    }
};

