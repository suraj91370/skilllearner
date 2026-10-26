@php
    $currentActive = $active ?? 'courses';
    $userRole = Auth::user()?->role ?? session('user.role', 'user');
    if (in_array($userRole, ['affiliate', 'student'])) {
        $userRole = 'user';
    }
    $isSuperAdmin = ($userRole === 'super_admin');
    $isAdmin = in_array($userRole, ['super_admin', 'admin']);
    $isUser = ($userRole === 'user');
@endphp

<aside class="portal-sidebar-card">
    <!-- User Role Profile Pill Card -->
    <div class="sidebar-role-header">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
            @if ($isSuperAdmin)
                <span class="sidebar-role-badge super-admin">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
                    Super Admin
                </span>
            @elseif ($isAdmin)
                <span class="sidebar-role-badge admin">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Admin
                </span>
            @else
                <span class="sidebar-role-badge user">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Student / User
                </span>
            @endif
        </div>
        <div class="sidebar-role-user-name" title="{{ session('user.name', 'User') }}">
            {{ session('user.name', 'User') }}
        </div>
    </div>

    <nav class="portal-sidebar-nav">
        {{-- ========================================================= --}}
        {{-- 1. ADMINISTRATION SECTION (Visible only to Admin & Super Admin) --}}
        {{-- ========================================================= --}}
        @if ($isAdmin)
            <div class="sidebar-section-label">Administration</div>

            <!-- All Users Management (Super Admin & Admin) -->
            <a href="{{ url('/admin/users') }}" class="sidebar-item {{ $currentActive === 'admin-users' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>All Users</span>
                <span class="sidebar-item-badge-pill">Role Control</span>
            </a>

            <!-- KYC Approvals (Super Admin & Admin) -->
            <a href="{{ url('/admin/kyc-requests') }}" class="sidebar-item {{ $currentActive === 'admin-kyc' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <path d="m9 15 2 2 4-4"></path>
                </svg>
                <span>KYC Approvals</span>
            </a>

            <!-- Payout Approvals (Super Admin & Admin) -->
            <a href="{{ url('/admin/payout-requests') }}" class="sidebar-item {{ $currentActive === 'admin-payouts' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                    <path d="M12 14v4"></path>
                    <path d="m10 16 2-2 2 2"></path>
                </svg>
                <span>Payout Approvals</span>
            </a>

            @if ($isSuperAdmin)
                {{-- System Settings (Super Admin ONLY) --}}
                <a href="{{ url('/admin/settings') }}" class="sidebar-item {{ $currentActive === 'admin-settings' ? 'active' : '' }}">
                    <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <span>System Settings</span>
                    <span class="sidebar-item-badge-pill super">Super Only</span>
                </a>
            @endif
        @endif

        {{-- ========================================================= --}}
        {{-- 2. CORE PORTAL & LEARNING (Visible to ALL roles)          --}}
        {{-- ========================================================= --}}
        <div class="sidebar-section-label">Portal &amp; Learning</div>

        <!-- My Course -->
        <a href="{{ url('/my-courses') }}" class="sidebar-item {{ $currentActive === 'courses' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                <line x1="12" y1="18" x2="12.01" y2="18"></line>
            </svg>
            <span>My Course</span>
        </a>
        
        <!-- Dashboard -->
        <a href="{{ url('/dashboard') }}" class="sidebar-item {{ $currentActive === 'dashboard' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Profile -->
        <a href="{{ url('/profile') }}" class="sidebar-item {{ $currentActive === 'profile' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profile</span>
        </a>

        <!-- Social Community -->
        <a href="{{ url('/social-community') }}" class="sidebar-item {{ $currentActive === 'community' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Social Community</span>
        </a>

        <!-- Leaderboard -->
        <a href="{{ url('/leaderboard') }}" class="sidebar-item {{ $currentActive === 'leaderboard' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            <span>Leaderboard</span>
        </a>

        <!-- Team Leaderboard -->
        <a href="{{ url('/team-leaderboard') }}" class="sidebar-item {{ $currentActive === 'team-leaderboard' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
            <span>Team Leaderboard</span>
        </a>

        <!-- Certificate -->
        <a href="{{ url('/certificates') }}" class="sidebar-item {{ $currentActive === 'certificates' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="6"></circle>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>
            </svg>
            <span>Certificate</span>
        </a>

        {{-- ========================================================= --}}
        {{-- 3. AFFILIATE & REWARDS (Visible to Student/User ONLY)     --}}
        {{-- ========================================================= --}}
        @if ($isUser)
            <div class="sidebar-section-label">Affiliate Tools</div>

            <!-- Kyc Verification for Student -->
            <a href="{{ url('/kyc') }}" class="sidebar-item {{ $currentActive === 'kyc' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Kyc</span>
            </a>

            <!-- Affiliate Link -->
            <a href="{{ url('/affiliate-link') }}" class="sidebar-item {{ $currentActive === 'affiliate-link' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                </svg>
                <span>Affiliate Link</span>
            </a>

            <!-- Token Purchases (Hidden for Admins) -->
            <a href="{{ url('/token-purchases') }}" class="sidebar-item {{ $currentActive === 'tokens' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Token Purchases</span>
            </a>

            <!-- Affiliate Training -->
            <a href="{{ url('/affiliate-training') }}" class="sidebar-item {{ $currentActive === 'training' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Affiliate Training</span>
            </a>

            <!-- Upgrade Plan (Hidden for Admins) -->
            <a href="{{ url('/plans') }}" class="sidebar-item {{ $currentActive === 'upgrade' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
                <span>Upgrade</span>
            </a>

            <!-- Marketing Tool -->
            <a href="{{ url('/marketing-tool') }}" class="sidebar-item {{ $currentActive === 'marketing' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                    <polyline points="2 17 12 22 22 17"></polyline>
                    <polyline points="2 12 12 17 22 12"></polyline>
                </svg>
                <span>Marketing Tool</span>
            </a>

            <!-- My Payout (Hidden for Admins who manage payouts) -->
            <a href="{{ url('/my-payout') }}" class="sidebar-item {{ $currentActive === 'payout' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
                <span>My Payout</span>
            </a>

            <!-- Qualification Contest (Hidden for Admins) -->
            <a href="{{ url('/qualification') }}" class="sidebar-item {{ $currentActive === 'qualification' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                <span>Qualification</span>
            </a>
        @endif
    </nav>
</aside>
