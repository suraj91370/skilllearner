<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    /**
     * Display the Active Referrals page (Direct Referrals / Tier-1).
     * Jis ko user direct refer karta hai wo yahan dikhenge.
     */
    public function activeReferrals(Request $request)
    {
        PortalDataService::ensureUserSession();

        $user = Auth::user();
        $affiliateId = $user ? $user->affiliate_id : session('user.affiliate_id', 'SL-8821');

        // Query direct referrals from users table
        $directReferralsQuery = User::where(function ($q) use ($affiliateId, $user) {
            $q->where('sponsor_id', $affiliateId);
            if ($user && $user->email) {
                $q->orWhere('sponsor_id', $user->email);
            }
        })->latest();

        $search = trim((string) $request->query('search', ''));
        if (! empty($search)) {
            $directReferralsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('affiliate_id', 'like', "%{$search}%")
                    ->orWhere('active_package', 'like', "%{$search}%");
            });
        }

        $referrals = $directReferralsQuery->get();

        // Calculate commissions earned from direct referrals
        $activeCommissions = 0.0;
        if ($user) {
            $activeCommissions = (float) Commission::where('user_id', $user->id)
                ->where(function ($q) {
                    $q->where('commission_type', 'like', '%Active%')
                        ->orWhere('commission_type', 'like', '%Tier-1%')
                        ->orWhere('commission_type', 'like', '%Direct%');
                })
                ->where('status', 'Credited')
                ->sum('amount');
        }

        if ($activeCommissions <= 0 && $user) {
            $activeCommissions = (float) max(0, $user->total_earning - ($user->passive_earning ?? 0));
        }

        // Fallback for demo display if empty so student/affiliate sees realistic mockup
        if ($referrals->isEmpty() && empty($search)) {
            $mockReferrals = [
                [
                    'id' => 101,
                    'name' => 'Rahul Sharma',
                    'email' => 'rahul.sharma@gmail.com',
                    'phone' => '+91 98234 56781',
                    'affiliate_id' => 'SKL-9809',
                    'active_package' => 'Infinity Package',
                    'commission' => 5500,
                    'joined_date' => '04-11-2026',
                    'status' => 'Active',
                ],
                [
                    'id' => 102,
                    'name' => 'Priya Patel',
                    'email' => 'priya.patel@gmail.com',
                    'phone' => '+91 97123 45672',
                    'affiliate_id' => 'SKL-5293',
                    'active_package' => 'Advance Package',
                    'commission' => 1900,
                    'joined_date' => '03-11-2026',
                    'status' => 'Active',
                ],
                [
                    'id' => 103,
                    'name' => 'Aman Verma',
                    'email' => 'aman.verma@gmail.com',
                    'phone' => '+91 98987 65433',
                    'affiliate_id' => 'SKL-9768',
                    'active_package' => 'Growth Package',
                    'commission' => 840,
                    'joined_date' => '02-11-2026',
                    'status' => 'Active',
                ],
                [
                    'id' => 104,
                    'name' => 'Sneha Gupta',
                    'email' => 'sneha.gupta@gmail.com',
                    'phone' => '+91 99876 54324',
                    'affiliate_id' => 'SKL-4013',
                    'active_package' => 'Basic Package',
                    'commission' => 420,
                    'joined_date' => '01-11-2026',
                    'status' => 'Active',
                ],
            ];
            $displayList = collect($mockReferrals);
            $totalCount = 4;
            if ($activeCommissions <= 0) {
                $activeCommissions = 8660.0;
            }
        } else {
            $displayList = $referrals->map(function ($ref) use ($user) {
                $comm = null;
                if ($user) {
                    $comm = Commission::where('user_id', $user->id)
                        ->where('buyer_name', 'like', "%{$ref->name}%")
                        ->where('status', 'Credited')
                        ->first();
                }
                $amount = $comm ? (float) $comm->amount : self::estimateActiveCommission($ref->active_package);

                return [
                    'id' => $ref->id,
                    'name' => $ref->name,
                    'email' => $ref->email,
                    'phone' => $ref->phone ?? 'N/A',
                    'affiliate_id' => $ref->affiliate_id,
                    'active_package' => $ref->active_package ?: 'Basic Package',
                    'commission' => $amount,
                    'joined_date' => $ref->created_at ? $ref->created_at->format('d-m-Y') : date('d-m-Y'),
                    'status' => 'Active',
                ];
            });
            $totalCount = $referrals->count();
        }

        return view('portal.active-referrals', [
            'referrals' => $displayList,
            'totalCount' => $totalCount,
            'totalActiveCommissions' => $activeCommissions,
            'affiliateId' => $affiliateId,
            'active' => 'active-referrals',
            'search' => $search,
        ]);
    }

    /**
     * Display the Passive Referrals page (Tier-2 / Indirect Referrals).
     * Jo direct team members kisi aur ko refer karenge wo yahan dikhenge.
     */
    public function passiveReferrals(Request $request)
    {
        PortalDataService::ensureUserSession();

        $user = Auth::user();
        $affiliateId = $user ? $user->affiliate_id : session('user.affiliate_id', 'SL-8821');

        // 1. Get all affiliate IDs of direct team members
        $directMembers = User::where(function ($q) use ($affiliateId, $user) {
            $q->where('sponsor_id', $affiliateId);
            if ($user && $user->email) {
                $q->orWhere('sponsor_id', $user->email);
            }
        })->get(['id', 'name', 'affiliate_id']);

        $directAffiliateIds = $directMembers->pluck('affiliate_id')->filter()->toArray();
        $directMembersMap = $directMembers->keyBy('affiliate_id');

        $search = trim((string) $request->query('search', ''));

        $passiveUsers = collect();
        if (! empty($directAffiliateIds)) {
            $passiveQuery = User::whereIn('sponsor_id', $directAffiliateIds)->latest();
            if (! empty($search)) {
                $passiveQuery->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('affiliate_id', 'like', "%{$search}%")
                        ->orWhere('active_package', 'like', "%{$search}%");
                });
            }
            $passiveUsers = $passiveQuery->get();
        }

        // Calculate passive commission
        $passiveCommissions = 0.0;
        if ($user) {
            $passiveCommissions = (float) Commission::where('user_id', $user->id)
                ->where(function ($q) {
                    $q->where('commission_type', 'like', '%Passive%')
                        ->orWhere('commission_type', 'like', '%Tier-2%');
                })
                ->where('status', 'Credited')
                ->sum('amount');

            if ($passiveCommissions <= 0) {
                $passiveCommissions = (float) ($user->passive_earning ?? 0);
            }
        }

        // If no passive users yet and no search query, show realistic demo team network data
        if ($passiveUsers->isEmpty() && empty($search)) {
            $mockPassive = [
                [
                    'id' => 201,
                    'name' => 'Vikram Singhania',
                    'affiliate_id' => 'SKL-7858',
                    'referred_by' => 'Rahul Sharma (SKL-9809)',
                    'active_package' => 'Infinity Package',
                    'passive_income' => 500,
                    'joined_date' => '05-11-2026',
                    'status' => 'Active',
                ],
                [
                    'id' => 202,
                    'name' => 'Deepak Rawat',
                    'affiliate_id' => 'SKL-3142',
                    'referred_by' => 'Rahul Sharma (SKL-9809)',
                    'active_package' => 'Advance Package',
                    'passive_income' => 200,
                    'joined_date' => '04-11-2026',
                    'status' => 'Active',
                ],
                [
                    'id' => 203,
                    'name' => 'Anjali Mishra',
                    'affiliate_id' => 'SKL-8173',
                    'referred_by' => 'Priya Patel (SKL-5293)',
                    'active_package' => 'Growth Package',
                    'passive_income' => 100,
                    'joined_date' => '03-11-2026',
                    'status' => 'Active',
                ],
                [
                    'id' => 204,
                    'name' => 'Mohit Sen',
                    'affiliate_id' => 'SKL-6401',
                    'referred_by' => 'Aman Verma (SKL-9768)',
                    'active_package' => 'Basic Package',
                    'passive_income' => 50,
                    'joined_date' => '02-11-2026',
                    'status' => 'Active',
                ],
            ];
            $displayList = collect($mockPassive);
            $totalCount = 4;
            if ($passiveCommissions <= 0) {
                $passiveCommissions = 850.0;
            }
        } else {
            $displayList = $passiveUsers->map(function ($pu) use ($directMembersMap) {
                $sponsor = $directMembersMap->get($pu->sponsor_id);
                $sponsorLabel = $sponsor ? "{$sponsor->name} ({$pu->sponsor_id})" : ($pu->sponsor_id ?: 'Direct Member');
                $passiveAmt = self::estimatePassiveCommission($pu->active_package);

                return [
                    'id' => $pu->id,
                    'name' => $pu->name,
                    'affiliate_id' => $pu->affiliate_id,
                    'referred_by' => $sponsorLabel,
                    'active_package' => $pu->active_package ?: 'Basic Package',
                    'passive_income' => $passiveAmt,
                    'joined_date' => $pu->created_at ? $pu->created_at->format('d-m-Y') : date('d-m-Y'),
                    'status' => 'Active',
                ];
            });
            $totalCount = $passiveUsers->count();
        }

        return view('portal.passive-referrals', [
            'referrals' => $displayList,
            'totalCount' => $totalCount,
            'totalPassiveCommissions' => $passiveCommissions,
            'affiliateId' => $affiliateId,
            'active' => 'passive-referrals',
            'search' => $search,
        ]);
    }

    private static function estimateActiveCommission(?string $packageName): float
    {
        return match (strtolower($packageName ?? '')) {
            'growth', 'growth package' => 840.0,
            'advance', 'advance package' => 1900.0,
            'premium', 'premium package' => 3800.0,
            'infinity', 'infinity package' => 5500.0,
            default => 420.0,
        };
    }

    private static function estimatePassiveCommission(?string $packageName): float
    {
        return match (strtolower($packageName ?? '')) {
            'growth', 'growth package' => 100.0,
            'advance', 'advance package' => 200.0,
            'premium', 'premium package' => 400.0,
            'infinity', 'infinity package' => 500.0,
            default => 50.0,
        };
    }
}
