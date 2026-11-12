<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'thumbnail',
        'excerpt',
        'content',
        'author_name',
        'is_published',
        'is_pinned',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
            'views_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title).'-'.Str::random(5);
            }
            if ($post->is_published && empty($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('is_pinned')->latest('published_at');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }
}
