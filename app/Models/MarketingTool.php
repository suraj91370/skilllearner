<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingTool extends Model
{
    protected $fillable = [
        'title',
        'type',
        'category',
        'file_path',
        'file_url',
        'thumbnail_path',
        'description',
        'download_count',
        'views_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'views_count' => 'integer',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'asset_url',
        'thumb_url',
    ];

    /**
     * Get the full downloadable or streamable asset URL
     */
    public function getAssetUrlAttribute(): ?string
    {
        if (! empty($this->file_path)) {
            if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
                return $this->file_path;
            }

            return asset($this->file_path);
        }

        if (! empty($this->file_url)) {
            return $this->file_url;
        }

        return null;
    }

    /**
     * Get the preview thumbnail URL
     */
    public function getThumbUrlAttribute(): string
    {
        if (! empty($this->thumbnail_path)) {
            if (str_starts_with($this->thumbnail_path, 'http://') || str_starts_with($this->thumbnail_path, 'https://')) {
                return $this->thumbnail_path;
            }

            return asset($this->thumbnail_path);
        }

        if ($this->type === 'photo' && ! empty($this->asset_url)) {
            return $this->asset_url;
        }

        // Default placeholder based on type
        if ($this->type === 'video') {
            return asset('images/video-placeholder.jpg');
        }

        return asset('images/marketing-placeholder.jpg');
    }
}
