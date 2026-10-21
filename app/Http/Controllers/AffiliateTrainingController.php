<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class AffiliateTrainingController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        return view('portal.training', [
            'active' => 'training',
        ]);
    }
}
