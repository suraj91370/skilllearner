<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $dailyLeaderboard = [
            ['rank' => 1, 'name' => 'VISHU', 'earnings' => 3440, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 2, 'name' => 'Shweta', 'earnings' => 2100, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 3, 'name' => 'Neha', 'earnings' => 1851, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 4, 'name' => 'ℜShreya', 'earnings' => 1800, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 5, 'name' => 'Nawaz { Sponsored }', 'earnings' => 1300, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 6, 'name' => 'Mannat Sharma', 'earnings' => 700, 'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=160&auto=format&fit=crop&q=80'],
        ];

        $weeklyLeaderboard = [
            ['rank' => 1, 'name' => 'Shivani', 'earnings' => 21713, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 2, 'name' => 'Akanksha', 'earnings' => 16136, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 3, 'name' => 'VISHU', 'earnings' => 9120, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 4, 'name' => 'Neha', 'earnings' => 7751, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 5, 'name' => 'Neha', 'earnings' => 4000, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 6, 'name' => 'Prince', 'earnings' => 3880, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=160&auto=format&fit=crop&q=80'],
        ];

        $monthlyLeaderboard = [
            ['rank' => 1, 'name' => 'Shivani', 'earnings' => 42879, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 2, 'name' => 'Akanksha', 'earnings' => 40939, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 3, 'name' => 'Neha', 'earnings' => 22097, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 4, 'name' => 'Prince', 'earnings' => 13467, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 5, 'name' => 'Neha', 'earnings' => 11530, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 6, 'name' => 'VISHU (Blaze Leader)', 'earnings' => 11349, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&auto=format&fit=crop&q=80'],
        ];

        $allTimeLeaderboard = [
            ['rank' => 1, 'name' => 'Akanksha', 'earnings' => 364641, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 2, 'name' => 'Shivani', 'earnings' => 188438, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 3, 'name' => 'Alok', 'earnings' => 177927, 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 4, 'name' => 'ℜShreya', 'earnings' => 173745, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 5, 'name' => 'Piyush Kashyap', 'earnings' => 157397, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=160&auto=format&fit=crop&q=80'],
            ['rank' => 6, 'name' => 'Ravi Sir', 'earnings' => 91116, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=160&auto=format&fit=crop&q=80'],
        ];

        return view('portal.leaderboard', [
            'dailyLeaderboard' => $dailyLeaderboard,
            'weeklyLeaderboard' => $weeklyLeaderboard,
            'monthlyLeaderboard' => $monthlyLeaderboard,
            'allTimeLeaderboard' => $allTimeLeaderboard,
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
