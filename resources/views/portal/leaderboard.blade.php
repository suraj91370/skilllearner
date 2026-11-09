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
            <div style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin: 0;">Leaderboard</h2>
            </div>

            @php
                $boards = [
                    ['key' => 'today', 'title' => "TODAY'S LEADERBOARD", 'data' => $dailyLeaderboard ?? []],
                    ['key' => '7days', 'title' => "7 DAYS LEADERBOARD", 'data' => $weeklyLeaderboard ?? []],
                    ['key' => '30days', 'title' => "30 DAYS LEADERBOARD", 'data' => $monthlyLeaderboard ?? []],
                    ['key' => 'alltime', 'title' => "ALL TIME LEADERBOARD", 'data' => $allTimeLeaderboard ?? []],
                ];
            @endphp

            <!-- 4 Leaderboards in 2x2 Grid (Responsive to 1 column on mobile) -->
            <div class="leaderboard-dual-grid">
                @foreach($boards as $board)
                    @php
                        $data = collect($board['data']);
                        $rank1 = $data->firstWhere('rank', 1);
                        $rank2 = $data->firstWhere('rank', 2);
                        $rank3 = $data->firstWhere('rank', 3);
                        $rest  = $data->where('rank', '>', 3);
                        $key   = $board['key'];
                    @endphp

                    <div class="leaderboard-podium-card">
                        <h3 class="leaderboard-podium-title">{{ $board['title'] }}</h3>

                        @if($data->isEmpty())
                            <div style="padding: 3rem 1rem; text-align: center; color: #94a3b8;">
                                <div style="font-size: 2.5rem; margin-bottom: 0.5rem; opacity: 0.7;">🏆</div>
                                <div style="font-weight: 700; color: #e2e8f0; font-size: 1.05rem; margin-bottom: 0.35rem;">No Earners Yet</div>
                                <div style="font-size: 0.85rem; color: #94a3b8;">Rankings will appear as affiliate sales and commissions are earned.</div>
                            </div>
                        @else
                            <!-- Top 3 Podium (2nd, 1st, 3rd) -->
                            <div class="podium-stage-wrap">
                                <!-- 2nd Place -->
                                @if($rank2)
                                <div class="podium-col rank-2nd">
                                    <div class="crown-wrapper">
                                        <svg class="crown-icon crown-silver" viewBox="0 0 54 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="silverGrad_{{ $key }}" x1="0" y1="0" x2="1" y2="1">
                                                    <stop offset="0%" stop-color="#e2e8f0"/>
                                                    <stop offset="50%" stop-color="#cbd5e1"/>
                                                    <stop offset="100%" stop-color="#94a3b8"/>
                                                </linearGradient>
                                            </defs>
                                            <path d="M5 34 L12 12 L22 23 L27 6 L32 23 L42 12 L49 34 Z" fill="url(#silverGrad_{{ $key }})"/>
                                            <rect x="3" y="33" width="48" height="6" rx="3" fill="url(#silverGrad_{{ $key }})"/>
                                            <circle cx="27" cy="6" r="3" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                            <circle cx="12" cy="12" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                            <circle cx="42" cy="12" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                            <circle cx="17" cy="36" r="1.8" fill="#0284c7"/>
                                            <circle cx="27" cy="36" r="2" fill="#0284c7"/>
                                            <circle cx="37" cy="36" r="1.8" fill="#0284c7"/>
                                        </svg>
                                    </div>
                                    <div class="podium-avatar-wrap">
                                        <img src="{{ $rank2['avatar'] }}" alt="{{ $rank2['name'] }}" class="podium-avatar-img">
                                        <span class="podium-rank-pill">2nd</span>
                                    </div>
                                    <span class="podium-name-pill" title="{{ $rank2['name'] }}">{{ $rank2['name'] }}</span>
                                    <div class="podium-amount">₹{{ number_format((float) $rank2['earnings']) }}</div>
                                </div>
                                @endif

                                <!-- 1st Place (Center - Elevated Champion) -->
                                @if($rank1)
                                <div class="podium-col rank-1st">
                                    <div class="crown-wrapper">
                                        <svg class="crown-icon crown-gold" viewBox="0 0 64 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="goldGrad_{{ $key }}" x1="0" y1="0" x2="1" y2="1">
                                                    <stop offset="0%" stop-color="#ffe259"/>
                                                    <stop offset="50%" stop-color="#ffa751"/>
                                                    <stop offset="100%" stop-color="#d47a16"/>
                                                </linearGradient>
                                                <filter id="crownGlow_{{ $key }}" x="-20%" y="-20%" width="140%" height="140%">
                                                    <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#ffa751" flood-opacity="0.5"/>
                                                </filter>
                                            </defs>
                                            <path d="M6 38 L14 14 L26 26 L32 6 L38 26 L50 14 L58 38 Z" fill="url(#goldGrad_{{ $key }})" filter="url(#crownGlow_{{ $key }})"/>
                                            <rect x="4" y="37" width="56" height="7" rx="3.5" fill="url(#goldGrad_{{ $key }})"/>
                                            <circle cx="32" cy="6" r="3.5" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                            <circle cx="14" cy="14" r="3" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                            <circle cx="50" cy="14" r="3" fill="#ffffff" stroke="#eab308" stroke-width="1"/>
                                            <circle cx="20" cy="40.5" r="2" fill="#ef4444"/>
                                            <circle cx="32" cy="40.5" r="2.5" fill="#3b82f6"/>
                                            <circle cx="44" cy="40.5" r="2" fill="#ef4444"/>
                                        </svg>
                                    </div>
                                    <div class="podium-avatar-wrap">
                                        <img src="{{ $rank1['avatar'] }}" alt="{{ $rank1['name'] }}" class="podium-avatar-img">
                                        <span class="podium-rank-pill">1st</span>
                                    </div>
                                    <span class="podium-name-pill" title="{{ $rank1['name'] }}">{{ $rank1['name'] }}</span>
                                    <div class="podium-amount">₹{{ number_format((float) $rank1['earnings']) }}</div>
                                </div>
                                @endif

                                <!-- 3rd Place -->
                                @if($rank3)
                                <div class="podium-col rank-3rd">
                                    <div class="crown-wrapper">
                                        <svg class="crown-icon crown-bronze" viewBox="0 0 54 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="bronzeGrad_{{ $key }}" x1="0" y1="0" x2="1" y2="1">
                                                    <stop offset="0%" stop-color="#f5d0fe"/>
                                                    <stop offset="50%" stop-color="#d8b4fe"/>
                                                    <stop offset="100%" stop-color="#c084fc"/>
                                                </linearGradient>
                                            </defs>
                                            <path d="M5 34 L12 12 L22 23 L27 6 L32 23 L42 12 L49 34 Z" fill="url(#bronzeGrad_{{ $key }})"/>
                                            <rect x="3" y="33" width="48" height="6" rx="3" fill="url(#bronzeGrad_{{ $key }})"/>
                                            <circle cx="27" cy="6" r="3" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                            <circle cx="12" cy="12" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                            <circle cx="42" cy="12" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                            <circle cx="17" cy="36" r="1.8" fill="#9333ea"/>
                                            <circle cx="27" cy="36" r="2" fill="#9333ea"/>
                                            <circle cx="37" cy="36" r="1.8" fill="#9333ea"/>
                                        </svg>
                                    </div>
                                    <div class="podium-avatar-wrap">
                                        <img src="{{ $rank3['avatar'] }}" alt="{{ $rank3['name'] }}" class="podium-avatar-img">
                                        <span class="podium-rank-pill">3rd</span>
                                    </div>
                                    <span class="podium-name-pill" title="{{ $rank3['name'] }}">{{ $rank3['name'] }}</span>
                                    <div class="podium-amount">₹{{ number_format((float) $rank3['earnings']) }}</div>
                                </div>
                                @endif
                            </div>

                            <!-- Rank Rows (4, 5, 6, etc.) -->
                            @if($rest->isNotEmpty())
                            <div class="podium-rows-list">
                                @foreach($rest as $item)
                                <div class="podium-row-card">
                                    <div class="podium-row-left">
                                        <span class="podium-row-rank-num">{{ $item['rank'] }}</span>
                                        <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="podium-row-avatar">
                                        <span class="podium-row-name">{{ $item['name'] }}</span>
                                    </div>
                                    <div class="podium-row-amount">₹ {{ number_format((float) $item['earnings']) }}</div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
