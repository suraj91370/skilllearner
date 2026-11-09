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
}
