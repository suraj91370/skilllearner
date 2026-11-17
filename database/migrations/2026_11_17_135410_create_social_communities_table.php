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
        Schema::create('social_communities', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->default('other'); // whatsapp, instagram, youtube, facebook, telegram, discord, twitter, linkedin, other
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('url');
            $table->string('button_text')->default('Join Now ➔');
            $table->string('badge')->nullable(); // e.g. OFFICIAL, COMMUNITY, UPDATES
            $table->string('color')->nullable(); // custom hex or preset
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
        Schema::dropIfExists('social_communities');
    }
};
