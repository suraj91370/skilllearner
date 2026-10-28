<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'thumbnail_url',
        'duration',
        'category',
        'badge',
        'is_visible',
        'views_count',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'views_count' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include visible videos for users.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Get embeddable URL for YouTube, Vimeo, or standard video.
     */
    public function getEmbedUrlAttribute(): string
    {
        $url = $this->video_url;

        // YouTube Watch URL or Short URL
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1].'?autoplay=1&rel=0';
        }

        // Vimeo URL
        if (preg_match('/vimeo\.com\/([0-9]+)/i', $url, $matches)) {
            return 'https://player.vimeo.com/video/'.$matches[1].'?autoplay=1';
        }

        return $url;
    }

    /**
     * Check if the video is an external iframe embed (YouTube/Vimeo).
     */
    public function getIsIframeAttribute(): bool
    {
        return str_contains($this->video_url, 'youtube.com') ||
               str_contains($this->video_url, 'youtu.be') ||
               str_contains($this->video_url, 'vimeo.com');
    }
}
