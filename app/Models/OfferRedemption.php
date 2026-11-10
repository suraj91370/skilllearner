<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferRedemption extends Model
{
    protected $fillable = [
        'coupon_id',
        'offer_id',
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'package_slug',
        'package_name',
        'code_used',
        'original_amount',
        'discount_amount',
        'final_amount',
    ];

    protected function casts(): array
    {
        return [
            'original_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'final_amount' => 'decimal:2',
        ];
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

