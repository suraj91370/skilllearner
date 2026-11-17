<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    protected $fillable = [
        'title',
        'speaker',
        'speaker_role',
        'meeting_link',
        'platform',
        'poster',
        'poster_url',
        'webinar_date',
        'webinar_time',
        'badge',
        'description',
        'download_count',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'sort_order' => 'integer',
        'webinar_date' => 'date',
    ];

    protected $appends = [
        'poster_image',
        'platform_name',
        'formatted_date',
    ];

    /**
     * Get full poster URL
     */
    public function getPosterImageAttribute(): string
    {
        if (! empty($this->poster)) {
            if (file_exists(public_path($this->poster))) {
                return asset($this->poster);
            }
            if (str_starts_with($this->poster, 'http://') || str_starts_with($this->poster, 'https://')) {
                return $this->poster;
            }

            return asset($this->poster);
        }

        if (! empty($this->poster_url)) {
            return $this->poster_url;
        }

        // Default high quality webinar banner
        return 'https://images.unsplash.com/photo-1544531585-9847b68c8c86?w=800&auto=format&fit=crop&q=80';
    }

    /**
     * Human readable platform name
     */
    public function getPlatformNameAttribute(): string
    {
        return match ($this->platform) {
            'zoom' => 'Zoom Meeting',
            'google_meet' => 'Google Meet',
            'youtube_live' => 'YouTube Live',
            default => 'Live Webinar',
        };
    }

    /**
     * Formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        if (! $this->webinar_date) {
            return 'Upcoming Soon';
        }

        return Carbon::parse($this->webinar_date)->format('d M, Y (l)');
    }
}
