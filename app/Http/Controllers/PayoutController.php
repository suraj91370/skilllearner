<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $user = Auth::user();
        if ($user) {
            $payouts = $user->payouts()->get()->map(function ($p) {
                $status = in_array($p->status, ['Transferred', 'Approved', 'Paid']) ? 'Paid' : $p->status;
                return [
                    'id' => $p->payout_code,
                    'amount' => (float) $p->amount,
                    'amount_formatted' => number_format($p->amount, 0, '', ''),
                    'method' => $p->payment_method,
                    'status' => $status,
                    'created_date' => $p->created_at ? $p->created_at->format('d-m-Y') : date('d-m-Y'),
                    'updated_date' => $p->updated_at ? $p->updated_at->format('d-m-Y') : ($p->created_at ? $p->created_at->format('d-m-Y') : date('d-m-Y')),
                    'date' => $p->created_at ? $p->created_at->format('d-m-Y') : date('d-m-Y'),
                ];
            })->toArray();
        } else {
            $sessionPayouts = session('payouts', []);
            $payouts = array_map(function ($p) {
                $created = $p['created_date'] ?? ($p['date'] ?? date('d-m-Y'));
                $status = in_array($p['status'] ?? '', ['Transferred', 'Approved', 'Paid']) ? 'Paid' : ($p['status'] ?? 'Pending');
                return [
                    'id' => $p['id'] ?? 'PAY-'.rand(1000, 9999),
                    'amount' => (float) ($p['amount'] ?? 0),
                    'amount_formatted' => number_format((float) ($p['amount'] ?? 0), 0, '', ''),
                    'method' => $p['method'] ?? 'UPI',
                    'status' => $status,
                    'created_date' => date('d-m-Y', strtotime($created)),
                    'updated_date' => date('d-m-Y', strtotime($p['updated_date'] ?? $created)),
                    'date' => date('d-m-Y', strtotime($created)),
                ];
            }, $sessionPayouts);
        }

        $totalTransferred = collect($payouts)->where('status', 'Paid')->sum('amount');
        $timesWithdrawn = collect($payouts)->where('status', 'Paid')->count();
        $pendingAmount = collect($payouts)->whereIn('status', ['Pending', 'Processing'])->sum('amount');

        return view('portal.payout', [
            'payouts' => $payouts,
            'totalTransferred' => $totalTransferred,
            'timesWithdrawn' => $timesWithdrawn,
            'pendingAmount' => $pendingAmount,
            'active' => 'payout',
        ]);
    }

    public function requestPayout(Request $request)
    {
        PortalDataService::ensureUserSession();

        $request->validate([
            'payout_amount' => 'required|numeric|min:500',
            'payout_details' => 'required|string|max:255',
        ]);

        $amount = (float) $request->input('payout_amount', 0);
        $details = trim($request->input('payout_details', ''));

        $user = Auth::user();
        $currentBalance = $user ? (float) $user->wallet_balance : (float) session('user.wallet_balance', 0);

        if ($amount < 500) {
            return back()->with('error', 'Minimum withdrawal amount is ₹500.');
        }

        if ($amount > $currentBalance) {
            return back()->with('error', 'Insufficient balance! Available wallet balance is ₹' . number_format($currentBalance, 2));
        }

        $payoutCode = 'PAY-' . rand(10000, 99999);

        if ($user) {
            // Deduct immediately from wallet balance
            $user->decrement('wallet_balance', $amount);
            $user->refresh();

            // Create pending payout record for admin approval
            Payout::create([
                'payout_code' => $payoutCode,
                'user_id' => $user->id,
                'amount' => $amount,
                'payment_method' => $details,
                'status' => 'Pending',
            ]);

            // Save details to KYC if not set
            if ($user->kyc && empty($user->kyc->upi_id)) {
                $user->kyc->update(['upi_id' => $details]);
            }

            // Calculate updated pending withdrawals
            $pendingWithdrawal = $user->payouts()->whereIn('status', ['Pending', 'Processing'])->sum('amount');

            // Refresh user session data
            session([
                'user.wallet_balance' => (float) $user->wallet_balance,
                'user.pending_withdrawal' => (float) $pendingWithdrawal,
                'user.upi_id' => $details,
            ]);

            // Update session payouts list
            $payouts = $user->payouts()->get()->map(function ($p) {
                $status = in_array($p->status, ['Transferred', 'Approved', 'Paid']) ? 'Paid' : $p->status;
                return [
                    'id' => $p->payout_code,
                    'amount' => (float) $p->amount,
                    'amount_formatted' => number_format($p->amount, 0, '', ''),
                    'method' => $p->payment_method,
                    'status' => $status,
                    'created_date' => $p->created_at ? $p->created_at->format('d-m-Y') : date('d-m-Y'),
                    'updated_date' => $p->updated_at ? $p->updated_at->format('d-m-Y') : date('d-m-Y'),
                    'date' => $p->created_at ? $p->created_at->format('d-m-Y') : date('d-m-Y'),
                ];
            })->toArray();
            session(['payouts' => $payouts]);
        } else {
            // Guest / demo user fallback
            $sessionUser = session('user', []);
            $sessionUser['wallet_balance'] -= $amount;
            $sessionUser['pending_withdrawal'] = ($sessionUser['pending_withdrawal'] ?? 0) + $amount;
            $sessionUser['upi_id'] = $details;
            session(['user' => $sessionUser]);

            $payouts = session('payouts', []);
            array_unshift($payouts, [
                'id' => $payoutCode,
                'amount' => $amount,
                'amount_formatted' => number_format($amount, 0, '', ''),
                'method' => $details,
                'status' => 'Pending',
                'created_date' => date('d-m-Y'),
                'updated_date' => date('d-m-Y'),
                'date' => date('d-m-Y'),
            ]);
            session(['payouts' => $payouts]);
        }

        return back()->with('success', 'Withdrawal request of ₹' . number_format($amount) . ' submitted successfully! Status is Pending until Super Admin approves.');
    }
}
