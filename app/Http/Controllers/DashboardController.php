<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        return view('portal.dashboard', [
            'commissions' => session('commissions', []),
            'payouts' => session('payouts', []),
            'active' => 'dashboard',
        ]);
    }

    public function simulateSale(Request $request)
    {
        PortalDataService::ensureUserSession();

        $saleAmount = 2200;
        $user = session('user');
        $user['wallet_balance'] += $saleAmount;
        $user['today_earning'] += $saleAmount;
        $user['weekly_earning'] += $saleAmount;
        $user['total_earning'] += $saleAmount;
        session(['user' => $user]);

        $commissions = session('commissions', []);
        $names = ['Rohan Das', 'Ananya Gupta', 'Vikas Reddy', 'Manish Mehra', 'Deepak Soni'];
        array_unshift($commissions, [
            'name' => $names[array_rand($names)],
            'package' => 'Advance Package',
            'amount' => $saleAmount,
            'type' => 'Direct (Tier-1)',
            'time' => 'Just now',
            'status' => 'Credited',
        ]);
        session(['commissions' => $commissions]);

        return redirect('/dashboard')->with('alert', 'sale_added');
    }
}
