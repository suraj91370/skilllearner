<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use App\Services\PortalDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $activeTab = (string) $request->query('tab', 'today');
        if (! in_array($activeTab, ['today', '7days', '30days', 'alltime'])) {
            $activeTab = 'today';
        }

        $leaderboards = [
            'today' => $this->getDynamicLeaderboard('today', 10),
            '7days' => $this->getDynamicLeaderboard('7days', 10),
            '30days' => $this->getDynamicLeaderboard('30days', 10),
            'alltime' => $this->getDynamicLeaderboard('alltime', 10),
        ];

        return view('portal.leaderboard', [
            'activeTab' => $activeTab,
            'leaderboards' => $leaderboards,
            'currentLeaderboard' => $leaderboards[$activeTab] ?? [],
            'active' => 'leaderboard',
        ]);
    }

    /**
     * Get dynamic Top 10 leaderboard rankings for a given timeframe.
     * Merges real DB earners with active community achievers so it's always an inspiring Top 10.
     *
     * @param  string  $timeframe  'today' | '7days' | '30days' | 'alltime'
     */
    protected function getDynamicLeaderboard(string $timeframe = 'today', int $limit = 10): array
    {
        $timezone = 'Asia/Kolkata';
        $nowIst = Carbon::now($timezone);

        $startDate = match ($timeframe) {
            'today' => (clone $nowIst)->startOfDay(),
            '7days' => (clone $nowIst)->subDays(6)->startOfDay(),
            '30days' => (clone $nowIst)->subDays(29)->startOfDay(),
            default => null,
        };

        // Query real credited commissions within timeframe
        $commQuery = Commission::where('status', 'Credited');
        if ($startDate) {
            $commQuery->where('created_at', '>=', $startDate);
        }
        $commissionSums = $commQuery
            ->selectRaw('user_id, SUM(amount) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $users = User::select(['id', 'name', 'avatar', 'today_earning', 'weekly_earning', 'monthly_earning', 'total_earning', 'industry_revenue'])->get();

        $ranked = [];
        $currentAuthId = auth()->id() ?? session('user.id');

        // Add real database users who have earnings
        foreach ($users as $user) {
            $colVal = match ($timeframe) {
                'today' => (float) ($user->today_earning ?? 0),
                '7days' => (float) ($user->weekly_earning ?? 0),
                '30days' => (float) ($user->monthly_earning ?? 0),
                default => (float) max($user->total_earning ?? 0, $user->industry_revenue ?? 0),
            };

            $commVal = (float) ($commissionSums[$user->id] ?? 0);
            $earnings = max($colVal, $commVal);

            if ($earnings > 0) {
                $avatar = $user->avatar;
                if (empty($avatar)) {
                    $avatar = 'https://ui-avatars.com/api/?name='.urlencode($user->name ?: 'User').'&background=0070f3&color=ffffff&bold=true';
                } elseif (! str_starts_with($avatar, 'http')) {
                    $avatar = url($avatar);
                }

                $ranked[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'earnings' => $earnings,
                    'avatar' => $avatar,
                    'is_real' => true,
                    'is_current_user' => $currentAuthId && ((int) $currentAuthId === (int) $user->id),
                ];
            }
        }

        // Base community benchmark achievers (from reference screenshot)
        $baseAchievers = $this->getBaseAchievers($timeframe);

        // Merge real users with base achievers (skip if same name)
        $realNames = array_map(fn ($r) => strtolower(trim($r['name'])), $ranked);
        foreach ($baseAchievers as $achiever) {
            if (! in_array(strtolower(trim($achiever['name'])), $realNames)) {
                $ranked[] = $achiever;
            }
        }

        // Sort descending by earnings
        usort($ranked, fn ($a, $b) => $b['earnings'] <=> $a['earnings']);

        // Assign ranks 1 to limit (Top 10)
        $leaderboard = [];
        $rank = 1;
        foreach (array_slice($ranked, 0, $limit) as $item) {
            $item['rank'] = $rank++;
            $leaderboard[] = $item;
        }

        return $leaderboard;
    }

    /**
     * Top 10 base achievers matching reference screenshot.
     */
    protected function getBaseAchievers(string $timeframe): array
    {
        return match ($timeframe) {
            'today' => [
                ['name' => 'Akanksha', 'earnings' => 26486, 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Mayank', 'earnings' => 5300, 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Shivani', 'earnings' => 5000, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Krupali Birari', 'earnings' => 3700, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Monika sorot', 'earnings' => 2600, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'SAKIB SHAIKH', 'earnings' => 2600, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => '🪶Shreya', 'earnings' => 1800, 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Neha', 'earnings' => 1600, 'avatar' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Rohit Sharma', 'earnings' => 1400, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Priya Verma', 'earnings' => 1100, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
            ],
            '7days' => [
                ['name' => 'Akanksha', 'earnings' => 84500, 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Mayank', 'earnings' => 46200, 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Shivani', 'earnings' => 38900, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Krupali Birari', 'earnings' => 28400, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Monika sorot', 'earnings' => 21600, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'SAKIB SHAIKH', 'earnings' => 19800, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => '🪶Shreya', 'earnings' => 16200, 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Neha', 'earnings' => 14500, 'avatar' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Rohit Sharma', 'earnings' => 12300, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Priya Verma', 'earnings' => 9800, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
            ],
            '30days' => [
                ['name' => 'Akanksha', 'earnings' => 246800, 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Mayank', 'earnings' => 185400, 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Shivani', 'earnings' => 152000, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Krupali Birari', 'earnings' => 118500, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Monika sorot', 'earnings' => 96400, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'SAKIB SHAIKH', 'earnings' => 84200, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => '🪶Shreya', 'earnings' => 72600, 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Neha', 'earnings' => 63100, 'avatar' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Rohit Sharma', 'earnings' => 54800, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Priya Verma', 'earnings' => 42500, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
            ],
            'alltime' => [
                ['name' => 'Akanksha', 'earnings' => 684500, 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Mayank', 'earnings' => 512000, 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Shivani', 'earnings' => 445000, 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Krupali Birari', 'earnings' => 362000, 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Monika sorot', 'earnings' => 295000, 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'SAKIB SHAIKH', 'earnings' => 248000, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => '🪶Shreya', 'earnings' => 215000, 'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Neha', 'earnings' => 188000, 'avatar' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Rohit Sharma', 'earnings' => 156000, 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
                ['name' => 'Priya Verma', 'earnings' => 124000, 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80', 'is_real' => false],
            ],
        };
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
