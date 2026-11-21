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
            <!-- Single Centered Leaderboard Module Wrapper -->
            <div class="lb-single-module-wrapper">
                
                <!-- Header with Title & Timeframe Tabs -->
                <div class="lb-top-bar">
                    <div>
                        <h2 class="lb-main-title">Affiliate Leaderboard</h2>
                        <p class="lb-main-subtitle">Live verified affiliate commission rankings.</p>
                    </div>

                    <!-- 4 Timeframe Switcher Tabs -->
                    <div class="lb-timeframe-tabs" role="tablist">
                        <button type="button" class="lb-tab-btn {{ $activeTab === 'today' ? 'active' : '' }}" data-tab="today" role="tab">
                            <span class="lb-tab-icon">📅</span> Today
                        </button>
                        <button type="button" class="lb-tab-btn {{ $activeTab === '7days' ? 'active' : '' }}" data-tab="7days" role="tab">
                            <span class="lb-tab-icon">⚡</span> 7 Days
                        </button>
                        <button type="button" class="lb-tab-btn {{ $activeTab === '30days' ? 'active' : '' }}" data-tab="30days" role="tab">
                            <span class="lb-tab-icon">🗓️</span> 30 Days
                        </button>
                        <button type="button" class="lb-tab-btn {{ $activeTab === 'alltime' ? 'active' : '' }}" data-tab="alltime" role="tab">
                            <span class="lb-tab-icon">🏆</span> All Time
                        </button>
                    </div>
                </div>

                <!-- ONLY ONE LEADERBOARD CARD ON SCREEN -->
                <div class="lb-theme-board" id="main-leaderboard-card">
                    @php
                        $data = collect($currentLeaderboard ?? []);
                        $count = $data->count();
                        $rank1 = $data->firstWhere('rank', 1);
                        $rank2 = $data->firstWhere('rank', 2);
                        $rank3 = $data->firstWhere('rank', 3);
                        $rest  = $data->where('rank', '>=', 4)->where('rank', '<=', 10);
                    @endphp

                    @if($count === 0)
                        <!-- Empty State if no real earners in this timeframe -->
                        <div class="lb-empty-stage">
                            <div class="lb-empty-trophy">🏆</div>
                            <div class="lb-empty-title">No Earners Yet For This Timeframe</div>
                            <div class="lb-empty-desc">Rankings update automatically as course sales and commissions are earned. Make a referral sale to claim the #1 spot!</div>
                        </div>
                    @else
                        <!-- Dynamic Podium: Shows only as many podium columns as real earners exist -->
                        <div class="lb-podium-wrap count-{{ min($count, 3) }}">
                            
                            <!-- 2nd Place (Shown only if at least 2 earners exist) -->
                            @if($rank2)
                            <div class="lb-podium-col rank-2nd">
                                <div class="lb-crown-box">
                                    <svg class="crown-svg" width="50" height="36" viewBox="0 0 50 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="silverCrownGrad" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#ffffff"/>
                                                <stop offset="50%" stop-color="#cbd5e1"/>
                                                <stop offset="100%" stop-color="#64748b"/>
                                            </linearGradient>
                                        </defs>
                                        <path d="M5 30 L11 11 L20 20 L25 5 L30 20 L39 11 L45 30 Z" fill="url(#silverCrownGrad)"/>
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
                                    <svg class="crown-svg crown-1st-svg" width="62" height="44" viewBox="0 0 60 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="goldCrownGrad" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#ffcc80"/>
                                                <stop offset="45%" stop-color="#ff9800"/>
                                                <stop offset="100%" stop-color="#e65100"/>
                                            </linearGradient>
                                        </defs>
                                        <path d="M6 35 L12 12 L24 24 L30 6 L36 24 L48 12 L54 35 Z" fill="url(#goldCrownGrad)"/>
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

                            <!-- 3rd Place (Shown only if at least 3 earners exist) -->
                            @if($rank3)
                            <div class="lb-podium-col rank-3rd">
                                <div class="lb-crown-box">
                                    <svg class="crown-svg" width="50" height="36" viewBox="0 0 50 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="silver3CrownGrad" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#ffffff"/>
                                                <stop offset="50%" stop-color="#cbd5e1"/>
                                                <stop offset="100%" stop-color="#64748b"/>
                                            </linearGradient>
                                        </defs>
                                        <path d="M5 30 L11 11 L20 20 L25 5 L30 20 L39 11 L45 30 Z" fill="url(#silver3CrownGrad)"/>
                                        <path d="M3 29 Q25 33 47 29 L45 33 Q25 37 5 33 Z" fill="#475569"/>
                                        <circle cx="25" cy="5" r="3" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                        <circle cx="11" cy="11" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                                        <circle cx="39" cy="11" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
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

                        <!-- Rank Rows List (Only shown if ranks > 3 exist) -->
                        @if($rest->isNotEmpty())
                        <div class="lb-rows-wrap">
                            @foreach($rest as $item)
                            <div class="lb-row-capsule {{ !empty($item['is_current_user']) ? 'is-self' : '' }}">
                                <div class="lb-row-left">
                                    <div class="lb-row-rank-num">{{ $item['rank'] }}</div>
                                    <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="lb-row-avatar">
                                    <span class="lb-row-name">
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
            </div>
        </main>
    </div>
