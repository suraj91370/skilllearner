@extends('layouts.app')

@section('title', 'Affiliate Leaderboard — SkillLearner')

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
            <!-- Header Section -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.85rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.5px;">
                        🏆 Affiliate Leaderboard
                    </h2>
                    <p style="font-size: 0.95rem; color: #64748b; margin: 0.35rem 0 0;">
                        Live verified affiliate commission rankings across all performance timeframes.
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ url('/portal/team-leaderboard') }}" class="btn" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        👥 Team Leaderboard
                    </a>
                </div>
            </div>

            @php
                $boards = [
                    ['key' => 'today', 'title' => "TODAY'S LEADERBOARD", 'icon' => '⚡', 'data' => $dailyLeaderboard ?? []],
                    ['key' => '7days', 'title' => '7 DAYS LEADERBOARD', 'icon' => '📅', 'data' => $weeklyLeaderboard ?? []],
                    ['key' => '30days', 'title' => '30 DAYS LEADERBOARD', 'icon' => '🗓️', 'data' => $monthlyLeaderboard ?? []],
                    ['key' => 'alltime', 'title' => 'ALL TIME LEADERBOARD', 'icon' => '🏆', 'data' => $allTimeLeaderboard ?? []],
                ];
            @endphp

            <!-- 4 Leaderboard Boards in 2x2 Grid (1 Column Responsive on Mobile) -->
            <div class="leaderboard-dual-grid">
                @foreach($boards as $board)
                    @php
                        $data  = collect($board['data']);
                        $count = $data->count();
                        $rank1 = $data->firstWhere('rank', 1);
                        $rank2 = $data->firstWhere('rank', 2);
                        $rank3 = $data->firstWhere('rank', 3);
                        $rest  = $data->where('rank', '>=', 4)->where('rank', '<=', 10);
                        $bKey  = $board['key'];
                    @endphp

                    <div class="lb-theme-board">
                        <!-- Board Header -->
                        <div class="lb-board-header">
                            {{-- <span class="lb-board-icon">{{ $board['icon'] }}</span> --}}
                            <h3 class="lb-board-title">{{ $board['title'] }}</h3>
                        </div>

                        @if($count === 0)
                            <!-- Empty State if no real earners in this timeframe -->
                            <div class="lb-empty-stage">
                                <div class="lb-empty-trophy">🏆</div>
                                <div class="lb-empty-title">No Earners Yet</div>
                                <div class="lb-empty-desc">Rankings update automatically as course sales and commissions are earned. Make a referral sale to claim the #1 spot!</div>
                            </div>
                        @else
                            <!-- Top 3 Dynamic Podium -->
                            <div class="lb-podium-wrap count-{{ min($count, 3) }}">
                                
                                <!-- 2nd Place (Left - Shown if at least 2 earners exist) -->
                                @if($rank2)
                                <div class="lb-podium-col rank-2nd">
                                    <div class="lb-crown-box">
                                        <svg class="crown-svg" width="46" height="34" viewBox="0 0 50 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="silverCrownGrad_{{ $bKey }}" x1="0" y1="0" x2="0" y2="1">
                                                    <stop offset="0%" stop-color="#ffffff"/>
                                                    <stop offset="50%" stop-color="#cbd5e1"/>
                                                    <stop offset="100%" stop-color="#64748b"/>
                                                </linearGradient>
                                            </defs>
                                            <path d="M5 30 L11 11 L20 20 L25 5 L30 20 L39 11 L45 30 Z" fill="url(#silverCrownGrad_{{ $bKey }})"/>
                                            <path d="M3 29 Q25 33 47 29 L45 33 Q25 37 5 33 Z" fill="#475569"/>
                                            <circle cx="25" cy="5" r="3" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                            <circle cx="11" cy="11" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                            <circle cx="39" cy="11" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                        </svg>
                                    </div>
                                    <div class="lb-avatar-circle-wrap">
                                        <img src="{{ $rank2['avatar'] }}" alt="{{ $rank2['name'] }}" class="lb-avatar-photo ring-cyan">
                                        <div class="lb-rank-badge badge-blue">2nd</div>
                                    </div>
                                    <div class="lb-name-capsule" title="{{ $rank2['name'] }}">
                                        {{ $rank2['name'] }}
                                    </div>
                                    <div class="lb-amount-val amount-cyan counter-anim" data-target="{{ (float) $rank2['earnings'] }}">
                                        ₹0
                                    </div>
                                </div>
                                @endif

                                <!-- 1st Place (Center - Always shown if at least 1 earner exists) -->
                                @if($rank1)
                                <div class="lb-podium-col rank-1st">
                                    <div class="lb-crown-box">
                                        <svg class="crown-svg crown-1st-svg" width="56" height="40" viewBox="0 0 60 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="goldCrownGrad_{{ $bKey }}" x1="0" y1="0" x2="0" y2="1">
                                                    <stop offset="0%" stop-color="#ffcc80"/>
                                                    <stop offset="45%" stop-color="#ff9800"/>
                                                    <stop offset="100%" stop-color="#e65100"/>
                                                </linearGradient>
                                            </defs>
                                            <path d="M6 35 L12 12 L24 24 L30 6 L36 24 L48 12 L54 35 Z" fill="url(#goldCrownGrad_{{ $bKey }})"/>
                                            <path d="M4 34 Q30 38 56 34 L54 38 Q30 42 6 38 Z" fill="#bf360c"/>
                                            <circle cx="30" cy="6" r="3.5" fill="#ffffff" stroke="#ff9800" stroke-width="1.5"/>
                                            <circle cx="12" cy="12" r="3" fill="#ffffff" stroke="#ff9800" stroke-width="1.5"/>
                                            <circle cx="48" cy="12" r="3" fill="#ffffff" stroke="#ff9800" stroke-width="1.5"/>
                                            <circle cx="21" cy="35" r="1.8" fill="#d32f2f"/>
                                            <circle cx="30" cy="35.5" r="2.2" fill="#1976d2"/>
                                            <circle cx="39" cy="35" r="1.8" fill="#d32f2f"/>
                                        </svg>
                                    </div>
                                    <div class="lb-avatar-circle-wrap">
                                        <img src="{{ $rank1['avatar'] }}" alt="{{ $rank1['name'] }}" class="lb-avatar-photo ring-orange">
                                        <div class="lb-rank-badge badge-orange">1st</div>
                                    </div>
                                    <div class="lb-name-capsule" title="{{ $rank1['name'] }}">
                                        {{ $rank1['name'] }}
                                    </div>
                                    <div class="lb-amount-val amount-orange counter-anim" data-target="{{ (float) $rank1['earnings'] }}">
                                        ₹0
                                    </div>
                                </div>
                                @endif

                                <!-- 3rd Place (Right - Shown if at least 3 earners exist) -->
                                @if($rank3)
                                <div class="lb-podium-col rank-3rd">
                                    <div class="lb-crown-box">
                                        <svg class="crown-svg" width="46" height="34" viewBox="0 0 50 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="purpleCrownGrad_{{ $bKey }}" x1="0" y1="0" x2="0" y2="1">
                                                    <stop offset="0%" stop-color="#f5d0fe"/>
                                                    <stop offset="50%" stop-color="#d8b4fe"/>
                                                    <stop offset="100%" stop-color="#9333ea"/>
                                                </linearGradient>
                                            </defs>
                                            <path d="M5 30 L11 11 L20 20 L25 5 L30 20 L39 11 L45 30 Z" fill="url(#purpleCrownGrad_{{ $bKey }})"/>
                                            <path d="M3 29 Q25 33 47 29 L45 33 Q25 37 5 33 Z" fill="#475569"/>
                                            <circle cx="25" cy="5" r="3" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                            <circle cx="11" cy="11" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                            <circle cx="39" cy="11" r="2.5" fill="#ffffff" stroke="#c084fc" stroke-width="1"/>
                                        </svg>
                                    </div>
                                    <div class="lb-avatar-circle-wrap">
                                        <img src="{{ $rank3['avatar'] }}" alt="{{ $rank3['name'] }}" class="lb-avatar-photo ring-purple">
                                        <div class="lb-rank-badge badge-purple">3rd</div>
                                    </div>
                                    <div class="lb-name-capsule" title="{{ $rank3['name'] }}">
                                        {{ $rank3['name'] }}
                                    </div>
                                    <div class="lb-amount-val amount-purple counter-anim" data-target="{{ (float) $rank3['earnings'] }}">
                                        ₹0
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Ranks 4 to 10 Rows (Dynamic list below podium, capped strictly at rank 10) -->
                            @if($rest->isNotEmpty())
                            <div class="lb-rows-wrap">
                                @foreach($rest as $item)
                                <div class="lb-row-capsule {{ !empty($item['is_current_user']) ? 'is-self' : '' }}">
                                    <div class="lb-row-left">
                                        <div class="lb-row-rank-num">{{ $item['rank'] }}</div>
                                        <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="lb-row-avatar">
                                        <span class="lb-row-name" title="{{ $item['name'] }}">
                                            {{ $item['name'] }}
                                            @if(!empty($item['is_current_user']))
                                                <span class="lb-self-badge">YOU</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="lb-row-amount counter-anim" data-target="{{ (float) $item['earnings'] }}">
                                        ₹ 0
                                    </div>
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

