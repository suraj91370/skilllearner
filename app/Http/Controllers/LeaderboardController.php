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
     * Get 100% dynamic Top 10 leaderboard rankings from the database.
     * Queries real database users & commissions. No static arrays.
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

        // Query credited commissions within timeframe from DB
        $commQuery = Commission::where('status', 'Credited');
        if ($startDate) {
            $commQuery->where('created_at', '>=', $startDate);
        }
        $commissionSums = $commQuery
            ->selectRaw('user_id, SUM(amount) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        // Fetch users dynamically from database
        $users = User::select(['id', 'name', 'avatar', 'today_earning', 'weekly_earning', 'monthly_earning', 'total_earning', 'industry_revenue'])->get();

        $ranked = [];
        $currentAuthId = auth()->id() ?? session('user.id');

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
                    'is_current_user' => $currentAuthId && ((int) $currentAuthId === (int) $user->id),
                ];
            }
        }

        // Sort dynamically descending by earnings
        usort($ranked, fn ($a, $b) => $b['earnings'] <=> $a['earnings']);

        // Dynamic Top 10 rankings from DB
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
