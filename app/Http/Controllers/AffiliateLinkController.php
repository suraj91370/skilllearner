<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class AffiliateLinkController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        return view('portal.affiliate-link', [
            'active' => 'affiliate-link',
        ]);
    }
}
