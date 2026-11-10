<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'offer_type',
        'discount_type',
        'discount_value',
        'badge_text',
        'banner_message',
        'applicable_packages',
        'bundle_buy_package',
        'bundle_free_package',
        'show_timer',
        'starts_at',
        'ends_at',
        'status',
        'uses_count',
        'total_discount_given',
    ];

    protected function casts(): array
    {
        return [
            'applicable_packages' => 'array',
            'show_timer' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'discount_value' => 'decimal:2',
            'total_discount_given' => 'decimal:2',
        ];
    }

    /**
     * Check if the offer is currently running (active, starts_at <= now, ends_at >= now).
     */
    public function isLive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $now = Carbon::now('Asia/Kolkata');

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $now->gt($this->ends_at)) {
            return false;
        }

        return true;
    }

    /**
     * Check if the offer applies to a specific package slug.
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
     * Calculate discount amount for a given package price.
     */
    public function calculateDiscount(float $originalPrice): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($originalPrice * (float) $this->discount_value) / 100;
        } else {
            $discount = (float) $this->discount_value;
        }

        // Discount cannot exceed the original price
        return min($discount, $originalPrice);
    }
}

