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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 191)->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        // Insert default initial settings
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            [
                'key' => 'login_video_url',
                'value' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'login_video_title',
                'value' => 'Welcome to SkillLearner! Watch This First',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'login_video_description',
                'value' => 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'login_video_enabled',
                'value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'platform_name',
                'value' => 'SkillLearner EdTech',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tier1_commission',
                'value' => '70',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tier2_commission',
                'value' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'min_payout_amount',
                'value' => '1000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
