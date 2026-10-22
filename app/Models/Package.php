<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'price',
        'old_price',
        'badge',
        'featured',
        'description',
        'image',
        'courses_included',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'courses_included' => 'array',
        ];
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
