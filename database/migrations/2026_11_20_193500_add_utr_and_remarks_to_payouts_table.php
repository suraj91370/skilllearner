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
        Schema::table('payouts', function (Blueprint $table) {
            if (! Schema::hasColumn('payouts', 'utr_number')) {
                $table->string('utr_number', 100)->nullable()->after('payment_method');
            }
            if (! Schema::hasColumn('payouts', 'remarks')) {
                $table->text('remarks')->nullable()->after('utr_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payouts', function (Blueprint $table) {
            if (Schema::hasColumn('payouts', 'utr_number')) {
                $table->dropColumn('utr_number');
            }
            if (Schema::hasColumn('payouts', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });
    }
};
