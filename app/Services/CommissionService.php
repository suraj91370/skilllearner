<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommissionService
{
    /**
     * Exact 5 Package commission matrix as requested:
     * 1. Basic: ₹599   -> Active: ₹420,  Passive: ₹50
     * 2. Growth: ₹1199  -> Active: ₹840,  Passive: ₹100
     * 3. Advance: ₹2499 -> Active: ₹1900, Passive: ₹200
     * 4. Premium: ₹4999 -> Active: ₹3800, Passive: ₹400
     * 5. Infinity: ₹7999 -> Active: ₹5500, Passive: ₹500
     */
    public const PACKAGES = [
        'basic' => [
            'id' => 'basic',
            'name' => 'Basic Package',
            'price' => 599,
            'active_income' => 420,
            'passive_income' => 50,
        ],
        'growth' => [
            'id' => 'growth',
            'name' => 'Growth Package',
            'price' => 1199,
            'active_income' => 840,
            'passive_income' => 100,
        ],
        'advance' => [
            'id' => 'advance',
            'name' => 'Advance Package',
            'price' => 2499,
            'active_income' => 1900,
            'passive_income' => 200,
        ],
        'premium' => [
            'id' => 'premium',
            'name' => 'Premium Package',
            'price' => 4999,
            'active_income' => 3800,
            'passive_income' => 400,
        ],
        'infinity' => [
            'id' => 'infinity',
            'name' => 'Infinity Package',
            'price' => 7999,
            'active_income' => 5500,
            'passive_income' => 500,
        ],
    ];

    /**
     * Package tier rankings for upgrade comparison.
     */
    public const PACKAGE_TIERS = [
        'basic' => 1,
        'growth' => 2,
        'advance' => 3,
        'premium' => 4,
        'infinity' => 5,
    ];

    /**
     * Resolve package by slug or name (Dynamically linked to Super Admin Packages & Offers).
     */
    public static function getPackageInfo(string $packageSlugOrName): array
    {
        $key = strtolower(trim($packageSlugOrName));
        $key = str_replace(' package', '', $key);

        $fallback = self::PACKAGES[$key] ?? self::PACKAGES['advance'];

        try {
            $dynPkg = PackageService::getPackageBySlug($key, false);
            if (! empty($dynPkg)) {
                if (empty($dynPkg['active_income']) || (float) $dynPkg['active_income'] <= 0) {
                    $dynPkg['active_income'] = (float) ($fallback['active_income'] ?? 420);
                }
                if (empty($dynPkg['passive_income']) || (float) $dynPkg['passive_income'] <= 0) {
                    $dynPkg['passive_income'] = (float) ($fallback['passive_income'] ?? 50);
                }

                return $dynPkg;
            }
        } catch (\Throwable $e) {
            // Fallback to static constant
        }

        return $fallback;
    }

    /**
     * Get upgrade pricing details between two packages.
     * When upgrading, current package value is deducted from target package price.
     */
    public static function getUpgradeDetails(?string $currentPackageName, string $targetPackageSlugOrName): array
    {
        $targetPkg = self::getPackageInfo($targetPackageSlugOrName);
        $targetTier = self::PACKAGE_TIERS[$targetPkg['id']] ?? 3;

        if (empty($currentPackageName)) {
            return [
                'is_upgrade' => false,
                'is_current' => false,
                'is_lower' => false,
                'current_package' => null,
                'current_price' => 0,
                'target_package' => $targetPkg['name'],
                'target_price' => $targetPkg['price'],
                'discount' => 0,
                'payable_price' => $targetPkg['price'],
            ];
        }

        $currentPkg = self::getPackageInfo($currentPackageName);
        $currentTier = self::PACKAGE_TIERS[$currentPkg['id']] ?? 0;

        if ($targetTier < $currentTier) {
            return [
                'is_upgrade' => false,
                'is_current' => false,
                'is_lower' => true,
                'current_package' => $currentPkg['name'],
                'current_price' => $currentPkg['price'],
                'target_package' => $targetPkg['name'],
                'target_price' => $targetPkg['price'],
                'discount' => 0,
                'payable_price' => 0,
            ];
        }

        if ($targetTier === $currentTier) {
            return [
                'is_upgrade' => false,
                'is_current' => true,
                'is_lower' => false,
                'current_package' => $currentPkg['name'],
                'current_price' => $currentPkg['price'],
                'target_package' => $targetPkg['name'],
                'target_price' => $targetPkg['price'],
                'discount' => 0,
                'payable_price' => 0,
            ];
        }

        // Target Tier > Current Tier: Eligible for Differential Upgrade!
        $discount = $currentPkg['price'];
        $payable = max(0, $targetPkg['price'] - $discount);

        return [
            'is_upgrade' => true,
            'is_current' => false,
            'is_lower' => false,
            'current_package' => $currentPkg['name'],
            'current_price' => $currentPkg['price'],
            'target_package' => $targetPkg['name'],
            'target_price' => $targetPkg['price'],
            'discount' => $discount,
            'payable_price' => $payable,
        ];
    }

    /**
     * Distribute commission across strict 2-tier hierarchy:
     * - Level 1 (Direct Sponsor): Receives Active Income
     * - Level 2 (Direct Sponsor's Sponsor): Receives Passive Income
     * - Level 3+ (Uplines above Level 2): Strictly ZERO commission
     *
     * Initial status is 'Pending' until Super Admin verifies payment.
     *
     * @param  string  $packageSlugOrName  Package bought
     * @param  string  $buyerName  Name of student/buyer
     * @param  string|null  $sponsorAffiliateId  Affiliate ID of direct sponsor
     * @param  User|null  $buyerUser  Buyer model if registered
     * @param  string  $initialStatus  'Pending' (default) or 'Credited'
     * @return array Summary of distributed commissions
     */
    public static function processSale(
        string $packageSlugOrName,
        string $buyerName,
        ?string $sponsorAffiliateId = null,
        ?User $buyerUser = null,
        string $initialStatus = 'Pending'
    ): array {
        $pkg = self::getPackageInfo($packageSlugOrName);
        $results = [
            'package' => $pkg['name'],
            'price' => $pkg['price'],
            'status' => $initialStatus,
            'tier1' => null,
            'tier2' => null,
        ];

        if (empty($sponsorAffiliateId)) {
            $sponsorAffiliateId = $buyerUser?->sponsor_id ?? 'SL-ADMIN';
        }

        // ==========================================
        // LEVEL 1: DIRECT SPONSOR (ACTIVE INCOME)
        // ==========================================
        $tier1User = self::findUserByAffiliateId($sponsorAffiliateId);

        if ($tier1User) {
            $activeAmount = (float) $pkg['active_income'];

            // If already verified/credited upon sale, credit immediately
            if ($initialStatus === 'Credited') {
                self::creditUserEarnings($tier1User, $activeAmount, isPassive: false);
            }

            // Log commission in database
            $comm1 = Commission::create([
                'user_id' => $tier1User->id,
                'buyer_name' => $buyerName,
                'package_name' => $pkg['name'],
                'amount' => $activeAmount,
                'commission_type' => 'Active Income (Tier-1)',
                'status' => $initialStatus,
            ]);

            // Sync session if currently logged in as Tier 1 user
            if ($initialStatus === 'Credited') {
                self::syncCurrentSessionIfMatched($tier1User->id, $activeAmount, isPassive: false, commission: [
                    'name' => $buyerName,
                    'package' => $pkg['name'],
                    'amount' => $activeAmount,
                    'type' => 'Active Income (Tier-1)',
                    'time' => 'Just now',
                    'status' => $initialStatus,
                ]);

                // Dispatch active referral email
                EmailNotificationService::sendActiveReferral($tier1User, $activeAmount, $buyerName, $pkg['name']);
            } else {
                // Add pending entry to session commission log without inflating wallet
                self::appendSessionCommissionOnly($tier1User->id, [
                    'name' => $buyerName,
                    'package' => $pkg['name'],
                    'amount' => $activeAmount,
                    'type' => 'Active Income (Tier-1)',
                    'time' => 'Just now',
                    'status' => 'Pending',
                ]);
            }

            $results['tier1'] = [
                'commission_id' => $comm1->id,
                'user_id' => $tier1User->id,
                'name' => $tier1User->name,
                'amount' => $activeAmount,
                'type' => 'Active Income',
                'status' => $initialStatus,
            ];

            // ==========================================
            // LEVEL 2: SPONSOR'S SPONSOR (PASSIVE INCOME)
            // ==========================================
            $tier2SponsorId = $tier1User->sponsor_id;
            if (! empty($tier2SponsorId) && $tier2SponsorId !== $tier1User->affiliate_id) {
                $tier2User = self::findUserByAffiliateId($tier2SponsorId);

                // Ensure Tier 2 is a distinct user and exists
                if ($tier2User && $tier2User->id !== $tier1User->id) {
                    $passiveAmount = (float) $pkg['passive_income'];

                    // If already verified/credited upon sale, credit immediately
                    if ($initialStatus === 'Credited') {
                        self::creditUserEarnings($tier2User, $passiveAmount, isPassive: true);
                    }

                    // Log commission in database
                    $comm2 = Commission::create([
                        'user_id' => $tier2User->id,
                        'buyer_name' => "{$buyerName} (via {$tier1User->name})",
                        'package_name' => $pkg['name'],
                        'amount' => $passiveAmount,
                        'commission_type' => 'Passive Income (Tier-2)',
                        'status' => $initialStatus,
                    ]);

                    if ($initialStatus === 'Credited') {
                        self::syncCurrentSessionIfMatched($tier2User->id, $passiveAmount, isPassive: true, commission: [
                            'name' => "{$buyerName} (via {$tier1User->name})",
                            'package' => $pkg['name'],
                            'amount' => $passiveAmount,
                            'type' => 'Passive Income (Tier-2)',
                            'time' => 'Just now',
                            'status' => $initialStatus,
                        ]);

                        // Dispatch passive referral email
                        EmailNotificationService::sendPassiveReferral(
                            $tier2User,
                            $passiveAmount,
                            "{$buyerName} (via {$tier1User->name})",
                            $pkg['name']
                        );
                    } else {
                        self::appendSessionCommissionOnly($tier2User->id, [
                            'name' => "{$buyerName} (via {$tier1User->name})",
                            'package' => $pkg['name'],
                            'amount' => $passiveAmount,
                            'type' => 'Passive Income (Tier-2)',
                            'time' => 'Just now',
                            'status' => 'Pending',
                        ]);
                    }

                    $results['tier2'] = [
                        'commission_id' => $comm2->id,
                        'user_id' => $tier2User->id,
                        'name' => $tier2User->name,
                        'amount' => $passiveAmount,
                        'type' => 'Passive Income',
                        'status' => $initialStatus,
                    ];
                }
            }
        }

        // ==========================================
        // LEVEL 3+: STRICTLY NO COMMISSION CREDITED
        // ==========================================
        // Hierarchy ends strictly at Level 2.

        return $results;
    }

    /**
     * Credit a verified / approved commission to the affiliate's wallet.
     */
    public static function creditApprovedCommission(Commission $commission): bool
    {
        if ($commission->status === 'Credited') {
            return false; // Prevent duplicate crediting
        }

        $user = $commission->user;
        if (! $user) {
            return false;
        }

        $isPassive = str_contains(strtolower($commission->commission_type), 'passive');
        $amount = (float) $commission->amount;

        // Auto-heal zero amount from package configuration if it was logged as 0
        if ($amount <= 0 && ! empty($commission->package_name)) {
            $pkgInfo = self::getPackageInfo($commission->package_name);
            $amount = $isPassive ? (float) $pkgInfo['passive_income'] : (float) $pkgInfo['active_income'];
            $commission->amount = $amount;
        }

        // Credit user balance in DB
        self::creditUserEarnings($user, $amount, $isPassive);

        // Update commission record status and healed amount
        $commission->update([
            'status' => 'Credited',
            'amount' => $amount,
        ]);

        // Sync session if currently logged in
        self::syncCurrentSessionIfMatched($user->id, $amount, $isPassive, [
            'name' => $commission->buyer_name,
            'package' => $commission->package_name,
            'amount' => $amount,
            'type' => $commission->commission_type,
            'time' => 'Just now',
            'status' => 'Credited',
        ]);

        // Dispatch branded email notification to affiliate
        if ($isPassive) {
            EmailNotificationService::sendPassiveReferral(
                $user,
                $amount,
                $commission->buyer_name,
                $commission->package_name
            );
        } else {
            EmailNotificationService::sendActiveReferral(
                $user,
                $amount,
                $commission->buyer_name,
                $commission->package_name
            );
        }

        return true;
    }

    /**
     * Reject a pending commission (e.g. failed payment or fraudulent referral).
     */
    public static function rejectCommission(Commission $commission, ?string $reason = null): bool
    {
        $commission->update([
            'status' => 'Rejected',
        ]);

        return true;
    }

    /**
     * Credit earnings and update balances for a user.
     */
    public static function creditUserEarnings(User $user, float $amount, bool $isPassive = false): void
    {
        $user->increment('wallet_balance', $amount);
        $user->increment('total_earning', $amount);

        if ($isPassive) {
            $user->increment('passive_earning', $amount);
        }

        // Recalculate rolling time-window earnings in IST
        self::calculateUserEarnings($user);
    }

    /**
     * Compute and synchronize a user's rolling revenue based on Indian Standard Time (IST / Asia/Kolkata).
     *
     * Today's Revenue:
     * - Counted strictly between 00:00:00 (00:01) and 23:59:59 IST of the current day.
     * - Once midnight passes in IST, Today's Revenue resets to 0.00 until new earnings occur today.
     *
     * 7 Days Revenue:
     * - Rolling 7-day window (subDays(6)->startOfDay() through today->endOfDay() in IST).
     * - On a new day (e.g. next Monday), the day from 8 days ago debits (drops) and today credits.
     *
     * 30 Days Revenue:
     * - Rolling 30-day window (subDays(29)->startOfDay() through today->endOfDay() in IST).
     *
     * Industry Revenue:
     * - Default is 0.00, customizable per-user by Super Admin.
     */
    public static function calculateUserEarnings(User $user): array
    {
        $timezone = 'Asia/Kolkata';
        $nowIst = Carbon::now($timezone);

        // Today: 00:00:00 to 23:59:59 IST
        $todayStart = (clone $nowIst)->startOfDay();
        $todayEnd = (clone $nowIst)->endOfDay();

        // 7 Days Rolling Window: 6 days ago startOfDay through today endOfDay
        $sevenDaysStart = (clone $nowIst)->subDays(6)->startOfDay();

        // 30 Days Rolling Window: 29 days ago startOfDay through today endOfDay
        $thirtyDaysStart = (clone $nowIst)->subDays(29)->startOfDay();

        $creditedComms = $user->commissions()
            ->where('status', 'Credited')
            ->get();

        $today = 0.0;
        $weekly = 0.0;
        $monthly = 0.0;
        $total = 0.0;
        $passive = 0.0;

        foreach ($creditedComms as $c) {
            $amt = (float) $c->amount;
            $total += $amt;

            if (str_contains(strtolower((string) $c->commission_type), 'passive')) {
                $passive += $amt;
            }

            if ($c->created_at) {
                $cDate = Carbon::parse($c->created_at)->timezone($timezone);

                if ($cDate->between($todayStart, $todayEnd)) {
                    $today += $amt;
                }
                if ($cDate->between($sevenDaysStart, $todayEnd)) {
                    $weekly += $amt;
                }
                if ($cDate->between($thirtyDaysStart, $todayEnd)) {
                    $monthly += $amt;
                }
            }
        }

        // If user has no commission records at all, fallback to total_earning / passive_earning from model, but today remains 0.00
        if ($creditedComms->isEmpty()) {
            $total = (float) $user->total_earning;
            $passive = (float) $user->passive_earning;
            $today = 0.0;
            $weekly = 0.0;
            $monthly = 0.0;
        }

        // Keep the database columns synchronized with current rolling values
        $user->update([
            'today_earning' => $today,
            'weekly_earning' => $weekly,
            'monthly_earning' => $monthly,
            'total_earning' => $total,
            'passive_earning' => $passive,
        ]);

        return [
            'today' => $today,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'total' => $total,
            'passive' => $passive,
            'industry_revenue' => (float) ($user->industry_revenue ?? 0.00),
        ];
    }

    /**
     * Compute platform-wide analytics for Super Admin Dashboard.
     */
    public static function getPlatformRevenueStats(): array
    {
        $todayStart = now()->startOfDay();
        $thirtyDaysAgo = now()->subDays(30)->startOfDay();

        // Total commissions by type & status
        $creditedCommissions = Commission::where('status', 'Credited')->get();
        $pendingCommissions = Commission::where('status', 'Pending')->get();

        $totalActiveIncome = (float) $creditedCommissions
            ->filter(fn ($c) => str_contains(strtolower($c->commission_type), 'active') || str_contains(strtolower($c->commission_type), 'direct'))
            ->sum('amount');

        $totalPassiveIncome = (float) $creditedCommissions
            ->filter(fn ($c) => str_contains(strtolower($c->commission_type), 'passive'))
            ->sum('amount');

        // Today & 30 Days user commissions earned
        $todayIncome = (float) $creditedCommissions
            ->filter(fn ($c) => $c->created_at && $c->created_at >= $todayStart)
            ->sum('amount');

        $monthlyIncome = (float) $creditedCommissions
            ->filter(fn ($c) => $c->created_at && $c->created_at >= $thirtyDaysAgo)
            ->sum('amount');

        $pendingAmount = (float) $pendingCommissions->sum('amount');
        $pendingCount = $pendingCommissions->count();

        // Calculate Total Platform Revenue from distinct package sales
        // Every referral sale generates a Tier-1 commission.
        // We look at all Tier-1 commissions (both Credited and Pending) to see total package sales volume
        $allTier1Commissions = Commission::where(function ($q) {
            $q->where('commission_type', 'like', '%Tier-1%')
                ->orWhere('commission_type', 'like', '%Active%')
                ->orWhere('commission_type', 'like', '%Direct%');
        })->get();

        $totalRevenue = 0.0;
        $creditedRevenue = 0.0;
        $todayRevenue = 0.0;
        $monthlyRevenue = 0.0;
        $packageCounts = [
            'Basic Package' => 0,
            'Growth Package' => 0,
            'Advance Package' => 0,
            'Premium Package' => 0,
            'Infinity Package' => 0,
        ];

        foreach ($allTier1Commissions as $t1) {
            $pkgInfo = self::getPackageInfo($t1->package_name);
            $pkgPrice = (float) $pkgInfo['price'];
            $totalRevenue += $pkgPrice;

            if ($t1->status === 'Credited') {
                $creditedRevenue += $pkgPrice;
            }

            if ($t1->created_at && $t1->created_at >= $todayStart) {
                $todayRevenue += $pkgPrice;
            }

            if ($t1->created_at && $t1->created_at >= $thirtyDaysAgo) {
                $monthlyRevenue += $pkgPrice;
            }

            $matchedPkgName = $pkgInfo['name'];
            if (isset($packageCounts[$matchedPkgName])) {
                $packageCounts[$matchedPkgName]++;
            }
        }

        $totalCommissionsPaid = $totalActiveIncome + $totalPassiveIncome;
        $netRetainedProfit = max(0.0, $creditedRevenue - $totalCommissionsPaid);

        return [
            'total_revenue' => $totalRevenue,
            'today_revenue' => $todayRevenue,
            'monthly_revenue' => $monthlyRevenue,
            'today_income' => $todayIncome,
            'monthly_income' => $monthlyIncome,
            'credited_revenue' => $creditedRevenue,
            'total_active_income' => $totalActiveIncome,
            'total_passive_income' => $totalPassiveIncome,
            'total_commissions_paid' => $totalCommissionsPaid,
            'net_retained_profit' => $netRetainedProfit,
            'pending_amount' => $pendingAmount,
            'pending_count' => $pendingCount,
            'total_sales_count' => $allTier1Commissions->count(),
            'package_breakdown' => $packageCounts,
        ];
    }

    /**
     * Find a user by affiliate ID, ID, or fallback.
     */
    public static function findUserByAffiliateId(?string $affiliateId): ?User
    {
        if (empty($affiliateId)) {
            return null;
        }

        $affiliateId = trim($affiliateId);

        // Try exact affiliate ID match
        $user = User::where('affiliate_id', $affiliateId)->first();
        if ($user) {
            return $user;
        }

        // If ID matches SL-1234 or SKL-1234, try numeric ID
        if (preg_match('/(?:SL|SKL)-(\d+)/i', $affiliateId, $m)) {
            $numericId = (int) $m[1];
            $user = User::find($numericId);
            if ($user) {
                return $user;
            }
        }

        // If default SL-ADMIN or SKL-ADMIN, find admin user
        if (in_array(strtoupper($affiliateId), ['SL-ADMIN', 'SKL-ADMIN', 'ADMIN'])) {
            return User::where('role', 'super_admin')->orWhere('role', 'admin')->first()
                ?: User::first();
        }

        return null;
    }

    /**
     * Update active session if it matches the affected user.
     */
    protected static function syncCurrentSessionIfMatched(int $userId, float $amount, bool $isPassive, array $commission): void
    {
        $currentSessionUserId = session('user.id');
        $isAuthMatch = Auth::check() && Auth::id() === $userId;
        $isSessionMatch = $currentSessionUserId && (int) $currentSessionUserId === $userId;

        if ($isAuthMatch || $isSessionMatch) {
            $user = session('user', []);
            $user['wallet_balance'] = ((float) ($user['wallet_balance'] ?? 0)) + $amount;
            $user['today_earning'] = ((float) ($user['today_earning'] ?? 0)) + $amount;
            $user['weekly_earning'] = ((float) ($user['weekly_earning'] ?? 0)) + $amount;
            $user['monthly_earning'] = ((float) ($user['monthly_earning'] ?? 0)) + $amount;
            $user['total_earning'] = ((float) ($user['total_earning'] ?? 0)) + $amount;

            if ($isPassive) {
                $user['passive_earning'] = ((float) ($user['passive_earning'] ?? 0)) + $amount;
            }

            session(['user' => $user]);

            // Prepend new commission entry to session commission log
            $commissions = session('commissions', []);
            array_unshift($commissions, $commission);
            session(['commissions' => $commissions]);
        }
    }

    /**
     * Append to session commission log without modifying wallet balances (for Pending state).
     */
    protected static function appendSessionCommissionOnly(int $userId, array $commission): void
    {
        $currentSessionUserId = session('user.id');
        $isAuthMatch = Auth::check() && Auth::id() === $userId;
        $isSessionMatch = $currentSessionUserId && (int) $currentSessionUserId === $userId;

        if ($isAuthMatch || $isSessionMatch) {
            $commissions = session('commissions', []);
            array_unshift($commissions, $commission);
            session(['commissions' => $commissions]);
        }
    }
}
