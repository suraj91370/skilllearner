@extends('layouts.app')

@section('title', 'My Courses — CareerFixx')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider (Visible on Mobile/Tablet <= 992px) -->
    <div class="mobile-portal-nav">
        <div class="mobile-nav-header-row">
            <span class="mobile-nav-title">PORTAL TABS</span>
            <button type="button" onclick="window.openMobileMenu()" class="mobile-open-drawer-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                <span>All 15 Sections</span>
            </button>
        </div>
        <div class="mobile-tabs-scroll">
            <button onclick="switchPortalTab('courses')" id="m-tab-courses" class="m-portal-tab active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                <span>My Course</span>
            </button>
            <button onclick="switchPortalTab('dashboard')" id="m-tab-dashboard" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span>Dashboard</span>
            </button>
            <button onclick="switchPortalTab('profile')" id="m-tab-profile" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Profile</span>
            </button>
            <button onclick="switchPortalTab('community')" id="m-tab-community" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <span>Social Community</span>
            </button>
            <button onclick="switchPortalTab('kyc')" id="m-tab-kyc" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span>Kyc</span>
            </button>
            <button onclick="switchPortalTab('affiliate-link')" id="m-tab-affiliate-link" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <span>Affiliate Link</span>
            </button>
            <button onclick="switchPortalTab('tokens')" id="m-tab-tokens" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span>Token Purchases</span>
            </button>
            <button onclick="switchPortalTab('training')" id="m-tab-training" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span>Affiliate Training</span>
            </button>
            <a href="{{ url('/plans') }}" class="m-portal-tab" style="text-decoration: none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <span>Upgrade</span>
            </a>
            <button onclick="switchPortalTab('marketing')" id="m-tab-marketing" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                <span>Marketing Tool</span>
            </button>
            <button onclick="switchPortalTab('payout')" id="m-tab-payout" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <span>My Payout</span>
            </button>
            <button onclick="switchPortalTab('leaderboard')" id="m-tab-leaderboard" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                <span>Leaderboard</span>
            </button>
            <button onclick="switchPortalTab('team-leaderboard')" id="m-tab-team-leaderboard" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <span>Team Leaderboard</span>
            </button>
            <button onclick="switchPortalTab('qualification')" id="m-tab-qualification" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                <span>Qualification</span>
            </button>
            <button onclick="switchPortalTab('certificate')" id="m-tab-certificate" class="m-portal-tab">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                <span>Certificate</span>
            </button>
        </div>
    </div>

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        
        <!-- Left Sidebar Card (Matches Image 1 Exactly) -->
        <aside class="portal-sidebar-card">
            <nav class="portal-sidebar-nav">
                <a href="javascript:void(0)" onclick="switchPortalTab('courses')" id="tab-btn-courses" class="sidebar-item active">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                        <line x1="12" y1="18" x2="12.01" y2="18"></line>
                    </svg>
                    <span>My Course</span>
                </a>
                
                <a href="javascript:void(0)" onclick="switchPortalTab('dashboard')" id="tab-btn-dashboard" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('profile')" id="tab-btn-profile" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('community')" id="tab-btn-community" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Social Community</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('kyc')" id="tab-btn-kyc" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Kyc</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('affiliate-link')" id="tab-btn-affiliate-link" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    <span>Affiliate Link</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('tokens')" id="tab-btn-tokens" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span>Token Purchases</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('training')" id="tab-btn-training" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Affiliate Training</span>
                </a>

                <a href="{{ url('/plans') }}" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    <span>Upgrade</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('marketing')" id="tab-btn-marketing" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    <span>Marketing Tool</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('payout')" id="tab-btn-payout" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    <span>My Payout</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('leaderboard')" id="tab-btn-leaderboard" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Leaderboard</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('team-leaderboard')" id="tab-btn-team-leaderboard" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    <span>Team Leaderboard</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('qualification')" id="tab-btn-qualification" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <span>Qualification</span>
                </a>

                <a href="javascript:void(0)" onclick="switchPortalTab('certificate')" id="tab-btn-certificate" class="sidebar-item">
                    <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="7"></circle>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                    </svg>
                    <span>Certificate</span>
                </a>
            </nav>
        </aside>

        <!-- Right Content Panels Area -->
        <main class="portal-content-area">
            
            <!-- PANEL 1: MY COURSES (Default Active View - Matches Image 1) -->
            <section id="panel-courses" class="portal-tab-panel active">
                <div class="portal-greeting-row">
                    <h2 class="welcome-heading">Welcome <span class="highlight-user-name">{{ session('user.name', 'Vansh Tandon') }}</span> 👐</h2>
                </div>

                <!-- Enrolled / Active Filter Pills -->
                <div class="course-filter-pills">
                    <button class="filter-pill active" onclick="filterCourses('enrolled')">
                        Enrolled Courses <span class="pill-badge-num">(12)</span>
                    </button>
                    <button class="filter-pill" onclick="filterCourses('active')">
                        Active Courses <span class="pill-badge-num">(12)</span>
                    </button>
                </div>

                <!-- 12 Enrolled Courses Grid (4 Columns Desktop, Responsive Tablet & Mobile) -->
                <div class="courses-cards-grid">
                    @foreach ($courses as $c)
                        <div class="portal-course-card">
                            <a href="{{ url('/classroom') }}?course={{ $c['slug'] }}" class="card-thumb-link">
                                <div class="course-thumb-container" style="background: {{ $c['gradient'] }};">
                                    
                                    <!-- Neon Graphic & Banner Text -->
                                    <div class="thumb-neon-glow" style="background: radial-gradient(circle, {{ $c['accent'] }}44 0%, transparent 70%);"></div>
                                    
                                    <div class="thumb-header-badge">
                                        <span>CAREERFIXX • PRO COURSE</span>
                                    </div>

                                    <div class="thumb-center-content">
                                        <h4 class="thumb-banner-title">{{ $c['banner_title'] }}</h4>
                                        <p class="thumb-banner-tag">{{ $c['banner_tag'] }}</p>
                                    </div>

                                    <!-- Centered Play Button (White Circle with Play Triangle) -->
                                    <div class="center-play-button">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#0f172a">
                                            <polygon points="6,3 20,12 6,21"></polygon>
                                        </svg>
                                    </div>

                                    <div class="thumb-footer-meta">
                                        <span>16 Lessons</span>
                                        <span>•</span>
                                        <span>Certificate</span>
                                        <span>•</span>
                                        <span>Self-Paced</span>
                                    </div>
                                </div>
                            </a>

                            <!-- Course Details Body -->
                            <div class="course-card-body">
                                <h3 class="course-card-title">
                                    <a href="{{ url('/classroom') }}?course={{ $c['slug'] }}">{{ $c['title'] }}</a>
                                </h3>

                                <div class="course-instructor-row">
                                    <img src="{{ $c['instructor_avatar'] }}" alt="{{ $c['instructor'] }}" class="instructor-avatar">
                                    <span class="instructor-name">By {{ $c['instructor'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- PANEL 2: DASHBOARD & AFFILIATE COMMAND CENTER -->
            <section id="panel-dashboard" class="portal-tab-panel" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Affiliate Command Center</h2>
                        <p style="color: #64748b; font-size: 0.92rem;">Active Tier: <strong style="color: #7c3aed;">{{ session('user.active_package', 'Advance Package') }}</strong> | Referral ID: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a; font-weight: 700;">{{ session('user.affiliate_id', 'CFX-8821') }}</code></p>
                    </div>
                </div>

                <!-- Earnings Grid (Responsive 4 cols desktop, 2 cols mobile) -->
                <div class="earnings-grid-container">
                    <div style="background: #ffffff; padding: 1.4rem; border-radius: 14px; border-left: 4px solid #10b981; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h5 style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; margin-bottom: 0.35rem; font-weight: 700;">TODAY'S EARNING</h5>
                        <div style="font-size: 1.85rem; font-weight: 800; color: #10b981;">₹{{ number_format(session('user.today_earning', 2200)) }}</div>
                    </div>
                    <div style="background: #ffffff; padding: 1.4rem; border-radius: 14px; border-left: 4px solid #7c3aed; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h5 style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; margin-bottom: 0.35rem; font-weight: 700;">LAST 7 DAYS</h5>
                        <div style="font-size: 1.85rem; font-weight: 800; color: #0f172a;">₹{{ number_format(session('user.weekly_earning', 7400)) }}</div>
                    </div>
                    <div style="background: #ffffff; padding: 1.4rem; border-radius: 14px; border-left: 4px solid #f59e0b; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h5 style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; margin-bottom: 0.35rem; font-weight: 700;">TOTAL COMMISSIONS</h5>
                        <div style="font-size: 1.85rem; font-weight: 800; color: #f59e0b;">₹{{ number_format(session('user.total_earning', 48600)) }}</div>
                    </div>
                    <div style="background: #ffffff; padding: 1.4rem; border-radius: 14px; border-left: 4px solid #10b981; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h5 style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; margin-bottom: 0.35rem; font-weight: 700;">AVAILABLE WALLET</h5>
                        <div style="font-size: 1.85rem; font-weight: 800; color: #10b981;">₹{{ number_format(session('user.wallet_balance', 14200)) }}</div>
                        <button onclick="openModal('payoutModal')" class="btn btn-secondary" style="padding: 0.35rem 0.8rem; font-size: 0.8rem; margin-top: 0.6rem; width: 100%; border: 1px solid #e2e8f0; color: #0f172a;">Withdraw Funds</button>
                    </div>
                </div>

                <!-- Personal Referral Link -->
                <div style="background: #ffffff; padding: 1.6rem; border-radius: 14px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;">
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 0.4rem;">🔗 Your Personal Referral Link</h4>
                    <p style="color: #64748b; font-size: 0.88rem; margin-bottom: 1rem;">Share your link on WhatsApp, Instagram bio, or YouTube. Earn 70% direct commission instantly upon lead signup.</p>
                    <div class="referral-box-row">
                        <input type="text" id="portalAffiliateLink" style="flex: 1; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.92rem; background: #f8fafc; color: #0f172a;" value="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'CFX-8821') }}" readonly>
                        <button onclick="copyPortalLink()" class="btn btn-primary" style="background: #7c3aed; color: #fff; padding: 0.75rem 1.4rem; font-weight: 700; border-radius: 8px; white-space: nowrap;">Copy Link</button>
                    </div>
                </div>

                <!-- Commission Table -->
                <div style="background: #ffffff; padding: 1.6rem; border-radius: 14px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;">
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.2rem;">👥 Real-Time Commission Log</h4>
                    <div class="table-responsive-wrapper">
                        <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                    <th style="padding: 10px;">Enrolled Student</th>
                                    <th style="padding: 10px;">Package</th>
                                    <th style="padding: 10px;">Your Profit</th>
                                    <th style="padding: 10px;">Type</th>
                                    <th style="padding: 10px;">Time</th>
                                    <th style="padding: 10px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commissions as $comm)
                                    <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                        <td style="padding: 12px 10px;"><strong>{{ $comm['name'] }}</strong></td>
                                        <td style="padding: 12px 10px;">{{ $comm['package'] }}</td>
                                        <td style="padding: 12px 10px; color: #10b981; font-weight: 700;">+₹{{ number_format($comm['amount']) }}</td>
                                        <td style="padding: 12px 10px;"><span style="background: #f3e8ff; color: #7c3aed; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">{{ $comm['type'] }}</span></td>
                                        <td style="padding: 12px 10px; color: #64748b; font-size: 0.82rem;">{{ $comm['time'] }}</td>
                                        <td style="padding: 12px 10px; color: #10b981; font-weight: 600;">● {{ $comm['status'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- PANEL 3: PROFILE -->
            <section id="panel-profile" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 800px;">
                    <div style="display: flex; gap: 1.5rem; align-items: center; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 1.5rem;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80" alt="{{ session('user.name', 'Vansh Tandon') }}" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #7c3aed; object-fit: cover;">
                        <div>
                            <h3 style="font-size: 1.4rem; color: #0f172a; font-weight: 800;">{{ session('user.name', 'Vansh Tandon') }}</h3>
                            <p style="color: #64748b; font-size: 0.9rem;">Member ID: <strong>{{ session('user.affiliate_id', 'CFX-8821') }}</strong></p>
                            <span style="display: inline-block; background: #ecfdf5; color: #059669; padding: 3px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; margin-top: 4px;">KYC Verified Student</span>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem;">
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Email Address</label>
                            <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px;">{{ session('user.email', 'vansh@careerfixx.com') }}</div>
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Mobile Number</label>
                            <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px;">{{ session('user.phone', '+91 98765 43210') }}</div>
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Current Learning Package</label>
                            <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #7c3aed; margin-top: 4px;">{{ session('user.active_package', 'Advance Package') }}</div>
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Sponsor / Mentor</label>
                            <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px;">{{ session('user.sponsor_id', 'CFX-ADMIN') }} (Official Master)</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PANEL 4: SOCIAL COMMUNITY -->
            <section id="panel-community" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <h3 style="font-size: 1.4rem; color: #0f172a; font-weight: 800; margin-bottom: 0.5rem;">🌐 Official Mentorship Communities</h3>
                    <p style="color: #64748b; margin-bottom: 1.8rem; font-size: 0.92rem;">Join daily live Q&amp;A sessions, access sales scripts, and network with over 12,000+ top student creators.</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.2rem;">
                        <div style="padding: 1.4rem; border-radius: 12px; background: #f0fdf4; border: 1px solid #bbf7d0;">
                            <h4 style="color: #166534; font-weight: 800;">💬 VIP WhatsApp Mastermind</h4>
                            <p style="font-size: 0.85rem; color: #15803d; margin: 6px 0 12px;">Instant support, daily lead tactics &amp; closing scripts directly from trainers.</p>
                            <a href="https://chat.whatsapp.com" target="_blank" class="btn btn-primary" style="background: #16a34a; font-size: 0.85rem; padding: 0.5rem 1rem;">Join WhatsApp Group ➔</a>
                        </div>
                        <div style="padding: 1.4rem; border-radius: 12px; background: #f0f9ff; border: 1px solid #bae6fd;">
                            <h4 style="color: #0369a1; font-weight: 800;">📢 Telegram Broadcast Channel</h4>
                            <p style="font-size: 0.85rem; color: #0284c7; margin: 6px 0 12px;">Weekly webinar links, top earner leaderboards &amp; payout updates.</p>
                            <a href="https://t.me" target="_blank" class="btn btn-primary" style="background: #0284c7; font-size: 0.85rem; padding: 0.5rem 1rem;">Join Telegram Channel ➔</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- PANEL 5: KYC -->
            <section id="panel-kyc" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 700px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1.2rem;">
                        <span style="font-size: 2rem;">🛡️</span>
                        <div>
                            <h3 style="font-size: 1.3rem; color: #0f172a; font-weight: 800;">KYC Compliance Status: <span style="color: #10b981;">VERIFIED</span></h3>
                            <p style="color: #64748b; font-size: 0.88rem;">Government identity verified for automated same-day UPI/Bank payouts.</p>
                        </div>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; border: 1px solid #e2e8f0; font-size: 0.9rem; line-height: 1.8;">
                        <div><strong>Aadhaar Card:</strong> XXXXXXXX4819 (Verified via OTP ✅)</div>
                        <div><strong>PAN Card:</strong> ABCDE1234F (Verified with NSDL ✅)</div>
                        <div><strong>Bank Account / UPI:</strong> suraj@okhdfcbank (Active for direct deposits ✅)</div>
                    </div>
                </div>
            </section>

            <!-- PANEL 6: AFFILIATE LINK -->
            <section id="panel-affiliate-link" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 800px;">
                    <h3 style="font-size: 1.4rem; color: #0f172a; font-weight: 800; margin-bottom: 0.5rem;">🔗 Your Unique CareerFixx Referral Link</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Every student who enrolls through this link gives you up to 70% direct commission instantly credited to your wallet.</p>
                    
                    <div style="display: flex; gap: 10px; margin-bottom: 1.5rem;">
                        <input type="text" id="dedicatedRefLink" style="flex: 1; padding: 0.85rem 1rem; border: 1.5px solid #d8b4fe; border-radius: 8px; font-size: 0.95rem; font-weight: 600; background: #faf5ff; color: #7c3aed;" value="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'CFX-8821') }}" readonly>
                        <button onclick="copyDedicatedRefLink()" class="btn btn-primary" style="background: #7c3aed; font-weight: 700;">Copy Link</button>
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="https://api.whatsapp.com/send?text=Learn%20high-ticket%20skills%20and%20monetize%20with%20CareerFixx:%20{{ url('/register') }}?ref={{ session('user.affiliate_id', 'CFX-8821') }}" target="_blank" class="btn btn-primary" style="background: #25d366; font-size: 0.85rem;">Share on WhatsApp ➔</a>
                    </div>
                </div>
            </section>

            <!-- PANEL 7: MY PAYOUT -->
            <section id="panel-payout" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.4rem; color: #0f172a; font-weight: 800;">💳 Bank &amp; UPI Withdrawal Portal</h3>
                            <p style="color: #64748b; font-size: 0.9rem;">Available to Withdraw: <strong style="color: #10b981; font-size: 1.2rem;">₹{{ number_format(session('user.wallet_balance', 14200)) }}</strong></p>
                        </div>
                        <button onclick="openModal('payoutModal')" class="btn btn-primary" style="background: #10b981; font-weight: 700;">+ Request New Withdrawal</button>
                    </div>

                    <div class="table-responsive-wrapper">
                        <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                    <th style="padding: 10px;">Payout ID</th>
                                    <th style="padding: 10px;">Amount</th>
                                    <th style="padding: 10px;">Destination Account</th>
                                    <th style="padding: 10px;">Status</th>
                                    <th style="padding: 10px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payouts as $p)
                                    <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                        <td style="padding: 12px 10px;"><code>{{ $p['id'] }}</code></td>
                                        <td style="padding: 12px 10px; font-weight: 700;">₹{{ number_format($p['amount']) }}</td>
                                        <td style="padding: 12px 10px; color: #64748b;">{{ $p['method'] }}</td>
                                        <td style="padding: 12px 10px; color: #10b981; font-weight: 600;">● {{ $p['status'] }}</td>
                                        <td style="padding: 12px 10px; color: #64748b; font-size: 0.82rem;">{{ $p['date'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- PANEL 8: CERTIFICATES -->
            <section id="panel-certificate" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <h3 style="font-size: 1.4rem; color: #0f172a; font-weight: 800; margin-bottom: 0.5rem;">🎖️ Course Completion Certificates</h3>
                    <p style="color: #64748b; margin-bottom: 2rem; font-size: 0.92rem;">Verified ISO-certified credentials issued under your name: <strong>{{ session('user.name', 'Vansh Tandon') }}</strong></p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                        @foreach (array_slice($courses, 0, 4) as $cert)
                            <div style="border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1.4rem; background: #fafafa; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <span style="font-size: 0.75rem; color: #7c3aed; font-weight: 800; text-transform: uppercase;">VERIFIED CERTIFICATE</span>
                                    <h4 style="font-size: 1.1rem; color: #0f172a; margin: 6px 0 10px; font-weight: 800;">{{ $cert['title'] }}</h4>
                                    <p style="font-size: 0.82rem; color: #64748b;">Issued on completion of 100% syllabus modules &amp; assessments.</p>
                                </div>
                                <button onclick="alert('Downloading official certificate for {{ $cert['title'] }}...')" class="btn btn-secondary" style="margin-top: 1.2rem; font-size: 0.85rem; border: 1px solid #d8b4fe; color: #7c3aed;">
                                    📥 Download Certificate (PDF)
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- GENERIC PANEL FOR OTHER TABS -->
            <section id="panel-generic" class="portal-tab-panel" style="display: none;">
                <div style="background: #ffffff; padding: 2.5rem; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 15px rgba(0,0,0,0.03); text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🚀</div>
                    <h3 id="genericTabTitle" style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">Section Overview</h3>
                    <p style="color: #64748b; max-width: 500px; margin: 0 auto 1.5rem;">This feature is active for your account. Complete daily lessons to unlock premium leaderboards, marketing tools, and live training passes.</p>
                    <button onclick="switchPortalTab('courses')" class="btn btn-primary" style="background: #7c3aed;">Back to My Courses ➔</button>
                </div>
            </section>

        </main>
    </div>
</div>

<!-- Modal for Payout -->
<div id="payoutModal" class="modal">
    <div class="modal-box" style="background: #ffffff; border: 1px solid #e2e8f0; color: #0f172a; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
        <button class="close-btn" onclick="closeModal('payoutModal')" style="color: #64748b;">&times;</button>
        <h3 style="margin-bottom: 0.6rem; color: #0f172a; font-weight: 800;">💸 Request Bank Withdrawal</h3>
        <p style="color: #64748b; font-size: 0.88rem; margin-bottom: 1.5rem;">Available Balance: <strong style="color: #10b981;">₹{{ number_format(session('user.wallet_balance', 14200)) }}</strong></p>
        
        <form method="POST" action="{{ url('/payout-request') }}">
            @csrf
            <div class="form-group">
                <label style="color: #334155;">Amount to Withdraw (Min ₹500)</label>
                <input type="number" name="payout_amount" class="form-control" value="2000" min="500" max="{{ session('user.wallet_balance', 14200) }}" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a;" required>
            </div>
            <div class="form-group">
                <label style="color: #334155;">UPI ID or Bank Account Details</label>
                <input type="text" name="payout_details" class="form-control" placeholder="yourname@okhdfcbank or HDFC A/C No." style="background: #f8fafc; border: 1px solid #cbd5e1; color: #0f172a;" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; background: #7c3aed; font-weight: 800; border-radius: 8px;">Submit Withdrawal Request</button>
        </form>
    </div>
</div>

<style>
    /* ==========================================================
       STUDENT PORTAL & DASHBOARD STYLES (MATCHES USER IMAGES)
       ========================================================== */
    .student-portal-wrapper {
        background: #f8fafc;
        background-image: radial-gradient(circle at 12% 8%, rgba(244, 114, 182, 0.12) 0%, rgba(248, 250, 252, 0) 45%);
        min-height: calc(100vh - 80px);
        padding: 2.2rem 2rem 5rem;
    }

    .portal-main-grid {
        max-width: 1440px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 2.2rem;
        align-items: start;
    }

    /* Left Sidebar Card (Matches Image with soft purple border) */
    .portal-sidebar-card {
        background: #ffffff;
        border: 1.5px solid #d8b4fe;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.03);
        overflow: hidden;
        padding: 0.65rem 0;
        position: sticky;
        top: 90px;
    }

    .portal-sidebar-nav {
        display: flex;
        flex-direction: column;
    }

    .sidebar-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0.74rem 1.4rem;
        color: #334155;
        font-size: 0.94rem;
        font-weight: 600;
        text-decoration: none;
        border-left: 4px solid transparent;
        transition: all 0.15s ease;
    }

    .sidebar-item .side-icon {
        width: 19px;
        height: 19px;
        color: #475569;
        flex-shrink: 0;
        transition: color 0.15s ease;
    }

    /* Soft lavender hover state (Matches Social Community in screenshot) */
    .sidebar-item:hover {
        background: #faf5ff;
        color: #7c3aed;
    }

    .sidebar-item:hover .side-icon {
        color: #7c3aed;
    }

    /* Active State (Matches My Course in screenshot with 4px left bar) */
    .sidebar-item.active {
        background: #faf5ff;
        color: #7c3aed;
        font-weight: 700;
        border-left-color: #7c3aed;
    }

    .sidebar-item.active .side-icon {
        color: #7c3aed;
    }

    /* Mobile Quick Tab Slider */
    .mobile-portal-nav {
        display: none;
        margin-bottom: 1.5rem;
    }

    .mobile-nav-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.65rem;
        padding: 0 2px;
    }

    .mobile-nav-title {
        font-size: 0.78rem;
        font-weight: 800;
        color: #64748b;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }

    .mobile-open-drawer-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: #faf5ff;
        border: 1px solid #d8b4fe;
        border-radius: 20px;
        color: #7c3aed;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
    }

    .mobile-open-drawer-btn:hover {
        background: #f3e8ff;
    }

    .mobile-tabs-scroll {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 6px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .mobile-tabs-scroll::-webkit-scrollbar { display: none; }

    .m-portal-tab {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.55rem 1rem;
        border-radius: 50px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s;
    }

    .m-portal-tab.active {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
    }

    /* Responsive Grid Wrappers */
    .earnings-grid-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2.2rem;
    }

    .referral-box-row {
        display: flex;
        gap: 0.8rem;
    }

    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
    }

    .table-responsive-wrapper table {
        min-width: 580px;
        width: 100%;
    }

    /* Right Content Area */
    .portal-content-area {
        min-width: 0;
    }

    .welcome-heading {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.4rem;
        letter-spacing: -0.5px;
    }

    .highlight-user-name {
        color: #c026d3; /* Magenta / violet tone matching screenshot */
    }

    /* Filter Pills */
    .course-filter-pills {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.65rem 1.6rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: all 0.2s ease;
    }

    .filter-pill.active {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: #0f172a;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .pill-badge-num {
        color: #64748b;
        font-size: 0.78rem;
    }

    /* Courses Cards Grid (4 Columns) */
    .courses-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    /* Course Card Item */
    .portal-course-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease;
    }

    .portal-course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.09);
    }

    .card-thumb-link {
        text-decoration: none;
        display: block;
    }

    .course-thumb-container {
        height: 148px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 0.75rem 0.85rem;
    }

    .thumb-neon-glow {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 140px;
        height: 140px;
        pointer-events: none;
    }

    .thumb-header-badge {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: flex-start;
    }

    .thumb-header-badge span {
        background: rgba(0, 0, 0, 0.6);
        color: #cbd5e1;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.62rem;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .thumb-center-content {
        position: relative;
        z-index: 1;
        text-align: left;
        margin-top: auto;
        margin-bottom: auto;
    }

    .thumb-banner-title {
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 900;
        line-height: 1.2;
        letter-spacing: -0.3px;
        text-transform: uppercase;
        margin-bottom: 2px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
    }

    .thumb-banner-tag {
        color: #94a3b8;
        font-size: 0.62rem;
        line-height: 1.2;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Centered Play Button (Image 1 Style) */
    .center-play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 44px;
        height: 44px;
        background: #ffffff;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease;
    }

    .center-play-button svg {
        margin-left: 2px;
    }

    .portal-course-card:hover .center-play-button {
        transform: translate(-50%, -50%) scale(1.15);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
    }

    .thumb-footer-meta {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 6px;
        color: #94a3b8;
        font-size: 0.65rem;
        font-weight: 600;
    }

    /* Course Card Body */
    .course-card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .course-card-title {
        font-size: 0.98rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        line-height: 1.35;
    }

    .course-card-title a {
        color: #0f172a;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .course-card-title a:hover {
        color: #7c3aed;
    }

    .course-instructor-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .instructor-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
    }

    .instructor-name {
        color: #64748b;
        font-size: 0.82rem;
        font-weight: 600;
    }

    /* ==========================================================
       RESPONSIVE BREAKPOINTS (Mobile & Tablet)
       ========================================================== */
    @media (max-width: 1280px) {
        .courses-cards-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 1024px) {
        .earnings-grid-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 992px) {
        .student-portal-wrapper {
            padding: 1.2rem 1rem 4rem;
        }

        .portal-main-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        /* Hide desktop sidebar on mobile, show quick horizontal slider */
        .portal-sidebar-card {
            display: none;
        }

        .mobile-portal-nav {
            display: block;
        }

        .courses-cards-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 600px) {
        .referral-box-row {
            flex-direction: column;
        }
        .referral-box-row button {
            width: 100%;
        }
    }

    @media (max-width: 580px) {
        .student-portal-wrapper {
            padding: 0.85rem 0.75rem 3.5rem;
        }

        .welcome-heading {
            font-size: 1.35rem;
            margin-bottom: 1rem;
        }

        .course-filter-pills {
            gap: 0.6rem;
            margin-bottom: 1.4rem;
        }

        .filter-pill {
            padding: 0.5rem 1.1rem;
            font-size: 0.82rem;
        }

        .courses-cards-grid {
            grid-template-columns: 1fr;
            gap: 1.2rem;
        }

        .course-thumb-container {
            height: 165px;
        }

        .earnings-grid-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.65rem;
        }

        .earnings-grid-container > div {
            padding: 1.1rem 0.9rem !important;
        }
    }

    @media (max-width: 380px) {
        .earnings-grid-container {
            grid-template-columns: 1fr;
        }
    }
</style>

@push('scripts')
<script>
    // Tab Switcher between Courses, Dashboard, Profile, Payout, etc.
    window.switchPortalTab = function(tabId) {
        // Hide all panels
        document.querySelectorAll('.portal-tab-panel').forEach(p => p.style.display = 'none');
        
        // Remove active class from desktop sidebar, mobile pills, and mobile drawer
        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        document.querySelectorAll('.m-portal-tab').forEach(i => i.classList.remove('active'));
        document.querySelectorAll('.mobile-portal-link').forEach(i => i.classList.remove('active'));

        const targetPanel = document.getElementById('panel-' + tabId);
        if (targetPanel) {
            targetPanel.style.display = 'block';
        } else {
            // Generic section for secondary tabs
            const genPanel = document.getElementById('panel-generic');
            const titleEl = document.getElementById('genericTabTitle');
            if (genPanel) {
                genPanel.style.display = 'block';
                if (titleEl) {
                    titleEl.innerText = tabId.replace(/-/g, ' ').toUpperCase();
                }
            }
        }

        // Highlight Desktop & Mobile buttons & Mobile drawer link
        const deskBtn = document.getElementById('tab-btn-' + tabId);
        if (deskBtn) deskBtn.classList.add('active');

        const mobBtn = document.getElementById('m-tab-' + tabId);
        if (mobBtn) {
            mobBtn.classList.add('active');
            try {
                mobBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } catch(e) {}
        }

        const mobDrawerLink = document.getElementById('mob-link-' + tabId);
        if (mobDrawerLink) mobDrawerLink.classList.add('active');

        // Update URL query parameter without page reload
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', url);
        }

        // Scroll smoothly to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    function filterCourses(type) {
        document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
        if (event && event.target) {
            event.target.closest('.filter-pill').classList.add('active');
        }
    }

    function copyPortalLink() {
        const input = document.getElementById('portalAffiliateLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Referral Link Copied to Clipboard!\n' + input.value);
            });
        }
    }

    function copyDedicatedRefLink() {
        const input = document.getElementById('dedicatedRefLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Referral Link Copied to Clipboard!\n' + input.value);
            });
        }
    }

    // Auto-select tab if present in query string
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab');
        if (tab) {
            switchPortalTab(tab);
        }
    });
</script>
@endpush
@endsection
