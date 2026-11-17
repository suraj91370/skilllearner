<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LiveOffer extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'poster',
        'poster_url',
        'badge',
        'prize',
        'target_criteria',
        'starts_at',
        'ends_at',
        'description',
        'download_count',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'sort_order' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected $appends = [
        'poster_image',
        'is_running',
        'days_remaining',
    ];

    /**
     * Get poster full URL
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

        // High quality placeholder banner
        return 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&auto=format&fit=crop&q=80';
    }

    /**
     * Check if offer is currently running
     */
    public function getIsRunningAttribute(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $now = Carbon::now();
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $now->gt($this->ends_at)) {
            return false;
        }

        return true;
    }

    /**
     * Calculate remaining days
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (! $this->ends_at) {
            return null;
        }

        $now = Carbon::now();
        if ($now->gt($this->ends_at)) {
            return 0;
        }

        return (int) $now->diffInDays($this->ends_at, false) + 1;
    }
}
