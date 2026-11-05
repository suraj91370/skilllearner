<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        return view('portal.kyc', [
            'active' => 'kyc',
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

        $userData = session('user', []);
        $userData['bank_name'] = $validated['bank_name'] ?? 'HDFC Bank';
        $userData['holder_name'] = $validated['holder_name'] ?? ($userData['name'] ?? 'adarsh pandey');
        $userData['account_number'] = $validated['account_number'] ?? '50100494320380';
        $userData['ifsc_code'] = $validated['ifsc_code'] ?? 'HDFC0000194';
        $userData['upi_id'] = $validated['upi_id'] ?? 'adarshpandey3851-3@okhdfcbank';
        $userData['kyc_status'] = 'Verified ✅';

        session(['user' => $userData]);

        return redirect()->back()->with('success', 'Your Bank Details have been saved successfully! ✅');
    }
}
