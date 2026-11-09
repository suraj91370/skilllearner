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

        $sponsorIdentifiers = array_values(array_filter([
            $affiliateId,
            $user ? (string) $user->id : null,
            $user ? 'SL-'.$user->id : null,
            $user ? 'SKL-'.$user->id : null,
            $user ? $user->email : null,
        ]));

        // Query direct referrals from users table
        $directReferralsQuery = User::whereIn('sponsor_id', $sponsorIdentifiers)->latest();

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

        // Calculate actual commissions earned from direct referrals
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

            if ($activeCommissions <= 0 && ($user->total_earning ?? 0) > 0) {
                $activeCommissions = (float) max(0, $user->total_earning - ($user->passive_earning ?? 0));
            }
        }

        // Map strictly from real database records (no static mock data)
        $displayList = $referrals->map(function ($ref) use ($user) {
            $amount = 0.0;
            if ($user) {
                $comm = Commission::where('user_id', $user->id)
                    ->where(function ($q) use ($ref) {
                        $q->where('buyer_name', $ref->name)
                            ->orWhere('buyer_name', 'like', "%{$ref->name}%")
                            ->orWhere('buyer_name', 'like', "%{$ref->email}%");
                    })
                    ->where(function ($q) {
                        $q->where('commission_type', 'like', '%Active%')
                            ->orWhere('commission_type', 'like', '%Tier-1%')
                            ->orWhere('commission_type', 'like', '%Direct%');
                    })
                    ->where('status', 'Credited')
                    ->first();

                if ($comm) {
                    $amount = (float) $comm->amount;
                }
            }

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

        $sponsorIdentifiers = array_values(array_filter([
            $affiliateId,
            $user ? (string) $user->id : null,
            $user ? 'SL-'.$user->id : null,
            $user ? 'SKL-'.$user->id : null,
            $user ? $user->email : null,
        ]));

        // 1. Get all direct team members
        $directMembers = User::whereIn('sponsor_id', $sponsorIdentifiers)
            ->get(['id', 'name', 'affiliate_id', 'email']);

        $directAffiliateCodes = [];
        foreach ($directMembers as $dm) {
            if ($dm->affiliate_id) {
                $directAffiliateCodes[] = $dm->affiliate_id;
            }
            $directAffiliateCodes[] = (string) $dm->id;
            $directAffiliateCodes[] = 'SL-'.$dm->id;
            $directAffiliateCodes[] = 'SKL-'.$dm->id;
            if ($dm->email) {
                $directAffiliateCodes[] = $dm->email;
            }
        }
        $directAffiliateCodes = array_values(array_unique(array_filter($directAffiliateCodes)));
        $directMembersMap = $directMembers->keyBy('affiliate_id');

        $search = trim((string) $request->query('search', ''));

        $passiveUsers = collect();
        if (! empty($directAffiliateCodes)) {
            $passiveQuery = User::whereIn('sponsor_id', $directAffiliateCodes)->latest();
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

        // Calculate actual passive commission
        $passiveCommissions = 0.0;
        if ($user) {
            $passiveCommissions = (float) Commission::where('user_id', $user->id)
                ->where(function ($q) {
                    $q->where('commission_type', 'like', '%Passive%')
                        ->orWhere('commission_type', 'like', '%Tier-2%');
                })
                ->where('status', 'Credited')
                ->sum('amount');

            if ($passiveCommissions <= 0 && ($user->passive_earning ?? 0) > 0) {
                $passiveCommissions = (float) $user->passive_earning;
            }
        }

        // Map strictly from real database records (no static mock data)
        $displayList = $passiveUsers->map(function ($pu) use ($directMembersMap, $user) {
            $sponsor = $directMembersMap->get($pu->sponsor_id);
            $sponsorLabel = $sponsor ? "{$sponsor->name} ({$pu->sponsor_id})" : ($pu->sponsor_id ?: 'Direct Member');

            $amount = 0.0;
            if ($user) {
                $comm = Commission::where('user_id', $user->id)
                    ->where(function ($q) use ($pu) {
                        $q->where('buyer_name', $pu->name)
                            ->orWhere('buyer_name', 'like', "%{$pu->name}%")
                            ->orWhere('buyer_name', 'like', "%{$pu->email}%");
                    })
                    ->where(function ($q) {
                        $q->where('commission_type', 'like', '%Passive%')
                            ->orWhere('commission_type', 'like', '%Tier-2%');
                    })
                    ->where('status', 'Credited')
                    ->first();

                if ($comm) {
                    $amount = (float) $comm->amount;
                }
            }

            return [
                'id' => $pu->id,
                'name' => $pu->name,
                'email' => $pu->email,
                'affiliate_id' => $pu->affiliate_id,
                'referred_by' => $sponsorLabel,
                'active_package' => $pu->active_package ?: 'Basic Package',
                'passive_income' => $amount,
                'joined_date' => $pu->created_at ? $pu->created_at->format('d-m-Y') : date('d-m-Y'),
                'status' => 'Active',
            ];
        });

        $totalCount = $passiveUsers->count();

        return view('portal.passive-referrals', [
            'referrals' => $displayList,
            'totalCount' => $totalCount,
            'totalPassiveCommissions' => $passiveCommissions,
            'affiliateId' => $affiliateId,
            'active' => 'passive-referrals',
            'search' => $search,
        ]);
    }
}