<style>
    /* ==========================================================
       4-BOARD 2X2 DUAL GRID LEADERBOARD (DYNAMIC TOP 10)
       ========================================================== */
    .leaderboard-dual-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        align-items: start;
        margin-top: 0.5rem;
    }

    @media (max-width: 992px) {
        .leaderboard-dual-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
    }

    /* BLUE LEADERBOARD CARD */
    .lb-theme-board {
        background: linear-gradient(180deg, #010a56 0%, #001272 38%, #010b50 100%);
        border: 2px solid #1e3a8a;
        border-radius: 24px;
        padding: 24px 18px 20px;
        box-shadow: 0 16px 40px rgba(1, 10, 86, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        position: relative;
        overflow: hidden;
        color: #ffffff;
        transition: all 0.25s ease;
    }

    /* Board Title Header */
    .lb-board-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 1.5rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .lb-board-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0;
        text-align: center;
    }

    .lb-board-icon {
        font-size: 1.2rem;
    }

    /* Top Podium */
    .lb-podium-wrap {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 10px;
        padding: 0.25rem 0.25rem 1.5rem;
        border-bottom: 1px solid rgba(30, 58, 138, 0.5);
        margin-bottom: 1.25rem;
    }

    .lb-podium-wrap.count-1 {
        justify-content: center;
    }

    .lb-podium-wrap.count-2 {
        justify-content: center;
        gap: 20px;
    }

    .lb-podium-wrap.count-3 {
        justify-content: space-around;
        gap: 8px;
    }

    .lb-podium-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        flex: 1;
        max-width: 150px;
        min-width: 0;
    }

    .lb-podium-col.rank-1st {
        transform: translateY(-14px);
        z-index: 3;
    }

    .lb-crown-box {
        margin-bottom: -4px;
        display: flex;
        justify-content: center;
        filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.4));
    }

    .crown-1st-svg {
        filter: drop-shadow(0 4px 10px rgba(255, 152, 0, 0.55));
    }

    .lb-avatar-circle-wrap {
        position: relative;
        display: inline-flex;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .lb-avatar-photo {
        border-radius: 50%;
        object-fit: cover;
        display: block;
        background: #001272;
    }

    /* Rank 1st Avatar */
    .rank-1st .lb-avatar-photo {
        width: 78px;
        height: 78px;
        border: 3.5px solid #ff5722;
        box-shadow: 0 0 18px rgba(255, 87, 34, 0.5);
    }

    /* Rank 2nd Avatar */
    .rank-2nd .lb-avatar-photo {
        width: 64px;
        height: 64px;
        border: 3px solid #00b0ff;
        box-shadow: 0 0 14px rgba(0, 176, 255, 0.4);
    }

    /* Rank 3rd Avatar */
    .rank-3rd .lb-avatar-photo {
        width: 64px;
        height: 64px;
        border: 3px solid #a855f7;
        box-shadow: 0 0 14px rgba(168, 85, 247, 0.4);
    }

    /* Overlapping Rank Badge (1st, 2nd, 3rd) */
    .lb-rank-badge {
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        color: #ffffff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.45);
        white-space: nowrap;
    }

    .badge-orange {
        width: 32px;
        height: 32px;
        font-size: 0.78rem;
        background: #ff5722;
        border: 2px solid #801800;
    }

    .badge-blue {
        width: 28px;
        height: 28px;
        font-size: 0.72rem;
        background: #0070f3;
        border: 2px solid #002288;
    }

    .badge-purple {
        width: 28px;
        height: 28px;
        font-size: 0.72rem;
        background: #9333ea;
        border: 2px solid #3b0764;
    }

    /* Name Capsule */
    .lb-name-capsule {
        background: #ffffff;
        color: #000000;
        font-size: 0.88rem;
        font-weight: 800;
        padding: 4px 14px;
        border-radius: 9999px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        max-width: 105px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        letter-spacing: -0.2px;
    }

    .rank-1st .lb-name-capsule {
        padding: 5px 16px;
        font-size: 0.92rem;
    }

    /* Amount Values */
    .lb-amount-val {
        font-weight: 900;
        margin-top: 5px;
        letter-spacing: -0.3px;
        white-space: nowrap;
    }

    .amount-orange {
        color: #ff7a00;
        font-size: 1.25rem;
        text-shadow: 0 2px 8px rgba(255, 122, 0, 0.35);
    }

    .amount-cyan {
        color: #00d2ff;
        font-size: 1.1rem;
        text-shadow: 0 2px 8px rgba(0, 210, 255, 0.35);
    }

    .amount-purple {
        color: #b388ff;
        font-size: 1.1rem;
        text-shadow: 0 2px 8px rgba(179, 136, 255, 0.35);
    }

    /* Rank 4 to 10 Rows (Capsule style matching attached screenshot) */
    .lb-rows-wrap {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .lb-row-capsule {
        background: rgba(0, 24, 110, 0.55);
        border: 1.5px solid #1d4ed8;
        border-radius: 9999px;
        padding: 8px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }

    .lb-row-capsule:hover {
        background: rgba(0, 34, 150, 0.75);
        border-color: #3b82f6;
        transform: translateY(-1px);
    }

    .lb-row-capsule.is-self {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.18);
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.25);
    }

    .lb-row-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .lb-row-rank-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1.5px solid #00b0ff;
        background: #0070f3;
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .lb-row-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #00b0ff;
        flex-shrink: 0;
        background: #020a56;
    }

    .lb-row-name {
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .lb-self-badge {
        background: #f59e0b;
        color: #000;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 8px;
    }

    .lb-row-amount {
        color: #00e676;
        font-size: 1.15rem;
        font-weight: 900;
        white-space: nowrap;
        margin-left: 10px;
        flex-shrink: 0;
        letter-spacing: 0.3px;
        text-shadow: 0 2px 6px rgba(0, 230, 118, 0.35);
    }

    /* Empty State */
    .lb-empty-stage {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #ffffff;
    }

    .lb-empty-trophy {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        filter: drop-shadow(0 4px 10px rgba(245, 158, 11, 0.4));
    }

    .lb-empty-title {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        color: #ffffff;
    }

    .lb-empty-desc {
        font-size: 0.84rem;
        color: #94a3b8;
        max-width: 360px;
        margin: 0 auto;
        line-height: 1.45;
    }

    @media (max-width: 640px) {
        .lb-theme-board {
            padding: 20px 12px 16px;
            border-radius: 18px;
        }

        .lb-podium-wrap {
            gap: 6px;
            padding-bottom: 1rem;
        }

        .rank-1st .lb-avatar-photo {
            width: 68px;
            height: 68px;
        }

        .rank-2nd .lb-avatar-photo,
        .rank-3rd .lb-avatar-photo {
            width: 56px;
            height: 56px;
        }

        .lb-name-capsule {
            max-width: 80px;
            font-size: 0.78rem;
            padding: 3px 8px;
        }

        .amount-orange {
            font-size: 1.1rem;
        }

        .amount-cyan,
        .amount-purple {
            font-size: 0.95rem;
        }

        .lb-row-capsule {
            padding: 7px 12px;
        }

        .lb-row-rank-num {
            width: 24px;
            height: 24px;
            font-size: 0.75rem;
        }

        .lb-row-avatar {
            width: 32px;
            height: 32px;
        }

        .lb-row-name {
            font-size: 0.88rem;
        }

        .lb-row-amount {
            font-size: 1rem;
        }
    }
</style>

@include('portal.styles')

@push('scripts')
<script>
    (function () {
        // Counter roll-up animation across all 4 leaderboards
        function animateLeaderboardCounters() {
            const counters = document.querySelectorAll('.counter-anim');
            counters.forEach(counter => {
                const target = parseFloat(counter.getAttribute('data-target')) || 0;
                if (target <= 0) {
                    counter.innerText = counter.classList.contains('lb-row-amount') ? '₹ 0' : '₹0';
                    return;
                }

                const duration = 1200; // 1.2s smooth count-up
                let startTimestamp = null;

                function step(timestamp) {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const elapsed = timestamp - startTimestamp;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOutProgress = 1 - Math.pow(1 - progress, 4);
                    const currentVal = Math.floor(easeOutProgress * target);

                    if (counter.classList.contains('lb-row-amount')) {
                        counter.innerText = '₹ ' + currentVal.toLocaleString('en-IN');
                    } else {
                        counter.innerText = '₹' + currentVal.toLocaleString('en-IN');
                    }

                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        if (counter.classList.contains('lb-row-amount')) {
                            counter.innerText = '₹ ' + Math.round(target).toLocaleString('en-IN');
                        } else {
                            counter.innerText = '₹' + Math.round(target).toLocaleString('en-IN');
                        }
                    }
                }

                window.requestAnimationFrame(step);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', animateLeaderboardCounters);
        } else {
            animateLeaderboardCounters();
        }
    })();
</script>
@endpush
@endsection
