<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        return view('portal.payout', [
            'payouts' => session('payouts', []),
            'active' => 'payout',
        ]);
    }

    public function requestPayout(Request $request)
    {
        PortalDataService::ensureUserSession();

        $amount = (float) $request->input('payout_amount', 0);
        $details = htmlspecialchars($request->input('payout_details', ''));

        $user = session('user');
        if ($amount >= 500 && $amount <= $user['wallet_balance']) {
            $user['wallet_balance'] -= $amount;
            session(['user' => $user]);

            $payouts = session('payouts', []);
            array_unshift($payouts, [
                'id' => 'PAY-'.rand(2000, 9999),
                'amount' => $amount,
                'method' => $details,
                'status' => 'Processing (Under 24h)',
                'date' => date('Y-m-d H:i'),
            ]);
            session(['payouts' => $payouts]);

            return redirect('/my-payout')->with('alert', 'payout_success');
        }

        return redirect('/my-payout')->with('alert', 'payout_error');
    }
}
