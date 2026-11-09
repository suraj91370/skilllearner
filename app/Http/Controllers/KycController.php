<?php

namespace App\Http\Controllers;

use App\Models\KycVerification;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $user = Auth::user();
        $kyc = $user?->kyc;

        return view('portal.kyc', [
            'active' => 'kyc',
            'kyc' => $kyc,
        ]);
    }

    public function update(Request $request)
    {
        PortalDataService::ensureUserSession();

        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:100',
            'holder_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'upi_id' => 'nullable|string|max:100',
        ]);

        $bankName = trim($validated['bank_name'] ?? '');
        $holderName = trim($validated['holder_name'] ?? '');
        $accountNumber = trim($validated['account_number'] ?? '');
        $ifscCode = trim($validated['ifsc_code'] ?? '');
        $upiId = trim($validated['upi_id'] ?? '');

        $hasData = ! empty($bankName) || ! empty($accountNumber) || ! empty($ifscCode) || ! empty($upiId);

        $user = Auth::user();
        if ($user) {
            KycVerification::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bank_name' => $bankName ?: null,
                    'holder_name' => $holderName ?: null,
                    'account_number' => $accountNumber ?: null,
                    'ifsc_code' => $ifscCode ?: null,
                    'upi_id' => $upiId ?: null,
                    'status' => $hasData ? 'Approved' : 'Pending',
                ]
            );

            if ($hasData) {
                $user->kyc_status = 'Verified ✅';
                $user->save();
            }
        }

        $userData = session('user', []);
        $userData['bank_name'] = $bankName;
        $userData['holder_name'] = $holderName;
        $userData['account_number'] = $accountNumber;
        $userData['ifsc_code'] = $ifscCode;
        $userData['upi_id'] = $upiId;
        $userData['kyc_status'] = $hasData ? 'Verified ✅' : 'Pending';

        session(['user' => $userData]);

        return redirect()->back()->with('success', 'Your Bank Details have been saved successfully! ✅');
    }
}
