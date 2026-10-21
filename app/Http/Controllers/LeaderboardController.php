<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $topEarners = [
            ['rank' => 1, 'name' => 'Rahul Sharma', 'package' => 'Infinity Package', 'earnings' => 482500, 'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80', 'state' => 'Delhi'],
            ['rank' => 2, 'name' => 'Pooja Agarwal', 'package' => 'Growth Package', 'earnings' => 345000, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80', 'state' => 'Mumbai'],
            ['rank' => 3, 'name' => 'Aditya Malhotra', 'package' => 'Infinity Package', 'earnings' => 289400, 'avatar' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80', 'state' => 'Chandigarh'],
            ['rank' => 4, 'name' => 'Simran Kaur', 'package' => 'Advance Package', 'earnings' => 194200, 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=100&auto=format&fit=crop&q=80', 'state' => 'Punjab'],
            ['rank' => 5, 'name' => 'Kunal Joshi', 'package' => 'Advance Package', 'earnings' => 165000, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80', 'state' => 'Jaipur'],
            ['rank' => 6, 'name' => 'Vansh Tandon (You)', 'package' => 'Advance Package', 'earnings' => 48600, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80', 'state' => 'Uttar Pradesh', 'is_current_user' => true],
            ['rank' => 7, 'name' => 'Ankit Rawat', 'package' => 'Basic Package', 'earnings' => 41200, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80', 'state' => 'Dehradun'],
        ];

        return view('portal.leaderboard', [
            'topEarners' => $topEarners,
            'active' => 'leaderboard',
        ]);
    }

    public function teamLeaderboard(Request $request)
    {
        PortalDataService::ensureUserSession();

        $teams = [
            ['rank' => 1, 'team_name' => 'Alpha Titans Squad', 'leader' => 'Vikram Singhania', 'members' => 38, 'total_volume' => 1485000, 'avatar' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=100&auto=format&fit=crop&q=80'],
            ['rank' => 2, 'team_name' => 'Growth Hackers Club', 'leader' => 'Meera Chawla', 'members' => 29, 'total_volume' => 1120000, 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&auto=format&fit=crop&q=80'],
            ['rank' => 3, 'team_name' => 'NextGen Affiliates', 'leader' => 'Rohan Sen', 'members' => 24, 'total_volume' => 890000, 'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&auto=format&fit=crop&q=80'],
            ['rank' => 4, 'team_name' => 'CareerFixx Elite Achievers', 'leader' => 'Vansh Tandon (Your Team)', 'members' => 12, 'total_volume' => 486000, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80', 'is_current_user' => true],
        ];

        return view('portal.team-leaderboard', [
            'teams' => $teams,
            'active' => 'team-leaderboard',
        ]);
    }
}
