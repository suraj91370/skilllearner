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
        Schema::create('affiliate_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_url', 500);
            $table->string('photo', 500)->nullable(); // photo link URL or local path
            $table->string('category', 100)->default('Affiliate Mastery');
            $table->string('badge', 60)->nullable(); // e.g. Step 1, Beginner, Masterclass
            $table->string('duration', 50)->nullable(); // e.g. 15 Mins
            $table->text('description')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_trainings');
    }
};
