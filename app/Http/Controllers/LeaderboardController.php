<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use App\Services\PortalDataService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        PortalDataService::ensureUserSession();

        $dailyLeaderboard = $this->getLeaderboard('today');
        $weeklyLeaderboard = $this->getLeaderboard('7days');
        $monthlyLeaderboard = $this->getLeaderboard('30days');
        $allTimeLeaderboard = $this->getLeaderboard('alltime');

        return view('portal.leaderboard', [
            'dailyLeaderboard' => $dailyLeaderboard,
            'weeklyLeaderboard' => $weeklyLeaderboard,
            'monthlyLeaderboard' => $monthlyLeaderboard,
            'allTimeLeaderboard' => $allTimeLeaderboard,
            'active' => 'leaderboard',
        ]);
    }

    /**
     * Get dynamic leaderboard rankings for a given timeframe.
     *
     * @param  string  $timeframe  'today' | '7days' | '30days' | 'alltime'
     */
    protected function getLeaderboard(string $timeframe = 'today', int $limit = 10): array
    {
        $column = match ($timeframe) {
            'today' => 'today_earning',
            '7days' => 'weekly_earning',
            '30days' => 'monthly_earning',
            default => 'total_earning',
        };

        $startDate = match ($timeframe) {
            'today' => now()->startOfDay(),
            '7days' => now()->subDays(6)->startOfDay(),
            '30days' => now()->subDays(29)->startOfDay(),
            default => null,
        };

        // Query commissions in date range where status is 'Credited'
        $commQuery = Commission::where('status', 'Credited');
        if ($startDate) {
            $commQuery->where('created_at', '>=', $startDate);
        }
        $commissionSums = $commQuery
            ->selectRaw('user_id, SUM(amount) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $users = User::select(['id', 'name', 'avatar', 'today_earning', 'weekly_earning', 'monthly_earning', 'total_earning'])->get();

        $ranked = [];
        foreach ($users as $user) {
            $colVal = (float) ($user->{$column} ?? 0);
            $commVal = (float) ($commissionSums[$user->id] ?? 0);
            $earnings = max($colVal, $commVal);

            if ($earnings > 0) {
                $avatar = $user->avatar;
                if (empty($avatar)) {
                    $avatar = 'https://ui-avatars.com/api/?name='.urlencode($user->name ?: 'Student').'&background=0284c7&color=ffffff&bold=true';
                } elseif (! str_starts_with($avatar, 'http')) {
                    $avatar = url($avatar);
                }

                $ranked[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'earnings' => $earnings,
                    'avatar' => $avatar,
                ];
            }
        }

        // Sort descending by earnings
        usort($ranked, fn ($a, $b) => $b['earnings'] <=> $a['earnings']);

        // Assign ranks (1-based)
        $leaderboard = [];
        $rank = 1;
        foreach (array_slice($ranked, 0, $limit) as $item) {
            $item['rank'] = $rank++;
            $leaderboard[] = $item;
        }

        return $leaderboard;
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
