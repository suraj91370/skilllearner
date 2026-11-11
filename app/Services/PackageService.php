<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Offer;
use App\Models\OfferRedemption;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PackageService
{
    /**
     * Default baseline 5 Packages with theme branding and courses.
     */
    public const DEFAULT_PACKAGES = [
        'basic' => [
            'id' => 'basic',
            'slug' => 'basic',
            'name' => 'Basic Package',
            'price' => 599,
            'old_price' => 1199,
            'active_income' => 420,
            'passive_income' => 50,
            'image' => 'images/packages/basic.png',
            'color' => '#A855F7',
            'border_color' => 'rgba(168, 85, 247, 0.45)',
            'bg_gradient' => 'linear-gradient(180deg, #1b0c33 0%, #0d0519 100%)',
            'badge' => '',
            'featured' => false,
            'access_badge' => 'Get Access of 3+ Courses',
            'total_courses_count' => 3,
            'previous_access' => null,
            'desc' => 'Foundational digital skillset covering Affiliate Marketing basics, spoken English fluency, and high-impact communication.',
            'courses_included' => ['What Is Affiliate Marketing', 'Spoken English', 'Communication Skill'],
        ],
        'growth' => [
            'id' => 'growth',
            'slug' => 'growth',
            'name' => 'Growth Package',
            'price' => 1199,
            'old_price' => 2499,
            'active_income' => 840,
            'passive_income' => 100,
            'image' => 'images/packages/growth.png',
            'color' => '#10B981',
            'border_color' => 'rgba(16, 185, 129, 0.45)',
            'bg_gradient' => 'linear-gradient(180deg, #063124 0%, #021711 100%)',
            'badge' => '',
            'featured' => false,
            'access_badge' => 'Get Access of 6+ Courses',
            'total_courses_count' => 6,
            'previous_access' => '+ Full Access of Basic Package',
            'desc' => 'Accelerate your creative monetization with Canva graphic design, viral reel workflows, and VN mobile video editing.',
            'courses_included' => ['Canva Graphic Designing', 'Reel Mastery by Canva', 'VN Editing Course'],
        ],
        'advance' => [
            'id' => 'advance',
            'slug' => 'advance',
            'name' => 'Advance Package',
            'price' => 2499,
            'old_price' => 4999,
            'active_income' => 1900,
            'passive_income' => 200,
            'image' => 'images/packages/advance.png',
            'color' => '#0284C7',
            'border_color' => 'rgba(2, 132, 199, 0.45)',
            'bg_gradient' => 'linear-gradient(180deg, #07263e 0%, #021320 100%)',
            'badge' => 'MOST POPULAR',
            'featured' => true,
            'access_badge' => 'Get Access of 9+ Courses',
            'total_courses_count' => 9,
            'previous_access' => '+ Full Access of Basic & Growth Packages',
            'desc' => 'High-converting mastery bundle with Email Marketing automation, Sales Closing mastery, and Video Marketing frameworks.',
            'courses_included' => ['E-mail Marketing', 'Sales Mastery', 'Video Marketing'],
        ],
        'premium' => [
            'id' => 'premium',
            'slug' => 'premium',
            'name' => 'Premium Package',
            'price' => 4999,
            'old_price' => 9999,
            'active_income' => 3800,
            'passive_income' => 400,
            'image' => 'images/packages/premium.png',
            'color' => '#F59E0B',
            'border_color' => 'rgba(245, 158, 11, 0.45)',
            'bg_gradient' => 'linear-gradient(180deg, #331c02 0%, #150a00 100%)',
            'badge' => 'BEST VALUE',
            'featured' => false,
            'access_badge' => 'Get Access of 12+ Courses',
            'total_courses_count' => 12,
            'previous_access' => '+ Full Access of Basic, Growth & Advance Packages',
            'desc' => 'High-ticket authority skills including full YouTube channel monetization, Meta Facebook advertising, and professional web design.',
            'courses_included' => ['YouTube Mastery', 'Facebook Ads', 'Web Designing'],
        ],
        'infinity' => [
            'id' => 'infinity',
            'slug' => 'infinity',
            'name' => 'Infinity Package',
            'price' => 7999,
            'old_price' => 15999,
            'active_income' => 5500,
            'passive_income' => 500,
            'image' => 'images/packages/infinity.png',
            'color' => '#EF4444',
            'border_color' => 'rgba(239, 68, 68, 0.45)',
            'bg_gradient' => 'linear-gradient(180deg, #330606 0%, #160202 100%)',
            'badge' => 'VIP ALL ACCESS',
            'featured' => false,
            'access_badge' => 'Get Access of 15+ Courses',
            'total_courses_count' => 15,
            'previous_access' => '+ Full Access of All Previous Packages (Complete Access)',
            'desc' => 'VIP flagship bundle mastering 0 to Hero AI Content Creation, Artificial Intelligence tools, and Stock Market wealth generation.',
            'courses_included' => ['0 to Hero AI Content Creation', 'Artificial Intelligence', 'Stock Market Course'],
        ],
    ];

    /**
     * Get all 5 packages with dynamic pricing, commission shares, and active offer discounts.
     */
    public static function getAllPackages(bool $includeOffers = true): array
    {
        $packagesMap = static::loadPackagesConfig();
        $activeOffer = $includeOffers ? static::getActiveFlashSale() : null;

        $results = [];
        foreach (self::DEFAULT_PACKAGES as $slug => $defaults) {
            $current = $packagesMap[$slug] ?? $defaults;
            $merged = array_merge($defaults, $current);

            // Ensure numeric values are floats/ints with robust default fallback
            $merged['price'] = (float) (! empty($merged['price']) && (float) $merged['price'] > 0 ? $merged['price'] : $defaults['price']);
            $merged['old_price'] = (float) (! empty($merged['old_price']) ? $merged['old_price'] : $defaults['old_price']);
            $merged['active_income'] = (float) (! empty($merged['active_income']) && (float) $merged['active_income'] > 0 ? $merged['active_income'] : $defaults['active_income']);
            $merged['passive_income'] = (float) (! empty($merged['passive_income']) && (float) $merged['passive_income'] > 0 ? $merged['passive_income'] : $defaults['passive_income']);

            // Attach active promotional discount if an offer applies to this package
            if ($activeOffer && $activeOffer->appliesToPackage($slug)) {
                $discount = $activeOffer->calculateDiscount($merged['price']);
                $merged['promo_discount'] = $discount;
                $merged['promo_price'] = max(0, $merged['price'] - $discount);
                $merged['promo_badge'] = $activeOffer->badge_text ?: '⚡ SPECIAL OFFER';
                $merged['promo_offer_title'] = $activeOffer->title;
                $merged['has_active_offer'] = true;
            } else {
                $merged['has_active_offer'] = false;
                $merged['promo_price'] = $merged['price'];
                $merged['promo_discount'] = 0;
            }

            $results[] = $merged;
        }

        return $results;
    }

    /**
     * Get packages keyed by slug.
     */
    public static function getAllPackagesKeyed(bool $includeOffers = true): array
    {
        $list = static::getAllPackages($includeOffers);
        $keyed = [];
        foreach ($list as $p) {
            $keyed[$p['id']] = $p;
        }

        return $keyed;
    }

    /**
     * Get single package info by slug or name.
     */
    public static function getPackageBySlug(string $slugOrName, bool $includeOffers = true): array
    {
        $clean = strtolower(trim($slugOrName));
        $clean = str_replace(' package', '', $clean);

        $packages = static::getAllPackagesKeyed($includeOffers);

        return $packages[$clean] ?? $packages['advance'] ?? reset($packages);
    }

    /**
     * Update package pricing, commissions, badge, or description.
     */
    public static function updatePackage(string $slug, array $data): bool
    {
        $slug = strtolower(trim($slug));
        if (! isset(self::DEFAULT_PACKAGES[$slug])) {
            return false;
        }

        $config = static::loadPackagesConfig();
        $existing = $config[$slug] ?? self::DEFAULT_PACKAGES[$slug];

        $updated = array_merge($existing, [
            'id' => $slug,
            'slug' => $slug,
            'name' => $data['name'] ?? $existing['name'],
            'price' => isset($data['price']) ? (float) $data['price'] : (float) $existing['price'],
            'old_price' => isset($data['old_price']) ? (float) $data['old_price'] : (float) $existing['old_price'],
            'active_income' => isset($data['active_income']) ? (float) $data['active_income'] : (float) ($existing['active_income'] ?? 0),
            'passive_income' => isset($data['passive_income']) ? (float) $data['passive_income'] : (float) ($existing['passive_income'] ?? 0),
            'badge' => $data['badge'] ?? ($existing['badge'] ?? ''),
            'desc' => $data['desc'] ?? ($existing['desc'] ?? ''),
        ]);

        $config[$slug] = $updated;
        static::savePackagesConfig($config);

        // Also update Database packages table if table exists
        try {
            if (Schema::hasTable('packages')) {
                Package::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $updated['name'],
                        'price' => $updated['price'],
                        'old_price' => $updated['old_price'],
                        'active_income' => $updated['active_income'],
                        'passive_income' => $updated['passive_income'],
                        'badge' => $updated['badge'],
                        'description' => $updated['desc'],
                    ]
                );
            }
        } catch (\Throwable $e) {
            // Gracefully handled; JSON backup already persisted
        }

        Cache::forget('packages_all_config');

        return true;
    }

    /**
     * Load packages configuration with DB + JSON + Default hierarchy.
     */
    protected static function loadPackagesConfig(): array
    {
        return Cache::remember('packages_all_config', 300, function () {
            $config = [];

            // 1. Try reading from Database if table exists
            try {
                if (Schema::hasTable('packages')) {
                    $dbPackages = Package::all();
                    foreach ($dbPackages as $dbPkg) {
                        $s = strtolower($dbPkg->slug);
                        if (isset(self::DEFAULT_PACKAGES[$s])) {
                            $defaultActive = (float) self::DEFAULT_PACKAGES[$s]['active_income'];
                            $defaultPassive = (float) self::DEFAULT_PACKAGES[$s]['passive_income'];

                            $activeInc = ! empty($dbPkg->active_income) && (float) $dbPkg->active_income > 0
                                ? (float) $dbPkg->active_income
                                : $defaultActive;
                            $passiveInc = ! empty($dbPkg->passive_income) && (float) $dbPkg->passive_income > 0
                                ? (float) $dbPkg->passive_income
                                : $defaultPassive;

                            // Self-heal database row if active_income is missing or zero
                            if (empty($dbPkg->active_income) || (float) $dbPkg->active_income <= 0) {
                                try {
                                    $dbPkg->update([
                                        'active_income' => $defaultActive,
                                        'passive_income' => $defaultPassive,
                                    ]);
                                } catch (\Throwable $e) {
                                    // Ignore if read-only
                                }
                            }

                            $config[$s] = [
                                'price' => (float) ($dbPkg->price > 0 ? $dbPkg->price : self::DEFAULT_PACKAGES[$s]['price']),
                                'old_price' => $dbPkg->old_price ? (float) $dbPkg->old_price : null,
                                'active_income' => $activeInc,
                                'passive_income' => $passiveInc,
                                'badge' => $dbPkg->badge,
                                'name' => $dbPkg->name ?: self::DEFAULT_PACKAGES[$s]['name'],
                                'desc' => $dbPkg->description,
                            ];
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Table might not exist yet; proceed to JSON
            }

            // 2. Fallback / Merge with JSON backup
            $jsonFile = storage_path('app/packages_config.json');
            if (File::exists($jsonFile)) {
                try {
                    $json = json_decode(File::get($jsonFile), true);
                    if (is_array($json)) {
                        foreach ($json as $k => $val) {
                            $config[$k] = array_merge($config[$k] ?? [], $val);
                        }
                    }
                } catch (\Throwable $e) {
                    // Ignore JSON read errors
                }
            }

            return $config;
        });
    }

    /**
     * Save packages configuration to JSON backup file.
     */
    protected static function savePackagesConfig(array $config): void
    {
        try {
            $jsonFile = storage_path('app/packages_config.json');
            File::ensureDirectoryExists(dirname($jsonFile));
            File::put($jsonFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            // Ignore file write exceptions
        }
    }

    /**
     * Get the currently active Flash Sale or Festival Offer with timer.
     */
    public static function getActiveFlashSale(): ?Offer
    {
        try {
            if (Schema::hasTable('offers')) {
                $now = Carbon::now('Asia/Kolkata');

                return Offer::where('status', 'active')
                    ->where(function ($q) use ($now) {
                        $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
                    })
                    ->latest()
                    ->first();
            }
        } catch (\Throwable $e) {
            // If DB table not ready, check JSON backup
            return static::getJsonActiveOffer();
        }

        return static::getJsonActiveOffer();
    }

    /**
     * Read active offer from JSON backup if DB is unavailable.
     */
    protected static function getJsonActiveOffer(): ?Offer
    {
        $file = storage_path('app/offers.json');
        if (! File::exists($file)) {
            return null;
        }

        try {
            $offers = json_decode(File::get($file), true);
            if (! is_array($offers)) {
                return null;
            }

            $now = Carbon::now('Asia/Kolkata');
            foreach ($offers as $data) {
                if (($data['status'] ?? '') === 'active') {
                    $starts = ! empty($data['starts_at']) ? Carbon::parse($data['starts_at']) : null;
                    $ends = ! empty($data['ends_at']) ? Carbon::parse($data['ends_at']) : null;

                    if ($starts && $now->lt($starts)) {
                        continue;
                    }
                    if ($ends && $now->gt($ends)) {
                        continue;
                    }

                    $offer = new Offer($data);
                    $offer->id = $data['id'] ?? 1;

                    return $offer;
                }
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        return null;
    }

    /**
     * Validate and apply a coupon code to a package.
     */
    public static function validateCoupon(string $code, string $packageSlug, ?float $amount = null, ?string $userIdentifier = null): array
    {
        $code = strtoupper(trim($code));
        if (empty($code)) {
            return ['valid' => false, 'message' => 'Please enter a coupon code.'];
        }

        $package = static::getPackageBySlug($packageSlug);
        $basePrice = $amount !== null ? $amount : $package['price'];

        // Find coupon in DB or JSON
        $coupon = null;
        try {
            if (Schema::hasTable('coupons')) {
                $coupon = Coupon::where('code', $code)->first();
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        if (! $coupon) {
            $coupon = static::getJsonCouponByCode($code);
        }

        if (! $coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code.'];
        }

        if (! $coupon->isValid()) {
            return ['valid' => false, 'message' => 'This coupon is expired or has reached its maximum usage limit.'];
        }

        if (! $coupon->appliesToPackage($packageSlug)) {
            return ['valid' => false, 'message' => "This coupon is not applicable to {$package['name']}."];
        }

        if ($coupon->min_order_amount > 0 && $basePrice < (float) $coupon->min_order_amount) {
            return ['valid' => false, 'message' => 'Minimum order amount for this coupon is ₹'.number_format($coupon->min_order_amount).'.'];
        }

        // Check per-user limit if user identifier provided
        if ($userIdentifier && Schema::hasTable('offer_redemptions')) {
            $userUses = OfferRedemption::where('code_used', $code)
                ->where(function ($q) use ($userIdentifier) {
                    $q->where('user_email', $userIdentifier)
                        ->orWhere('user_phone', $userIdentifier);
                })
                ->count();

            if ($userUses >= (int) $coupon->per_user_limit) {
                return ['valid' => false, 'message' => 'You have already reached the maximum usage limit for this coupon code.'];
            }
        }

        $discount = $coupon->calculateDiscount($basePrice);
        $finalPrice = max(0, $basePrice - $discount);

        return [
            'valid' => true,
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => (float) $coupon->discount_value,
            'discount_amount' => $discount,
            'original_price' => $basePrice,
            'final_price' => $finalPrice,
            'message' => "Coupon '{$coupon->code}' applied successfully! You saved ₹".number_format($discount).'.',
        ];
    }

    /**
     * Find coupon in JSON backup.
     */
    protected static function getJsonCouponByCode(string $code): ?Coupon
    {
        $file = storage_path('app/coupons.json');
        if (! File::exists($file)) {
            return null;
        }

        try {
            $coupons = json_decode(File::get($file), true);
            if (is_array($coupons)) {
                foreach ($coupons as $c) {
                    if (strtoupper($c['code'] ?? '') === strtoupper($code)) {
                        $model = new Coupon($c);
                        $model->id = $c['id'] ?? 1;

                        return $model;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        return null;
    }

    /**
     * Record an offer/coupon redemption audit log and increment counts.
     */
    public static function recordRedemption(array $data): void
    {
        try {
            if (Schema::hasTable('offer_redemptions')) {
                OfferRedemption::create([
                    'coupon_id' => $data['coupon_id'] ?? null,
                    'offer_id' => $data['offer_id'] ?? null,
                    'user_id' => $data['user_id'] ?? null,
                    'user_name' => $data['user_name'] ?? null,
                    'user_email' => $data['user_email'] ?? null,
                    'user_phone' => $data['user_phone'] ?? null,
                    'package_slug' => $data['package_slug'] ?? 'advance',
                    'package_name' => $data['package_name'] ?? 'Advance Package',
                    'code_used' => $data['code_used'] ?? null,
                    'original_amount' => $data['original_amount'] ?? 0,
                    'discount_amount' => $data['discount_amount'] ?? 0,
                    'final_amount' => $data['final_amount'] ?? 0,
                ]);
            }

            // Increment coupon usage count
            if (! empty($data['coupon_id']) && Schema::hasTable('coupons')) {
                Coupon::where('id', $data['coupon_id'])->increment('used_count');
            } elseif (! empty($data['code_used']) && Schema::hasTable('coupons')) {
                Coupon::where('code', strtoupper($data['code_used']))->increment('used_count');
            }

            // Increment offer usage count and total discount
            if (! empty($data['offer_id']) && Schema::hasTable('offers')) {
                $offer = Offer::find($data['offer_id']);
                if ($offer) {
                    $offer->increment('uses_count');
                    $offer->increment('total_discount_given', (float) ($data['discount_amount'] ?? 0));
                }
            }
        } catch (\Throwable $e) {
            // Silently handle
        }
    }
}
