<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $trips = [
            [
                'title' => 'Goa Luxury National Conclave 2026',
                'target' => 100000,
                'achieved' => session('user.total_earning', 48600),
                'deadline' => '30th November 2026',
                'status' => 'In Progress (48.6%)',
                'rewards' => '3 Days / 2 Nights 5-Star Resort Stay, Gala Dinner, Trophy Presentation',
            ],
            [
                'title' => 'Dubai International Creator Summit',
                'target' => 350000,
                'achieved' => session('user.total_earning', 48600),
                'deadline' => '31st December 2026',
                'status' => 'In Progress (13.8%)',
                'rewards' => 'All-Expense Paid International Flight, Desert Safari, Yacht Mastermind',
            ],
        ];

        return view('portal.qualification', [
            'trips' => $trips,
            'active' => 'qualification',
        ]);
    }
}
