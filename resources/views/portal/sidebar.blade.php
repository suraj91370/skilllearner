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
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    User
                </span>
            @endif
        </div>
        <div class="sidebar-role-user-name" title="{{ session('user.name', 'User') }}">
            {{ session('user.name', 'User') }}
        </div>
        @if(session()->has('impersonated_by'))
            <div style="margin-top: 8px;">
                <a href="{{ route('admin.impersonate.leave') }}" style="display: flex; align-items: center; justify-content: center; gap: 5px; background: #e11d48; color: #ffffff; padding: 5px 10px; border-radius: 6px; font-size: 0.74rem; font-weight: 800; text-decoration: none; box-shadow: 0 2px 6px rgba(225, 29, 72, 0.25);">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Exit Impersonation
                </a>
            </div>
        @endif
    </div>

    <nav class="portal-sidebar-nav">
        {{-- ========================================================= --}}
        {{-- 1. ADMINISTRATION SECTION (Visible only to Admin & Super Admin) --}}
        {{-- ========================================================= --}}
        @if ($isAdmin)
            <div class="sidebar-section-label">Administration</div>

            <!-- Super Admin Dashboard (Revenue & Approvals) -->
            <a href="{{ url('/admin') }}" class="sidebar-item {{ $currentActive === 'admin-dashboard' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span>Admin Dashboard</span>
                <span class="sidebar-item-badge-pill" style="background: rgba(5, 179, 150, 0.15); color: #05B396;">Revenue</span>
            </a>

            <!-- Mentor Management (Super Admin & Admin) -->
            <a href="{{ url('/admin/mentors') }}" class="sidebar-item {{ $currentActive === 'admin-mentors' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Mentor Management</span>
                <span class="sidebar-item-badge-pill" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">Mentors</span>
            </a>

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
                <!-- Course Option & Show/Hide Control (Super Admin ONLY) -->
                <a href="{{ url('/admin/courses') }}" class="sidebar-item {{ $currentActive === 'admin-courses' ? 'active' : '' }}">
                    <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                    <span>Course Option</span>
                    <span class="sidebar-item-badge-pill super">Show/Hide</span>
                </a>

                <!-- Video Option & Show/Hide Control (Super Admin ONLY) -->
                <a href="{{ url('/admin/videos') }}" class="sidebar-item {{ $currentActive === 'admin-videos' ? 'active' : '' }}">
                    <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="23 7 16 12 23 17 23 7"></polygon>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                    </svg>
                    <span>Video Option</span>
                    <span class="sidebar-item-badge-pill super">Show/Hide</span>
                </a>

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
        <!-- Dashboard -->
        <a href="{{ url('/dashboard') }}" class="sidebar-item {{ $currentActive === 'dashboard' ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- My Course (Previously Videos) -->
        <a href="{{ url('/videos') }}" class="sidebar-item {{ in_array($currentActive, ['videos', 'courses']) ? 'active' : '' }}">
            <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polygon points="10 8 16 12 10 16 10 8"></polygon>
            </svg>
            <span>My Course</span>
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

        {{-- ========================================================= --}}
        {{-- 3. AFFILIATE & REWARDS (Visible to Student/User ONLY)     --}}
        {{-- ========================================================= --}}
        @if ($isUser)
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

            <!-- Active Referral (Direct Referrals / Tier-1) -->
            <a href="{{ url('/active-referrals') }}" class="sidebar-item {{ $currentActive === 'active-referrals' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                <span>Active Referral</span>
            </a>

            <!-- Passive Referral (Tier-2 / Team Referrals) -->
            <a href="{{ url('/passive-referrals') }}" class="sidebar-item {{ $currentActive === 'passive-referrals' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
                <span>Passive Referral</span>
            </a>

            <!-- Webinars (Matches Image 1) -->
            <a href="{{ url('/webinars') }}" class="sidebar-item {{ $currentActive === 'webinars' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                </svg>
                <span>Webinars</span>
            </a>

            <!-- Live Offers (Matches Image 1) -->
            <a href="{{ url('/live-offers') }}" class="sidebar-item {{ $currentActive === 'live-offers' ? 'active' : '' }}">
                <svg class="side-icon" width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; max-width: 18px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <circle cx="12" cy="12" r="6"></circle>
                    <circle cx="12" cy="12" r="2"></circle>
                </svg>
                <span>Live Offers</span>
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
