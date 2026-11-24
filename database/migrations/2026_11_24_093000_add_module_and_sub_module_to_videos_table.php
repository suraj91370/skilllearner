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
        Schema::table('videos', function (Blueprint $table) {
            if (! Schema::hasColumn('videos', 'module_name')) {
                $table->string('module_name')->nullable()->after('badge')->index();
            }
            if (! Schema::hasColumn('videos', 'sub_module_name')) {
                $table->string('sub_module_name')->nullable()->after('module_name')->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            if (Schema::hasColumn('videos', 'sub_module_name')) {
                $table->dropColumn('sub_module_name');
            }
            if (Schema::hasColumn('videos', 'module_name')) {
                $table->dropColumn('module_name');
            }
        });
    }
};
