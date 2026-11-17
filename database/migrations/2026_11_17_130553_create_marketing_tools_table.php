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
        Schema::create('marketing_tools', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type', 30)->default('photo'); // 'photo' or 'video'
            $table->string('category', 100)->default('General'); // 'Shorts & Reels', 'Posters & Flyers', 'WhatsApp Stories', 'Banners'
            $table->string('file_path', 500)->nullable();
            $table->string('file_url', 500)->nullable();
            $table->string('thumbnail_path', 500)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('download_count')->default(0);
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
        Schema::dropIfExists('marketing_tools');
    }
};
