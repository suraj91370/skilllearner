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
        Schema::create('live_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('poster')->nullable(); // local uploaded path
            $table->string('poster_url', 500)->nullable(); // external poster URL fallback
            $table->string('badge')->nullable(); // e.g. GOA TRIP, CASH BONUS, LEADERBOARD
            $table->string('prize')->nullable(); // e.g. Free Goa Tour, ₹10,000 Cash
            $table->string('target_criteria')->nullable(); // e.g. 50 Sales in November
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_offers');
    }
};
