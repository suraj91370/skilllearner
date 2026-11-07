<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
                    'updated_date' => $p->updated_at ? $p->updated_at->format('d-m-Y') : date('d-m-Y'),
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

        return view('portal.profile', [
            'active' => 'profile',
            'payouts' => $payouts,
            'totalTransferred' => $totalTransferred,
            'timesWithdrawn' => $timesWithdrawn,
            'pendingAmount' => $pendingAmount,
        ]);
    }

    public function update(Request $request)
    {
        PortalDataService::ensureUserSession();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $validated['name'];
            if (! empty($validated['phone'])) {
                $user->phone = $validated['phone'];
            }
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('avatars', 'public');
                $publicAvatarsDir = public_path('storage/avatars');
                if (! file_exists($publicAvatarsDir)) {
                    @mkdir($publicAvatarsDir, 0755, true);
                }
                @copy(storage_path('app/public/'.$path), public_path('storage/'.$path));
                $user->avatar = '/storage/'.$path;
            }
            $user->save();
        }

        $sessionUser = session('user', []);
        $sessionUser['name'] = $validated['name'];
        if (! empty($validated['phone'])) {
            $sessionUser['phone'] = $validated['phone'];
        }
        if (isset($validated['instagram'])) {
            $sessionUser['instagram'] = $validated['instagram'];
        }
        if ($request->hasFile('avatar')) {
            $path = $path ?? $request->file('avatar')->store('avatars', 'public');
            $publicAvatarsDir = public_path('storage/avatars');
            if (! file_exists($publicAvatarsDir)) {
                @mkdir($publicAvatarsDir, 0755, true);
            }
            @copy(storage_path('app/public/'.$path), public_path('storage/'.$path));
            $sessionUser['avatar'] = '/storage/'.$path;
        }
        session(['user' => $sessionUser]);

        return redirect()->back()->with('success', 'Profile details updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        if ($user) {
            if (! Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