</div>

<style>
    /* ==========================================================
       SINGLE MODULE LEADERBOARD (DYNAMIC & CLEAN 1-CARD ARCHITECTURE)
       ========================================================== */
    .lb-single-module-wrapper {
        max-width: 620px;
        margin: 0 auto;
        width: 100%;
    }

    .lb-top-bar {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .lb-main-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .lb-main-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin: 0.35rem 0 0;
    }

    /* Timeframe Selector Pill Tabs */
    .lb-timeframe-tabs {
        display: inline-flex;
        background: #e2e8f0;
        padding: 5px;
        border-radius: 9999px;
        gap: 4px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .lb-tab-btn {
        background: transparent;
        border: none;
        outline: none;
        padding: 8px 18px;
        border-radius: 9999px;
        font-size: 0.88rem;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.22s ease-in-out;
    }

    .lb-tab-btn:hover {
        color: #0f172a;
    }

    .lb-tab-btn.active {
        background: #010a56;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(1, 10, 86, 0.35);
    }

    /* THE SINGLE BLUE LEADERBOARD CARD */
    .lb-theme-board {
        background: linear-gradient(180deg, #010a56 0%, #001272 38%, #010b50 100%);
        border: 2px solid #1e3a8a;
        border-radius: 28px;
        padding: 34px 22px 28px;
        box-shadow: 0 20px 45px rgba(1, 10, 86, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        position: relative;
        overflow: hidden;
        min-height: 280px;
        transition: all 0.25s ease;
    }

    /* Top Podium */
    .lb-podium-wrap {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 16px;
        padding: 0.5rem 0.25rem 2rem;
        border-bottom: 1px solid rgba(30, 58, 138, 0.5);
        margin-bottom: 1.5rem;
    }

    .lb-podium-wrap.count-1 {
        justify-content: center;
    }

    .lb-podium-wrap.count-2 {
        justify-content: center;
        gap: 28px;
    }

    .lb-podium-wrap.count-3 {
        justify-content: space-around;
        gap: 10px;
    }

    .lb-podium-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        flex: 1;
        max-width: 170px;
        min-width: 0;
    }

    .lb-podium-col.rank-1st {
        transform: translateY(-16px);
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
        margin-bottom: 12px;
    }

    .lb-avatar-photo {
        border-radius: 50%;
        object-fit: cover;
        display: block;
        background: #001272;
    }

    /* Rank 1st Avatar */
    .rank-1st .lb-avatar-photo {
        width: 90px;
        height: 90px;
        border: 4px solid #ff5722;
        box-shadow: 0 0 22px rgba(255, 87, 34, 0.5);
    }

    /* Rank 2nd Avatar */
    .rank-2nd .lb-avatar-photo {
        width: 74px;
        height: 74px;
        border: 3.5px solid #00b0ff;
        box-shadow: 0 0 16px rgba(0, 176, 255, 0.4);
    }

    /* Rank 3rd Avatar */
    .rank-3rd .lb-avatar-photo {
        width: 74px;
        height: 74px;
        border: 3.5px solid #a855f7;
        box-shadow: 0 0 16px rgba(168, 85, 247, 0.4);
    }

    /* Overlapping Rank Badge (1st, 2nd, 3rd) */
    .lb-rank-badge {
        position: absolute;
        bottom: -7px;
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
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
        background: #ff5722;
        border: 2px solid #801800;
    }

    .badge-blue {
        width: 32px;
        height: 32px;
        font-size: 0.76rem;
        background: #0070f3;
        border: 2px solid #002288;
    }

    .badge-purple {
        width: 32px;
        height: 32px;
        font-size: 0.76rem;
        background: #9333ea;
        border: 2px solid #3b0764;
    }

    /* Name Capsule */
    .lb-name-capsule {
        background: #ffffff;
        color: #000000;
        font-size: 0.95rem;
        font-weight: 800;
        padding: 5px 16px;
        border-radius: 9999px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        max-width: 125px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        letter-spacing: -0.2px;
    }

    .rank-1st .lb-name-capsule {
        padding: 6px 20px;
        font-size: 1rem;
    }

    /* Amount Values */
    .lb-amount-val {
        font-weight: 900;
        margin-top: 6px;
        letter-spacing: -0.3px;
        white-space: nowrap;
    }

    .amount-orange {
        color: #ff7a00;
        font-size: 1.45rem;
        text-shadow: 0 2px 8px rgba(255, 122, 0, 0.35);
    }

    .amount-cyan {
        color: #00d2ff;
        font-size: 1.25rem;
        text-shadow: 0 2px 8px rgba(0, 210, 255, 0.35);
    }

    .amount-purple {
        color: #b388ff;
        font-size: 1.25rem;
        text-shadow: 0 2px 8px rgba(179, 136, 255, 0.35);
    }

    /* Rank 4 to 10 Rows */
    .lb-rows-wrap {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .lb-row-capsule {
        background: rgba(0, 24, 110, 0.5);
        border: 1.5px solid #1d4ed8;
        border-radius: 35px;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }

    .lb-row-capsule:hover {
        background: rgba(0, 34, 150, 0.7);
        border-color: #3b82f6;
        transform: scale(1.01);
    }

    .lb-row-capsule.is-self {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.15);
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.25);
    }

    .lb-row-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .lb-row-rank-num {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1.5px solid #00b0ff;
        background: #0070f3;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .lb-row-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #00b0ff;
        flex-shrink: 0;
        background: #020a56;
    }

    .lb-row-name {
        color: #ffffff;
        font-size: 1.05rem;
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
        font-size: 0.68rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 10px;
    }

    .lb-row-amount {
        color: #00e676;
        font-size: 1.25rem;
        font-weight: 900;
        white-space: nowrap;
        margin-left: 12px;
        flex-shrink: 0;
        letter-spacing: 0.4px;
        text-shadow: 0 2px 6px rgba(0, 230, 118, 0.35);
    }

    /* Empty State */
    .lb-empty-stage {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #ffffff;
    }

    .lb-empty-trophy {
        font-size: 3.5rem;
        margin-bottom: 0.75rem;
        filter: drop-shadow(0 4px 12px rgba(245, 158, 11, 0.4));
    }

    .lb-empty-title {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #ffffff;
    }

    .lb-empty-desc {
        font-size: 0.9rem;
        color: #94a3b8;
        max-width: 420px;
        margin: 0 auto;
        line-height: 1.5;
    }

    @media (max-width: 640px) {
        .lb-theme-board {
            padding: 26px 14px 20px;
            border-radius: 20px;
        }

        .lb-podium-wrap {
            gap: 6px;
            padding-bottom: 1.25rem;
        }

        .rank-1st .lb-avatar-photo {
            width: 74px;
            height: 74px;
        }

        .rank-2nd .lb-avatar-photo,
        .rank-3rd .lb-avatar-photo {
            width: 60px;
            height: 60px;
        }

        .lb-name-capsule {
            max-width: 85px;
            font-size: 0.8rem;
            padding: 4px 10px;
        }

        .amount-orange {
            font-size: 1.15rem;
        }

        .amount-cyan,
        .amount-purple {
            font-size: 1rem;
        }

        .lb-row-capsule {
            padding: 8px 12px;
            border-radius: 26px;
        }

        .lb-row-rank-num {
            width: 26px;
            height: 26px;
            font-size: 0.78rem;
        }

        .lb-row-avatar {
            width: 38px;
            height: 38px;
        }

        .lb-row-name {
            font-size: 0.92rem;
        }

        .lb-row-amount {
            font-size: 1.05rem;
        }

        .lb-tab-btn {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
    }
</style>

@include('portal.styles')

@push('scripts')
<script>
    (function () {
        // Dynamic Leaderboard data passed directly from server
        const allBoardsData = @json($leaderboards);
        let currentTab = '{{ $activeTab }}';

        const mainCard = document.getElementById('main-leaderboard-card');
        const tabButtons = document.querySelectorAll('.lb-tab-btn');

        // Crown SVGs
        const goldCrownSvg = `
            <svg class="crown-svg crown-1st-svg" width="62" height="44" viewBox="0 0 60 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="goldCrownGrad_dyn" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#ffcc80"/>
                        <stop offset="45%" stop-color="#ff9800"/>
                        <stop offset="100%" stop-color="#e65100"/>
                    </linearGradient>
                </defs>
                <path d="M6 35 L12 12 L24 24 L30 6 L36 24 L48 12 L54 35 Z" fill="url(#goldCrownGrad_dyn)"/>
                <path d="M4 34 Q30 38 56 34 L54 38 Q30 42 6 38 Z" fill="#bf360c"/>
                <circle cx="30" cy="6" r="3.5" fill="#ffffff" stroke="#ff9800" stroke-width="1.5"/>
                <circle cx="12" cy="12" r="3" fill="#ffffff" stroke="#ff9800" stroke-width="1.5"/>
                <circle cx="48" cy="12" r="3" fill="#ffffff" stroke="#ff9800" stroke-width="1.5"/>
                <circle cx="21" cy="35" r="1.8" fill="#d32f2f"/>
                <circle cx="30" cy="35.5" r="2.2" fill="#1976d2"/>
                <circle cx="39" cy="35" r="1.8" fill="#d32f2f"/>
            </svg>
        `;

        const silverCrownSvg = `
            <svg class="crown-svg" width="50" height="36" viewBox="0 0 50 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="silverCrownGrad_dyn" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#ffffff"/>
                        <stop offset="50%" stop-color="#cbd5e1"/>
                        <stop offset="100%" stop-color="#64748b"/>
                    </linearGradient>
                </defs>
                <path d="M5 30 L11 11 L20 20 L25 5 L30 20 L39 11 L45 30 Z" fill="url(#silverCrownGrad_dyn)"/>
                <path d="M3 29 Q25 33 47 29 L45 33 Q25 37 5 33 Z" fill="#475569"/>
                <circle cx="25" cy="5" r="3" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                <circle cx="11" cy="11" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
                <circle cx="39" cy="11" r="2.5" fill="#ffffff" stroke="#94a3b8" stroke-width="1"/>
            </svg>
        `;

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str || '';
            return div.innerHTML;
        }

        // Render the SINGLE CARD dynamically
        function renderSingleBoard(tabKey) {
            currentTab = tabKey;
            const data = allBoardsData[tabKey] || [];
            const count = data.length;

            if (count === 0) {
                mainCard.innerHTML = `
                    <div class="lb-empty-stage">
                        <div class="lb-empty-trophy">🏆</div>
                        <div class="lb-empty-title">No Earners Yet For This Timeframe</div>
                        <div class="lb-empty-desc">Rankings update automatically as course sales and commissions are earned. Make a referral sale to claim the #1 spot!</div>
                    </div>
                `;
                return;
            }

            const rank1 = data.find(i => i.rank === 1);
            const rank2 = data.find(i => i.rank === 2);
            const rank3 = data.find(i => i.rank === 3);
            const rest = data.filter(i => i.rank >= 4 && i.rank <= 10);

            let podiumHtml = `<div class="lb-podium-wrap count-${Math.min(count, 3)}">`;

            // 2nd Place (if exists)
            if (rank2) {
                podiumHtml += `
                    <div class="lb-podium-col rank-2nd">
                        <div class="lb-crown-box">${silverCrownSvg}</div>
                        <div class="lb-avatar-circle-wrap">
                            <img src="${escapeHtml(rank2.avatar)}" alt="${escapeHtml(rank2.name)}" class="lb-avatar-photo ring-cyan">
                            <div class="lb-rank-badge badge-blue">2nd</div>
                        </div>
                        <div class="lb-name-capsule" title="${escapeHtml(rank2.name)}">${escapeHtml(rank2.name)}</div>
                        <div class="lb-amount-val amount-cyan counter-anim" data-target="${rank2.earnings}">₹0</div>
                    </div>
                `;
            }

            // 1st Place (if exists)
            if (rank1) {
                podiumHtml += `
                    <div class="lb-podium-col rank-1st">
                        <div class="lb-crown-box">${goldCrownSvg}</div>
                        <div class="lb-avatar-circle-wrap">
                            <img src="${escapeHtml(rank1.avatar)}" alt="${escapeHtml(rank1.name)}" class="lb-avatar-photo ring-orange">
                            <div class="lb-rank-badge badge-orange">1st</div>
                        </div>
                        <div class="lb-name-capsule" title="${escapeHtml(rank1.name)}">${escapeHtml(rank1.name)}</div>
                        <div class="lb-amount-val amount-orange counter-anim" data-target="${rank1.earnings}">₹0</div>
                    </div>
                `;
            }

            // 3rd Place (if exists)
            if (rank3) {
                podiumHtml += `
                    <div class="lb-podium-col rank-3rd">
                        <div class="lb-crown-box">${silverCrownSvg}</div>
                        <div class="lb-avatar-circle-wrap">
                            <img src="${escapeHtml(rank3.avatar)}" alt="${escapeHtml(rank3.name)}" class="lb-avatar-photo ring-purple">
                            <div class="lb-rank-badge badge-purple">3rd</div>
                        </div>
                        <div class="lb-name-capsule" title="${escapeHtml(rank3.name)}">${escapeHtml(rank3.name)}</div>
                        <div class="lb-amount-val amount-purple counter-anim" data-target="${rank3.earnings}">₹0</div>
                    </div>
                `;
            }

            podiumHtml += `</div>`;

            // Ranks 4 to 10+
            let rowsHtml = '';
            if (rest.length > 0) {
                rowsHtml += `<div class="lb-rows-wrap">`;
                rest.forEach(item => {
                    const selfClass = item.is_current_user ? 'is-self' : '';
                    const selfBadge = item.is_current_user ? '<span class="lb-self-badge">YOU</span>' : '';
                    rowsHtml += `
                        <div class="lb-row-capsule ${selfClass}">
                            <div class="lb-row-left">
                                <div class="lb-row-rank-num">${item.rank}</div>
                                <img src="${escapeHtml(item.avatar)}" alt="${escapeHtml(item.name)}" class="lb-row-avatar">
                                <span class="lb-row-name">
                                    ${escapeHtml(item.name)}
                                    ${selfBadge}
                                </span>
                            </div>
                            <div class="lb-row-amount counter-anim" data-target="${item.earnings}">₹ 0</div>
                        </div>
                    `;
                });
                rowsHtml += `</div>`;
            }

            mainCard.innerHTML = podiumHtml + rowsHtml;
            animateLeaderboardCounters();
        }

        // Tab click listener
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const targetTab = this.getAttribute('data-tab');
                if (targetTab === currentTab) return;

                tabButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                renderSingleBoard(targetTab);

                // Update URL query param cleanly
                try {
                    const url = new URL(window.location);
                    url.searchParams.set('tab', targetTab);
                    window.history.replaceState({}, '', url);
                } catch (e) {}
            });
        });

        // Counter roll-up animation
        function animateLeaderboardCounters() {
            const counters = mainCard.querySelectorAll('.counter-anim');
            counters.forEach(counter => {
                const target = parseFloat(counter.getAttribute('data-target')) || 0;
                if (target <= 0) {
                    counter.innerText = counter.classList.contains('lb-row-amount') ? '₹ 0' : '₹0';
                    return;
                }

                const duration = 1000;
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

        // Initialize counter animation on initial server-rendered content
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', animateLeaderboardCounters);
        } else {
            animateLeaderboardCounters();
        }
    })();
</script>
@endpush
@endsection
