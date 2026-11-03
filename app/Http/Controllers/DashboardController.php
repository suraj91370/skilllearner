<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use App\Services\CommissionService;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $pendingCommissions = 0.0;
        if (Auth::check()) {
            /** @var User $authUser */
            $authUser = Auth::user();
            $pendingCommissions = (float) $authUser->commissions()->where('status', 'Pending')->sum('amount');
        }

        return view('portal.dashboard', [
            'commissions' => session('commissions', []),
            'payouts' => session('payouts', []),
            'packages' => CommissionService::PACKAGES,
            'pendingCommissions' => $pendingCommissions,
            'active' => 'dashboard',
        ]);
    }

    public function simulateSale(Request $request)
    {
        PortalDataService::ensureUserSession();

        $userRole = Auth::user()?->role ?? session('user.role', 'user');
        if (! in_array($userRole, ['super_admin', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Self-crediting is disabled. Commissions are credited only when your referred lead makes a payment and it is verified by administration.');
        }

        $packageKey = strtolower((string) $request->query('package', 'advance'));
        $pkg = CommissionService::getPackageInfo($packageKey);
        $type = strtolower((string) $request->query('type', 'active')); // 'active' or 'passive'
        $isPassive = ($type === 'passive');

        $amount = $isPassive ? (float) $pkg['passive_income'] : (float) $pkg['active_income'];
        $typeName = $isPassive ? 'Passive Income (Tier-2)' : 'Active Income (Tier-1)';

        $names = ['Rohan Das', 'Ananya Gupta', 'Vikas Reddy', 'Manish Mehra', 'Deepak Soni', 'Priya Sharma', 'Karan Mehta'];
        $randomBuyer = $names[array_rand($names)];
        $buyerDisplay = $isPassive ? "{$randomBuyer} (via Direct Team Member)" : $randomBuyer;

        // 1. Update Database if user is authenticated
        if (Auth::check()) {
            /** @var User $authUser */
            $authUser = Auth::user();
            $authUser->increment('wallet_balance', $amount);
            $authUser->increment('today_earning', $amount);
            $authUser->increment('weekly_earning', $amount);
            $authUser->increment('monthly_earning', $amount);
            $authUser->increment('total_earning', $amount);

            if ($isPassive) {
                $authUser->increment('passive_earning', $amount);
            }

            Commission::create([
                'user_id' => $authUser->id,
                'buyer_name' => $buyerDisplay,
                'package_name' => $pkg['name'],
                'amount' => $amount,
                'commission_type' => $typeName,
                'status' => 'Credited',
            ]);
        }

        // 2. Update Session User data
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

        // 3. Prepend to session commissions list
        $commissions = session('commissions', []);
        array_unshift($commissions, [
            'name' => $buyerDisplay,
            'package' => $pkg['name'],
            'amount' => $amount,
            'type' => $typeName,
            'time' => 'Just now',
            'status' => 'Credited',
        ]);
        session(['commissions' => $commissions]);

        $flashMsg = $isPassive
            ? "💎 ₹".number_format($amount)." Passive Income Credited! Your Tier-2 team member referred {$randomBuyer} for {$pkg['name']}."
            : "🎉 ₹".number_format($amount)." Active Income Credited! You directly referred {$randomBuyer} for {$pkg['name']}.";

        return redirect('/dashboard')->with('success', $flashMsg);
    }
}
