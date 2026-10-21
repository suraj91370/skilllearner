@extends('layouts.app')

@section('title', 'Team Leaderboard — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'team-leaderboard'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'team-leaderboard'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">👥 Team &amp; Squad Leaderboard</h3>
                        <p style="color: #64748b; font-size: 0.92rem;">Monthly squad sales rankings and team performance bonuses.</p>
                    </div>
                    <a href="{{ url('/leaderboard') }}" class="btn btn-secondary" style="border: 1px solid #a7f3d0; color: #05B396; font-weight: 700;">
                        View Individual Rankings ➔
                    </a>
                </div>

                <div class="table-responsive-wrapper">
                    <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left; width: 100%;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Rank</th>
                                <th style="padding: 10px;">Squad / Team</th>
                                <th style="padding: 10px;">Team Mentor</th>
                                <th style="padding: 10px;">Active Creators</th>
                                <th style="padding: 10px; text-align: right;">Squad Revenue Volume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $t)
                                <tr style="border-bottom: 1px solid #f1f5f9; {{ !empty($t['is_current_user']) ? 'background: #f0fdfa; font-weight: 700;' : '' }}">
                                    <td style="padding: 12px 10px;">
                                        <span style="font-weight: 800; color: #05B396;">#{{ $t['rank'] }}</span>
                                    </td>
                                    <td style="padding: 12px 10px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $t['avatar'] }}" alt="{{ $t['team_name'] }}" style="width: 34px; height: 34px; border-radius: 8px; object-fit: cover;">
                                            <strong style="color: #0f172a;">{{ $t['team_name'] }}</strong>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 10px; color: #64748b;">{{ $t['leader'] }}</td>
                                    <td style="padding: 12px 10px; color: #64748b;">{{ $t['members'] }} Creators</td>
                                    <td style="padding: 12px 10px; text-align: right; color: #10b981; font-weight: 800; font-size: 1.05rem;">
                                        ₹{{ number_format($t['total_volume']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
