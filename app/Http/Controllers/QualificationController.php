<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        // Qualification tour contests (Empty array until admin launches active contests)
        $trips = [];

        return view('portal.qualification', [
            'trips' => $trips,
            'active' => 'qualification',
        ]);
    }
}
