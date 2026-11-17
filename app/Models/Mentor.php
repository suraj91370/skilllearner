<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'photo',
        'bio',
        'expertise',
        'experience',
        'qualification',
        'designation',
        'badge',
        'social_links',
        'assigned_courses',
        'commission_percentage',
        'status',
        'is_featured',
        'kyc_status',
        'pan_number',
        'aadhar_number',
        'bank_name',
        'holder_name',
        'account_number',
        'ifsc_code',
        'upi_id',
        'kyc_document',
        'total_earned',
        'wallet_balance',
    ];

    protected $appends = [
        'photo_url',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'assigned_courses' => 'array',
            'commission_percentage' => 'decimal:2',
            'is_featured' => 'boolean',
            'total_earned' => 'decimal:2',
            'wallet_balance' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(MentorPayout::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if (empty($this->photo)) {
            return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=7c3aed&color=ffffff&bold=true';
        }

        if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }

        return asset($this->photo);
    }
}
