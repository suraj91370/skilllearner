@extends('layouts.app')

@section('title', 'Leaderboard — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'leaderboard'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'leaderboard'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">🏆 National Affiliate Leaderboard</h3>
                        <p style="color: #64748b; font-size: 0.92rem;">Real-time all-India student affiliate rankings updated automatically every 6 hours.</p>
                    </div>
                    <a href="{{ url('/team-leaderboard') }}" class="btn btn-secondary" style="border: 1px solid #a7f3d0; color: #05B396; font-weight: 700;">
                        View Team Rankings ➔
                    </a>
                </div>

                <div class="table-responsive-wrapper">
                    <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left; width: 100%;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Rank</th>
                                <th style="padding: 10px;">Affiliate Creator</th>
                                <th style="padding: 10px;">Active Tier</th>
                                <th style="padding: 10px;">State</th>
                                <th style="padding: 10px; text-align: right;">Total Verified Commissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topEarners as $e)
                                <tr style="border-bottom: 1px solid #f1f5f9; {{ !empty($e['is_current_user']) ? 'background: #f0fdfa; font-weight: 700;' : '' }}">
                                    <td style="padding: 12px 10px;">
                                        @if ($e['rank'] === 1)
                                            <span style="background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.8rem;">🥇 #1</span>
                                        @elseif ($e['rank'] === 2)
                                            <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.8rem;">🥈 #2</span>
                                        @elseif ($e['rank'] === 3)
                                            <span style="background: #ffedd5; color: #c2410c; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.8rem;">🥉 #3</span>
                                        @else
                                            <span style="color: #64748b; font-weight: 700; padding-left: 6px;">#{{ $e['rank'] }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 10px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $e['avatar'] }}" alt="{{ $e['name'] }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                            <strong style="color: #0f172a;">{{ $e['name'] }}</strong>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 10px; color: #64748b;">{{ $e['package'] }}</td>
                                    <td style="padding: 12px 10px; color: #64748b;">{{ $e['state'] }}</td>
                                    <td style="padding: 12px 10px; text-align: right; color: #10b981; font-weight: 800; font-size: 1.05rem;">
                                        ₹{{ number_format($e['earnings']) }}
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
