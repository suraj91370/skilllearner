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

            <!-- 3. Revenue Metrics Grid (6 Cards Matching Image 1 & Image 2) -->
            <div class="dashboard-revenue-grid">
                <!-- Card 1: Today's Revenue (Blue) -->
                <div class="revenue-card card-today">
                    <div class="revenue-card-top">
                        <div class="revenue-amount">₹{{ number_format(session('user.today_earning', 0)) }}</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">Today's Revenue</div>
                    <div class="revenue-divider"></div>
                    <a href="#commissionSection" class="revenue-detail-link" onclick="document.getElementById('commissionSection')?.scrollIntoView({behavior: 'smooth'}); return false;">Click Here to View Details</a>
                </div>

                <!-- Card 2: 7 Days Revenue (Orange) -->
                <div class="revenue-card card-7days">
                    <div class="revenue-card-top">
                        <div class="revenue-amount">₹{{ number_format(session('user.weekly_earning', 120)) }}</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">7 Days Revenue</div>
                    <div class="revenue-divider"></div>
                    <a href="#commissionSection" class="revenue-detail-link" onclick="document.getElementById('commissionSection')?.scrollIntoView({behavior: 'smooth'}); return false;">Click Here to View Details</a>
                </div>

                <!-- Card 3: 30 Days Revenue (Red) -->
                <div class="revenue-card card-30days">
                    <div class="revenue-card-top">
                        <div class="revenue-amount">₹{{ number_format(session('user.monthly_earning', 1225)) }}</div>
                        <div class="revenue-icon-box">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">30 Days Revenue</div>
                    <div class="revenue-divider"></div>
                    <a href="#commissionSection" class="revenue-detail-link" onclick="document.getElementById('commissionSection')?.scrollIntoView({behavior: 'smooth'}); return false;">Click Here to View Details</a>
                </div>

                <!-- Card 4: All Time Revenue (Purple) -->
                <div class="revenue-card card-alltime">
                    <div class="revenue-card-top">
                        <div class="revenue-amount">₹{{ number_format(session('user.total_earning', 82084)) }}</div>
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
                    <div class="revenue-divider"></div>
                    <a href="#commissionSection" class="revenue-detail-link" onclick="document.getElementById('commissionSection')?.scrollIntoView({behavior: 'smooth'}); return false;">Click Here to View Details</a>
                </div>

                <!-- Card 5: All Time Passive (Magenta/Pink - User Requested Passive Income) -->
                <div class="revenue-card card-passive">
                    <div class="revenue-card-top">
                        <div class="revenue-amount">₹{{ number_format(session('user.passive_earning', 2771)) }}</div>
                        <div class="revenue-icon-box">
                            <svg width="28" height="28" viewBox="0 0 28 28">
                                <circle cx="14" cy="14" r="13" fill="#ffffff" />
                                <path d="M11 8l6 6-6 6" stroke="#db2777" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">All Time Passive</div>
                    <div class="revenue-divider"></div>
                    <a href="#commissionSection" class="revenue-detail-link" onclick="document.getElementById('commissionSection')?.scrollIntoView({behavior: 'smooth'}); return false;">Click Here to View Details</a>
                </div>

                <!-- Card 6: Industry Revenue (Project Emerald Teal #05B396) -->
                <div class="revenue-card card-industry">
                    <div class="revenue-card-top">
                        <div class="revenue-amount">₹{{ number_format(session('user.industry_revenue', 427539)) }}</div>
                        <div class="revenue-icon-box">
                            <svg width="28" height="28" viewBox="0 0 28 28">
                                <circle cx="14" cy="14" r="13" fill="#ffffff" />
                                <path d="M11 8l6 6-6 6" stroke="#05B396" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                        </div>
                    </div>
                    <div class="revenue-label">Industry Revenue</div>
                    <div class="revenue-divider"></div>
                    <a href="#commissionSection" class="revenue-detail-link" onclick="document.getElementById('commissionSection')?.scrollIntoView({behavior: 'smooth'}); return false;">Click Here to View Details</a>
                </div>
            </div>

            <!-- 4. 7 Days Sales Graph (Matches Image 2 with Project Teal #05B396) -->
            <div class="dashboard-graph-card">
                <h3 class="graph-card-title">7 Days Sales Graph</h3>
                <div class="graph-svg-wrapper">
                    <svg class="graph-svg" viewBox="0 0 820 330" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="salesGraphGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#05B396" stop-opacity="0.22"/>
                                <stop offset="100%" stop-color="#05B396" stop-opacity="0.01"/>
                            </linearGradient>
                        </defs>

                        <!-- Horizontal Grid Lines & Y-Axis Labels -->
                        <!-- ₹100: y = 35 -->
                        <text x="45" y="39" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹100</text>
                        <line x1="55" y1="35" x2="800" y2="35" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹90: y = 61 -->
                        <text x="45" y="65" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹90</text>
                        <line x1="55" y1="61" x2="800" y2="61" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹80: y = 87 -->
                        <text x="45" y="91" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹80</text>
                        <line x1="55" y1="87" x2="800" y2="87" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹70: y = 113 -->
                        <text x="45" y="117" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹70</text>
                        <line x1="55" y1="113" x2="800" y2="113" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹60: y = 139 -->
                        <text x="45" y="143" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹60</text>
                        <line x1="55" y1="139" x2="800" y2="139" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹50: y = 165 -->
                        <text x="45" y="169" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹50</text>
                        <line x1="55" y1="165" x2="800" y2="165" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹40: y = 191 -->
                        <text x="45" y="195" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹40</text>
                        <line x1="55" y1="191" x2="800" y2="191" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹30: y = 217 -->
                        <text x="45" y="221" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹30</text>
                        <line x1="55" y1="217" x2="800" y2="217" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹20: y = 243 -->
                        <text x="45" y="247" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹20</text>
                        <line x1="55" y1="243" x2="800" y2="243" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- ₹10: y = 269 -->
                        <text x="45" y="273" text-anchor="end" fill="#64748b" font-size="12" font-weight="600">₹10</text>
                        <line x1="55" y1="269" x2="800" y2="269" stroke="#e9eff5" stroke-width="1.1"/>

                        <!-- Baseline: y = 295 -->
                        <text x="45" y="298" text-anchor="end" fill="#94a3b8" font-size="12" font-weight="600">₹0</text>
                        <line x1="55" y1="295" x2="800" y2="295" stroke="#cbd5e1" stroke-width="1.4"/>

                        <!-- Vertical Day Grid Lines -->
                        <!-- 7 Days x positions: 75, 195, 315, 435, 555, 675, 795 -->
                        <line x1="75" y1="35" x2="75" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                        <line x1="195" y1="35" x2="195" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                        <line x1="315" y1="35" x2="315" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                        <line x1="435" y1="35" x2="435" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                        <line x1="555" y1="35" x2="555" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                        <line x1="675" y1="35" x2="675" y2="295" stroke="#edf2f7" stroke-width="1.1"/>
                        <line x1="795" y1="35" x2="795" y2="295" stroke="#edf2f7" stroke-width="1.1"/>

                        <!-- Area under curve fill -->
                        <polygon points="75,269 195,165 315,35 435,139 555,243 675,269 795,269 795,295 75,295" fill="url(#salesGraphGrad)"/>

                        <!-- Sales Trend Line in Theme Teal #05B396 -->
                        <polyline points="75,269 195,165 315,35 435,139 555,243 675,269 795,269" fill="none" stroke="#05B396" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>

                        <!-- Data Point Markers -->
                        <circle cx="75" cy="269" r="5.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 1: ₹10</title>
                        </circle>
                        <circle cx="195" cy="165" r="5.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 2: ₹50</title>
                        </circle>
                        <circle cx="315" cy="35" r="6.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 3: ₹100 (Peak)</title>
                        </circle>
                        <circle cx="435" cy="139" r="5.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 4: ₹60</title>
                        </circle>
                        <circle cx="555" cy="243" r="5.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 5: ₹20</title>
                        </circle>
                        <circle cx="675" cy="269" r="5.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 6: ₹10</title>
                        </circle>
                        <circle cx="795" cy="269" r="5.5" fill="#05B396" stroke="#ffffff" stroke-width="2.5" class="graph-point">
                            <title>Day 7: ₹10</title>
                        </circle>

                        <!-- X-Axis Day Labels -->
                        <text x="75" y="318" text-anchor="middle" fill="#64748b" font-size="12" font-weight="700">Day 1</text>
                        <text x="195" y="318" text-anchor="middle" fill="#64748b" font-size="12" font-weight="700">Day 2</text>
                        <text x="315" y="318" text-anchor="middle" fill="#05B396" font-size="12" font-weight="800">Day 3</text>
                        <text x="435" y="318" text-anchor="middle" fill="#64748b" font-size="12" font-weight="700">Day 4</text>
                        <text x="555" y="318" text-anchor="middle" fill="#64748b" font-size="12" font-weight="700">Day 5</text>
                        <text x="675" y="318" text-anchor="middle" fill="#64748b" font-size="12" font-weight="700">Day 6</text>
                        <text x="795" y="318" text-anchor="middle" fill="#64748b" font-size="12" font-weight="700">Day 7</text>
                    </svg>
                </div>
            </div>

            <!-- Personal Referral Link -->
            <div class="portal-box-card" style="border: 1.5px solid #a7f3d0; background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem; flex-wrap: wrap; gap: 8px;">
                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #064e3b; margin: 0;">🌟 Your Common All-Packages Referral Link</h4>
                    <a href="{{ url('/affiliate-link') }}" style="font-size: 0.82rem; font-weight: 700; color: #05B396; text-decoration: underline;">
                        Need individual package links? Click here ➔
                    </a>
                </div>
                <p style="color: #475569; font-size: 0.88rem; margin-bottom: 1rem;">
                    Jab aap ye Common Link share karenge, to buyer ke samne <strong>sabhi 5 packages</strong> khulenge aur wo koi bhi package purchase kar sakta hai.
                </p>
                <div class="referral-box-row">
                    <input type="text" id="portalAffiliateLink" style="flex: 1; padding: 0.75rem 1rem; border: 1.5px solid #a7f3d0; border-radius: 8px; font-size: 0.92rem; background: #ffffff; color: #065f46; font-weight: 700;" value="{{ url('/plans') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}" readonly>
                    <button type="button" onclick="copyPortalLink()" class="btn btn-primary" style="background: #05B396; color: #fff; padding: 0.75rem 1.4rem; font-weight: 700; border-radius: 8px; white-space: nowrap;">Copy Common Link</button>
                    <a href="{{ url('/affiliate-link') }}" class="btn" style="background: #ffffff; border: 1.5px solid #a7f3d0; color: #047857; font-size: 0.86rem; font-weight: 700; padding: 0.75rem 1.1rem; border-radius: 8px; text-decoration: none; white-space: nowrap;">
                        🎯 All 5 Package Links ➔
                    </a>
                </div>
            </div>

            <!-- Commission Table -->
            <div class="portal-box-card" id="commissionSection">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.2rem;">👥 Real-Time Commission Log</h4>
                <div class="table-responsive-wrapper">
                    <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left; width: 100%;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Enrolled Student</th>
                                <th style="padding: 10px;">Package</th>
                                <th style="padding: 10px;">Your Profit</th>
                                <th style="padding: 10px;">Type</th>
                                <th style="padding: 10px;">Time</th>
                                <th style="padding: 10px;">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commissions as $comm)
                                @php
                                    $isPassive = str_contains(strtolower($comm['type'] ?? ''), 'passive');
                                    $isPending = str_contains(strtolower($comm['status'] ?? ''), 'pending');
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                    <td style="padding: 12px 10px;"><strong>{{ $comm['name'] }}</strong></td>
                                    <td style="padding: 12px 10px;">{{ $comm['package'] }}</td>
                                    <td style="padding: 12px 10px; font-weight: 700; color: {{ $isPending ? '#d97706' : ($isPassive ? '#7c3aed' : '#10b981') }};">
                                        {{ $isPending ? '₹' . number_format($comm['amount']) . ' (Pending)' : '+₹' . number_format($comm['amount']) }}
                                    </td>
                                    <td style="padding: 12px 10px;">
                                        <span style="background: {{ $isPassive ? '#ede9fe' : '#ccfbf1' }}; color: {{ $isPassive ? '#6d28d9' : '#048873' }}; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
                                            {{ $isPassive ? 'Team Referral' : 'Direct Referral' }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 10px; color: #64748b; font-size: 0.82rem;">{{ $comm['time'] }}</td>
                                    <td style="padding: 12px 10px;">
                                        @if($isPending)
                                            <span style="background: #fef3c7; color: #b45309; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 800; border: 1px solid #fde68a;">
                                                ⏳ Pending (Verifying Payment)
                                            </span>
                                        @else
                                            <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 800; border: 1px solid #bbf7d0;">
                                                ● Credited (In Wallet)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem 1rem; color: #94a3b8;">
                                        No commissions recorded yet. Share your referral link to start earning!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function copyPortalLink() {
        const input = document.getElementById('portalAffiliateLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Referral Link Copied to Clipboard!\n' + input.value);
            });
        }
    }
</script>
@endpush
@endsection
