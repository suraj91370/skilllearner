<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting by key with an optional default value.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
                $record = static::where('key', $key)->first();
                if ($record !== null) {
                    return $record->value;
                }

                // Fallback to local json backup if DB record not found
                $json = static::readJsonBackup();
                return $json[$key] ?? $default;
            });
        } catch (\Throwable $e) {
            $json = static::readJsonBackup();
            return $json[$key] ?? session("platform_settings.{$key}", $default);
        }
    }

    /**
     * Set / update a setting value.
     */
    public static function set(string $key, mixed $value): static
    {
        Cache::forget("setting_{$key}");
        Cache::forget('all_platform_settings');

        $valString = is_array($value) ? json_encode($value) : (string) $value;

        // Also update local JSON backup for zero-network resilience
        $json = static::readJsonBackup();
        $json[$key] = $valString;
        static::writeJsonBackup($json);

        try {
            return static::updateOrCreate(
                ['key' => $key],
                ['value' => $valString]
            );
        } catch (\Throwable $e) {
            $inst = new static(['key' => $key, 'value' => $valString]);
            return $inst;
        }
    }

    /**
     * Get all settings as an associative key => value array.
     */
    public static function allSettings(): array
    {
        $defaults = [
            'login_video_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
            'login_video_title' => 'Welcome to SkillLearner! Watch This First',
            'login_video_description' => 'Get started with your courses, explore your affiliate dashboard, and maximize your learning journey.',
            'login_video_enabled' => '1',
            'platform_name' => 'SkillLearner EdTech',
            'tier1_commission' => '70',
            'tier2_commission' => '10',
            'min_payout_amount' => '1000',
        ];

        try {
            $dbSettings = static::pluck('value', 'key')->toArray();
            return array_merge($defaults, static::readJsonBackup(), $dbSettings);
        } catch (\Throwable $e) {
            return array_merge($defaults, static::readJsonBackup(), session('platform_settings', []));
        }
    }

    /**
     * Helper to convert any YouTube, Vimeo, or web video link into a proper embed URL.
     */
    public static function formatEmbedUrl(?string $url): string
    {
        if (empty($url)) {
            return '';
        }

        $url = trim($url);

        // YouTube: https://www.youtube.com/watch?v=VIDEO_ID or youtu.be/VIDEO_ID or shorts/VIDEO_ID
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0&modestbranding=1&playsinline=1";
        }

        // Vimeo: https://vimeo.com/VIDEO_ID
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)/', $url, $matches)) {
            $videoId = $matches[1];
            return "https://player.vimeo.com/video/{$videoId}?autoplay=1";
        }

        return $url;
    }

    /**
     * Read local storage JSON backup.
     */
    protected static function readJsonBackup(): array
    {
        $path = storage_path('app/settings.json');
        if (File::exists($path)) {
            try {
                $decoded = json_decode(File::get($path), true);
                return is_array($decoded) ? $decoded : [];
            } catch (\Throwable $e) {
                return [];
            }
        }
        return [];
    }

    /**
     * Write local storage JSON backup.
     */
    protected static function writeJsonBackup(array $data): void
    {
        $dir = storage_path('app');
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }
        File::put(storage_path('app/settings.json'), json_encode($data, JSON_PRETTY_PRINT));
    }
}
