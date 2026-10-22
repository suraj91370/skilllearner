<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'package_id',
        'package_name',
        'slug',
        'title',
        'category',
        'badge',
        'instructor',
        'instructor_avatar',
        'banner_title',
        'banner_tag',
        'accent',
        'gradient',
        'lessons',
        'duration',
        'price',
        'old_price',
        'tagline',
        'description',
        'what_you_learn',
        'modules',
        'requirements',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'lessons' => 'integer',
            'what_you_learn' => 'array',
            'modules' => 'array',
            'requirements' => 'array',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')
            ->withPivot('progress_percent', 'completed_at')
            ->withTimestamps();
    }
}
