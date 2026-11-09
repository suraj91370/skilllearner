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
        Schema::table('mentors', function (Blueprint $table) {
            if (! Schema::hasColumn('mentors', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
            if (! Schema::hasColumn('mentors', 'designation')) {
                $table->string('designation')->nullable()->after('qualification');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mentors', function (Blueprint $table) {
            if (Schema::hasColumn('mentors', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            if (Schema::hasColumn('mentors', 'designation')) {
                $table->dropColumn('designation');
            }
        });
    }
};
