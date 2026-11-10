<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'applicable_packages',
        'usage_limit',
        'per_user_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'applicable_packages' => 'array',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'discount_value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
        ];
    }

    /**
     * Check if coupon is currently active and within valid dates.
     */
    public function isValid(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $now = Carbon::now('Asia/Kolkata');

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if the coupon applies to a specific package.
     */
    public function appliesToPackage(string $packageSlug): bool
    {
        $packages = $this->applicable_packages ?? ['all'];

        if (empty($packages) || in_array('all', $packages, true)) {
            return true;
        }

        return in_array(strtolower(trim($packageSlug)), array_map('strtolower', $packages), true);
    }

    /**
     * Calculate discount for a given order amount.
     */
    public function calculateDiscount(float $orderAmount): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($orderAmount * (float) $this->discount_value) / 100;
            if ($this->max_discount_amount && $discount > (float) $this->max_discount_amount) {
                $discount = (float) $this->max_discount_amount;
            }
        } else {
            $discount = (float) $this->discount_value;
        }

        return min($discount, $orderAmount);
    }
}

