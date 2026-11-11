<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use App\Services\CommissionService;
use App\Services\PortalDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $authUser = Auth::user();
        $pendingCommissions = 0.0;
        if ($authUser) {
            $pendingCommissions = (float) $authUser->commissions()->where('status', 'Pending')->sum('amount');
            $earnings = CommissionService::calculateUserEarnings($authUser);
            $todayEarning = $earnings['today'];
            $weeklyEarning = $earnings['weekly'];
            $monthlyEarning = $earnings['monthly'];
            $totalEarning = $earnings['total'];
            $passiveEarning = $earnings['passive'];
            $industryRevenue = (float) ($authUser->industry_revenue ?? 0.00);
        } else {
            $todayEarning = (float) session('user.today_earning', 0);
            $weeklyEarning = (float) session('user.weekly_earning', 0);
            $monthlyEarning = (float) session('user.monthly_earning', 0);
            $totalEarning = (float) session('user.total_earning', 0);
            $passiveEarning = (float) session('user.passive_earning', 0);
            $industryRevenue = (float) session('user.industry_revenue', 0);
        }

        // 2. Dynamic 7 Days Sales Graph (Strictly Indian Standard Time - Asia/Kolkata)
        $timezone = 'Asia/Kolkata';
        $carbonNow = Carbon::now($timezone);
        $sevenDays = [];
        for ($i = 6; $i >= 0; $i--) {
            $dt = (clone $carbonNow)->subDays($i);
            $key = $dt->format('Y-m-d');
            $sevenDays[$key] = [
                'day_name' => $dt->isToday() ? 'Today' : $dt->format('D'),
                'short_date' => $dt->format('d M'),
                'amount' => 0.0,
            ];
        }

        if ($authUser) {
            $sevenDaysStart = (clone $carbonNow)->subDays(6)->startOfDay();
            $commissions = Commission::where('user_id', $authUser->id)
                ->where('status', 'Credited')
                ->where('created_at', '>=', $sevenDaysStart)
                ->get();

            foreach ($commissions as $comm) {
                if ($comm->created_at) {
                    $cDate = Carbon::parse($comm->created_at)->timezone($timezone);
                    $cKey = $cDate->format('Y-m-d');
                    if (isset($sevenDays[$cKey])) {
                        $sevenDays[$cKey]['amount'] += (float) $comm->amount;
                    }
                }
            }
        }

        // Calculate Y-scale and points for SVG
        $amounts = array_column($sevenDays, 'amount');
        $maxVal = !empty($amounts) ? max($amounts) : 0;

        $maxScale = 100;
        if ($maxVal > 0) {
            if ($maxVal <= 500) {
                $maxScale = (int) (ceil($maxVal / 50) * 50);
            } elseif ($maxVal <= 5000) {
                $maxScale = (int) (ceil($maxVal / 500) * 500);
            } else {
                $maxScale = (int) (ceil($maxVal / 1000) * 1000);
            }
            if ($maxScale < $maxVal) {
                $maxScale = (int) $maxVal;
            }
        }

        // Build SVG graph data points
        $graphPoints = [];
        $xCoords = [75, 195, 315, 435, 555, 675, 795];
        $idx = 0;
        foreach ($sevenDays as $dateKey => $dayData) {
            $val = $dayData['amount'];
            $x = $xCoords[$idx] ?? (75 + $idx * 120);
            $y = ($maxScale > 0 && $val > 0) ? round(295 - (($val / $maxScale) * 260), 1) : 295.0;
            $graphPoints[] = [
                'x' => $x,
                'y' => $y,
                'amount' => $val,
                'day_name' => $dayData['day_name'],
                'date' => $dayData['short_date'],
            ];
            $idx++;
        }

        $polylinePoints = implode(' ', array_map(fn($p) => "{$p['x']},{$p['y']}", $graphPoints));
        $firstX = $graphPoints[0]['x'] ?? 75;
        $lastX = $graphPoints[count($graphPoints) - 1]['x'] ?? 795;
        $polygonPoints = "{$polylinePoints} {$lastX},295 {$firstX},295";

        $yAxisTicks = [
            ['y' => 35,  'label' => '₹' . number_format($maxScale)],
            ['y' => 87,  'label' => '₹' . number_format(round($maxScale * 0.8))],
            ['y' => 139, 'label' => '₹' . number_format(round($maxScale * 0.6))],
            ['y' => 191, 'label' => '₹' . number_format(round($maxScale * 0.4))],
            ['y' => 243, 'label' => '₹' . number_format(round($maxScale * 0.2))],
            ['y' => 295, 'label' => '₹0'],
        ];

        return view('portal.dashboard', [
            'commissions' => session('commissions', []),
            'payouts' => session('payouts', []),
            'packages' => CommissionService::PACKAGES,
            'pendingCommissions' => $pendingCommissions,
            'todayEarning' => $todayEarning,
            'weeklyEarning' => $weeklyEarning,
            'monthlyEarning' => $monthlyEarning,
            'totalEarning' => $totalEarning,
            'passiveEarning' => $passiveEarning,
            'industryRevenue' => $industryRevenue,
            'graphPoints' => $graphPoints,
            'polylinePoints' => $polylinePoints,
            'polygonPoints' => $polygonPoints,
            'yAxisTicks' => $yAxisTicks,
            'maxVal' => $maxVal,
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

            Commission::create([
                'user_id' => $authUser->id,
                'buyer_name' => $buyerDisplay,
                'package_name' => $pkg['name'],
                'amount' => $amount,
                'commission_type' => $typeName,
                'status' => 'Credited',
            ]);

            CommissionService::creditUserEarnings($authUser, $amount, $isPassive);
            $earnings = CommissionService::calculateUserEarnings($authUser);

            // Update Session User data
            $user = session('user', []);
            $user['wallet_balance'] = (float) $authUser->wallet_balance;
            $user['today_earning'] = (float) $earnings['today'];
            $user['weekly_earning'] = (float) $earnings['weekly'];
            $user['monthly_earning'] = (float) $earnings['monthly'];
            $user['total_earning'] = (float) $earnings['total'];
            $user['passive_earning'] = (float) $earnings['passive'];
            $user['industry_revenue'] = (float) ($authUser->industry_revenue ?? 0.00);
            session(['user' => $user]);
        } else {
            // Update Session User data
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
        }

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
            ? '💎 ₹'.number_format($amount)." Passive Income Credited! Your Tier-2 team member referred {$randomBuyer} for {$pkg['name']}."
            : '🎉 ₹'.number_format($amount)." Active Income Credited! You directly referred {$randomBuyer} for {$pkg['name']}.";

        return redirect('/dashboard')->with('success', $flashMsg);
    }
}
