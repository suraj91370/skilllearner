@extends('layouts.app')

@section('title', 'Affiliate Command Center — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'dashboard'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'dashboard'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.95rem 1.2rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.95rem; font-weight: 700; box-shadow: 0 2px 10px rgba(5, 179, 150, 0.1);">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $hour = (int) date('G');
                if ($hour >= 5 && $hour < 12) {
                    $greeting = 'Good Morning';
                } elseif ($hour >= 12 && $hour < 17) {
                    $greeting = 'Good Afternoon';
                } else {
                    $greeting = 'Good Evening';
                }
                $userName = session('user.name', 'Adarsh Pandey');
                $activePackage = session('user.active_package', 'Finance Pro Package');
                $userAvatar = session('user.avatar', 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=160&auto=format&fit=crop&q=80');
            @endphp

            <!-- 1. Top Greeting Bar (Matches Screenshot) -->
            <div class="dashboard-greeting-bar">
                <div class="greeting-bar-left">
                    <span class="greeting-bar-accent"></span>
                    <span class="greeting-bar-title">{{ $greeting }}, {{ $userName }} !</span>
                </div>
                <button type="button" class="greeting-refresh-btn" onclick="window.location.reload();" title="Refresh Dashboard" aria-label="Refresh">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                    </svg>
                </button>
            </div>

            <!-- 2. Profile Hero Banner with Center Avatar & Abstract Wave Ribbons (Matches Screenshot) -->
            <div class="dashboard-profile-banner">
                <!-- Left Vector Waves / Ribbons -->
                <svg class="profile-banner-decor-left" viewBox="0 0 320 200" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M-20 -20 L160 -20 L70 220 L-20 220 Z" fill="#00137a" fill-opacity="0.08"/>
                    <path d="M-10 40 L190 -10 L110 210 L-10 210 Z" fill="#05B396" fill-opacity="0.12"/>
                    <path d="M0 110 L130 50 L80 200 L0 200 Z" fill="#00137a" fill-opacity="0.18"/>
                    <path d="M-20 180 C 60 160, 100 80, 220 70 C 260 67, 300 90, 320 100" stroke="#05B396" stroke-width="1.5" stroke-opacity="0.35" fill="none"/>
                    <path d="M-20 190 C 80 180, 120 100, 240 85 C 280 80, 310 105, 330 115" stroke="#00137a" stroke-width="1.5" stroke-opacity="0.25" fill="none"/>
                    <polygon points="-20,-20 95,-20 -20,130" fill="url(#decorGradLeft)" fill-opacity="0.85" />
                    <defs>
                        <linearGradient id="decorGradLeft" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#00137a"/>
                            <stop offset="100%" stop-color="#05B396"/>
                        </linearGradient>
                    </defs>
                </svg>

                <!-- Center Profile Content -->
                <div class="profile-hero-center">
                    <div class="profile-hero-avatar-wrap">
                        <img src="{{ $userAvatar }}" alt="{{ $userName }}" class="profile-hero-avatar-img">
                    </div>
                    <h3 class="profile-hero-name">{{ $userName }}</h3>
                    <span class="profile-hero-badge">{{ $activePackage }}</span>
                </div>

                <!-- Right Vector Waves / Ribbons -->
                <svg class="profile-banner-decor-right" viewBox="0 0 320 200" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M340 -20 L160 -20 L250 220 L340 220 Z" fill="#05B396" fill-opacity="0.08"/>
                    <path d="M330 40 L130 -10 L210 210 L330 210 Z" fill="#00137a" fill-opacity="0.12"/>
                    <path d="M320 110 L190 50 L240 200 L320 200 Z" fill="#05B396" fill-opacity="0.18"/>
                    <path d="M340 180 C 260 160, 220 80, 100 70 C 60 67, 20 90, 0 100" stroke="#05B396" stroke-width="1.5" stroke-opacity="0.35" fill="none"/>
                    <path d="M340 190 C 240 180, 200 100, 80 85 C 40 80, 10 105, -10 115" stroke="#00137a" stroke-width="1.5" stroke-opacity="0.25" fill="none"/>
                    <polygon points="340,-20 225,-20 340,130" fill="url(#decorGradRight)" fill-opacity="0.85" />
                    <defs>
                        <linearGradient id="decorGradRight" x1="1" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#05B396"/>
                            <stop offset="100%" stop-color="#00137a"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- 3. Revenue Metrics Grid (6 Cards Matching User Request - No View Details, 100% Dynamic) -->
            <div class="dashboard-revenue-grid">
                <!-- Card 1: Today's Revenue (Blue) -->
                <div class="revenue-card card-today">
                    <div class="revenue-card-top">
                        <div class="revenue-amount counter-anim" data-target="{{ (float) ($todayEarning ?? session('user.today_earning', 0)) }}">₹0</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">Today's Revenue</div>
                </div>

                <!-- Card 2: 7 Days Revenue (Orange) -->
                <div class="revenue-card card-7days">
                    <div class="revenue-card-top">
                        <div class="revenue-amount counter-anim" data-target="{{ (float) ($weeklyEarning ?? session('user.weekly_earning', 0)) }}">₹0</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">7 Days Revenue</div>
                </div>

                <!-- Card 3: 30 Days Revenue (Red) -->
                <div class="revenue-card card-30days">
                    <div class="revenue-card-top">
                        <div class="revenue-amount counter-anim" data-target="{{ (float) ($monthlyEarning ?? session('user.monthly_earning', 0)) }}">₹0</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">30 Days Revenue</div>
                </div>

                <!-- Card 4: All Time Revenue (Purple) -->
                <div class="revenue-card card-alltime">
                    <div class="revenue-card-top">
                        <div class="revenue-amount counter-anim" data-target="{{ (float) ($totalEarning ?? session('user.total_earning', 0)) }}">₹0</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                <path d="M4 22h16"></path>
                                <path d="M10 14.66V17c0 .55-.45 1-1 1H8c-.55 0-1 .45-1 1v1h10v-1c0-.55-.45-1-1-1h-1c-.55 0-1-.45-1-1v-2.34"></path>
                                <path d="M6 4h12v7a6 6 0 0 1-12 0V4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">All Time Revenue</div>
                </div>

                <!-- Card 5: All Time Passive (Magenta/Pink) -->
                <div class="revenue-card card-passive">
                    <div class="revenue-card-top">
                        <div class="revenue-amount counter-anim" data-target="{{ (float) ($passiveEarning ?? session('user.passive_earning', 0)) }}">₹0</div>
                        <div class="revenue-icon-box">
                            <svg width="28" height="28" viewBox="0 0 28 28">
                                <circle cx="14" cy="14" r="13" fill="#ffffff" />
                                <path d="M11 8l6 6-6 6" stroke="#db2777" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">All Time Passive</div>
                </div>

                <!-- Card 6: Industry Revenue (Project Emerald Teal #05B396) -->
                <div class="revenue-card card-industry">
                    <div class="revenue-card-top">
                        <div class="revenue-amount counter-anim" data-target="{{ (float) ($industryRevenue ?? session('user.industry_revenue', 0)) }}">₹0</div>
                        <div class="revenue-icon-box">
                            <svg width="28" height="28" viewBox="0 0 28 28">
                                <circle cx="14" cy="14" r="13" fill="#ffffff" />
                                <path d="M11 8l6 6-6 6" stroke="#05B396" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">Industry Revenue</div>
                </div>
            </div>

            <!-- 4. Dynamic 7 Days Sales Graph (Real-time dynamic user earnings) -->
            <div class="dashboard-graph-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.1rem;">
                    <h3 class="graph-card-title" style="margin: 0;">7 Days Sales Graph</h3>
                    <div style="font-size: 0.88rem; font-weight: 700; color: #05B396; background: rgba(5, 179, 150, 0.1); padding: 5px 14px; border-radius: 20px;">
                        7 Days Total: ₹{{ number_format((float) ($weeklyEarning ?? 0)) }}
                    </div>
                </div>
                <div class="graph-svg-wrapper">
                    <svg class="graph-svg" viewBox="0 0 820 330" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="salesGraphGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#05B396" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#05B396" stop-opacity="0.01"/>
                            </linearGradient>
                        </defs>

                        <!-- Dynamic Horizontal Grid Lines & Y-Axis Labels -->
                        @if(isset($yAxisTicks))
                            @foreach ($yAxisTicks as $tick)
                            <text x="45" y="{{ $tick['y'] + 4 }}" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">{{ $tick['label'] }}</text>
                            <line x1="55" y1="{{ $tick['y'] }}" x2="800" y2="{{ $tick['y'] }}" stroke="{{ $tick['y'] == 295 ? '#cbd5e1' : '#e9eff5' }}" stroke-width="{{ $tick['y'] == 295 ? '1.4' : '1.1' }}"/>
                            @endforeach
                        @else
                            <text x="45" y="298" text-anchor="end" fill="#94a3b8" font-size="12" font-weight="600">₹0</text>
                            <line x1="55" y1="295" x2="800" y2="295" stroke="#cbd5e1" stroke-width="1.4"/>
                        @endif

                        <!-- Vertical Day Grid Lines -->
                        @if(isset($graphPoints))
                            @foreach ($graphPoints as $pt)
                            <line x1="{{ $pt['x'] }}" y1="35" x2="{{ $pt['x'] }}" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                            @endforeach

                            <!-- Area under curve fill -->
                            <polygon points="{{ $polygonPoints ?? '' }}" fill="url(#salesGraphGrad)"/>

                            <!-- Sales Trend Line in Theme Teal #05B396 -->
                            <polyline points="{{ $polylinePoints ?? '' }}" fill="none" stroke="#05B396" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>

                            <!-- Data Point Markers -->
                            @foreach ($graphPoints as $pt)
                            <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="{{ $pt['amount'] > 0 ? '6' : '4.5' }}" fill="#05B396" stroke="#ffffff" stroke-width="{{ $pt['amount'] > 0 ? '2.5' : '2' }}" class="graph-point">
                                <title>{{ $pt['day_name'] }} ({{ $pt['date'] }}): ₹{{ number_format($pt['amount']) }}</title>
                            </circle>
                            @endforeach

                            <!-- X-Axis Day Labels -->
                            @foreach ($graphPoints as $pt)
                            <text x="{{ $pt['x'] }}" y="318" text-anchor="middle" fill="{{ $pt['day_name'] === 'Today' ? '#05B396' : '#64748b' }}" font-size="12" font-weight="{{ $pt['day_name'] === 'Today' ? '800' : '700' }}">{{ $pt['day_name'] }}</text>
                            @endforeach
                        @endif
                    </svg>
                </div>
            </div>

            <!-- Simple Referral Link (Simplified without Clutter) -->
            <div class="portal-box-card" style="padding: 1.2rem 1.5rem; margin-bottom: 1.5rem; border-radius: 14px;">
                <div style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                    Referral Link
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <input type="text" id="portalAffiliateLink" value="{{ url('/plans') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}" readonly style="flex: 1; background: #eef2f6; border: 1.5px solid transparent; border-radius: 12px; padding: 0.85rem 1.15rem; font-size: 0.92rem; font-weight: 600; color: #334155; box-sizing: border-box; outline: none;">
                    <button type="button" onclick="copyPortalLink(this)" style="background: #181832; color: #ffffff; font-size: 0.88rem; font-weight: 700; padding: 0.8rem 1.8rem; border-radius: 24px; border: none; cursor: pointer; transition: all 0.2s ease; white-space: nowrap;">
                        Copy
                    </button>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function copyPortalLink(btn) {
        const input = document.getElementById('portalAffiliateLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                if (btn) {
                    const originalText = btn.innerText;
                    btn.innerText = 'Copied!';
                    btn.style.background = '#05B396';
                    setTimeout(() => {
                        btn.innerText = originalText;
                        btn.style.background = '#181832';
                    }, 2000);
                } else {
                    alert('✅ Referral Link Copied!\n' + input.value);
                }
            });
        }
    }

    // Number Count-Up Animation (Starts from 0 and increases smoothly to target total)
    function animateRevenueCounters() {
        const counters = document.querySelectorAll('.counter-anim');
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target')) || 0;
            if (target <= 0) {
                counter.innerText = '₹0';
                return;
            }

            const duration = 1600; // 1.6s smooth easing count-up
            let startTimestamp = null;

            function step(timestamp) {
                if (!startTimestamp) startTimestamp = timestamp;
                const elapsed = timestamp - startTimestamp;
                const progress = Math.min(elapsed / duration, 1);

                // Ease Out Quart: 1 - (1 - progress)^4
                const easeOutProgress = 1 - Math.pow(1 - progress, 4);
                const currentVal = Math.floor(easeOutProgress * target);

                counter.innerText = '₹' + currentVal.toLocaleString('en-US');

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    counter.innerText = '₹' + Math.round(target).toLocaleString('en-US');
                }
            }

            window.requestAnimationFrame(step);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', animateRevenueCounters);
    } else {
        animateRevenueCounters();
    }
</script>
@endpush
@endsection
