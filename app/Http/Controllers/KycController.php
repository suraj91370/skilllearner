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
}
