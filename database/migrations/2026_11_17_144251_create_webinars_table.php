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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('speaker')->nullable();
            $table->string('speaker_role')->nullable();
            $table->text('meeting_link');
            $table->string('platform')->default('zoom'); // zoom, google_meet, youtube_live, other
            $table->string('poster')->nullable(); // local uploaded poster
            $table->string('poster_url', 500)->nullable(); // external poster URL fallback
            $table->date('webinar_date')->nullable();
            $table->string('webinar_time')->nullable(); // e.g. 8:00 PM IST
            $table->string('badge')->nullable(); // e.g. TODAY LIVE, UPCOMING, SPECIAL
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
        Schema::dropIfExists('webinars');
    }
};
