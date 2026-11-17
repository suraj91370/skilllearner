<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateTraining extends Model
{
    protected $fillable = [
        'title',
        'youtube_url',
        'photo',
        'category',
        'badge',
        'duration',
        'description',
        'views_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'embed_url',
        'photo_url',
        'youtube_id',
    ];

    /**
     * Extract 11-character YouTube video ID
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = trim((string) $this->youtube_url);
        if (empty($url)) {
            return null;
        }

        // Standard watch or shorts or youtu.be regex
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?|shorts)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return $match[1];
        }

        // If URL is just an 11-character video ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }

    /**
     * Get embeddable YouTube URL for iframe
     */
    public function getEmbedUrlAttribute(): string
    {
        $id = $this->youtube_id;
        if (! empty($id)) {
            return "https://www.youtube-nocookie.com/embed/{$id}?rel=0&enablejsapi=1";
        }

        return $this->youtube_url;
    }

    /**
     * Get photo or thumbnail URL (custom photo or auto YouTube HQ thumbnail)
     */
    public function getPhotoUrlAttribute(): string
    {
        if (! empty($this->photo)) {
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
                return $this->photo;
            }

            return asset($this->photo);
        }

        $id = $this->youtube_id;
        if (! empty($id)) {
            return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
        }

        return 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80';
    }
}
