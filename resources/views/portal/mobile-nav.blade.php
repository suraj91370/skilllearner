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

<!-- Top Mobile Quick Tab Slider (Visible on Mobile/Tablet <= 992px) -->
<div class="mobile-portal-nav">
    <div class="mobile-nav-header-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; width: 100%; max-width: 100%; box-sizing: border-box;">
        <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 6px; min-width: 0;">
            <span class="mobile-nav-title" style="white-space: nowrap;">PORTAL NAVIGATION</span>
            @if ($isSuperAdmin)
                <span style="background: #7c3aed; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 7px; border-radius: 12px; letter-spacing: 0.5px; white-space: nowrap;">👑 SUPER ADMIN</span>
            @elseif ($isAdmin)
                <span style="background: #0284c7; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 2px 7px; border-radius: 12px; letter-spacing: 0.5px; white-space: nowrap;">ADMIN</span>
            @else
                <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; font-size: 0.65rem; font-weight: 800; padding: 2px 7px; border-radius: 12px; letter-spacing: 0.5px; white-space: nowrap;">STUDENT</span>
            @endif
        </div>
        <button type="button" onclick="window.toggleMobileMenu(event)" class="mobile-open-drawer-btn" style="border: 1px solid #cbd5e1; background: #ffffff; color: #475569; font-size: 0.76rem; padding: 3px 9px; border-radius: 6px; font-weight: 700; cursor: pointer; flex-shrink: 0;">
            ☰ All Menu
        </button>
    </div>
    <div class="mobile-tabs-scroll" style="width: 100%; max-width: 100%; box-sizing: border-box;">
        {{-- ================= ADMIN TABS ================= --}}
        @if ($isAdmin)
            @if ($isSuperAdmin)
                <!-- Super Admin Course Option (Show/Hide) -->
                <a href="{{ url('/admin/courses') }}" class="m-portal-tab {{ $currentActive === 'admin-courses' ? 'active' : '' }}" style="{{ $currentActive === 'admin-courses' ? '' : 'border: 1.5px solid #7c3aed; color: #7c3aed; background: #faf5ff;' }}">
                    <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    <span>Course Option (Show/Hide)</span>
                </a>

                <!-- Super Admin Video Option (Show/Hide) -->
                <a href="{{ url('/admin/videos') }}" class="m-portal-tab {{ $currentActive === 'admin-videos' ? 'active' : '' }}" style="{{ $currentActive === 'admin-videos' ? '' : 'border: 1.5px solid #7c3aed; color: #7c3aed; background: #faf5ff;' }}">
                    <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                    <span>Video Option (Show/Hide)</span>
                </a>
            @endif

            <a href="{{ url('/admin/users') }}" class="m-portal-tab {{ $currentActive === 'admin-users' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Users</span>
            </a>
            <a href="{{ url('/admin/kyc-requests') }}" class="m-portal-tab {{ $currentActive === 'admin-kyc' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="m9 15 2 2 4-4"/></svg>
                <span>KYC</span>
            </a>
            <a href="{{ url('/admin/payout-requests') }}" class="m-portal-tab {{ $currentActive === 'admin-payouts' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M12 14v4"/><path d="m10 16 2-2 2 2"/></svg>
                <span>Payouts</span>
            </a>
            @if ($isSuperAdmin)
                <a href="{{ url('/admin/settings') }}" class="m-portal-tab {{ $currentActive === 'admin-settings' ? 'active' : '' }}">
                    <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    <span>Settings</span>
                </a>
            @endif
        @endif

        {{-- ================= CORE TABS ================= --}}
        <!-- 1. My Course -->
        <a href="{{ url('/my-courses') }}" class="m-portal-tab {{ $currentActive === 'courses' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
            <span>My Course</span>
        </a>

        <!-- 2. Videos -->
        <a href="{{ url('/videos') }}" class="m-portal-tab {{ $currentActive === 'videos' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
            <span>Videos</span>
        </a>

        <!-- 3. Dashboard -->
        <a href="{{ url('/dashboard') }}" class="m-portal-tab {{ $currentActive === 'dashboard' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            <span>Dashboard</span>
        </a>

        <!-- 3. Profile -->
        <a href="{{ url('/profile') }}" class="m-portal-tab {{ $currentActive === 'profile' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Profile</span>
        </a>

        <!-- 4. Social Community -->
        <a href="{{ url('/social-community') }}" class="m-portal-tab {{ $currentActive === 'community' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <span>Community</span>
        </a>

        <!-- 5. Leaderboard -->
        <a href="{{ url('/leaderboard') }}" class="m-portal-tab {{ $currentActive === 'leaderboard' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <span>Leaderboard</span>
        </a>

        <!-- 6. Team Leaderboard -->
        <a href="{{ url('/team-leaderboard') }}" class="m-portal-tab {{ $currentActive === 'team-leaderboard' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span>Team</span>
        </a>

        <!-- 7. Certificate -->
        <a href="{{ url('/certificates') }}" class="m-portal-tab {{ $currentActive === 'certificates' ? 'active' : '' }}">
            <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
            <span>Certificate</span>
        </a>

        {{-- ================= AFFILIATE TOOLS (User Only) ================= --}}
        @if ($isUser)
            <!-- Kyc -->
            <a href="{{ url('/kyc') }}" class="m-portal-tab {{ $currentActive === 'kyc' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span>Kyc</span>
            </a>

            <!-- Affiliate Link -->
            <a href="{{ url('/affiliate-link') }}" class="m-portal-tab {{ $currentActive === 'affiliate-link' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <span>Affiliate Link</span>
            </a>

            <!-- Token Purchases -->
            <a href="{{ url('/token-purchases') }}" class="m-portal-tab {{ $currentActive === 'tokens' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span>Tokens</span>
            </a>

            <!-- Affiliate Training -->
            <a href="{{ url('/affiliate-training') }}" class="m-portal-tab {{ $currentActive === 'training' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span>Training</span>
            </a>

            <!-- Upgrade -->
            <a href="{{ url('/plans') }}" class="m-portal-tab {{ $currentActive === 'upgrade' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <span>Upgrade</span>
            </a>

            <!-- Marketing Tool -->
            <a href="{{ url('/marketing-tool') }}" class="m-portal-tab {{ $currentActive === 'marketing' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                <span>Marketing</span>
            </a>

            <!-- My Payout -->
            <a href="{{ url('/my-payout') }}" class="m-portal-tab {{ $currentActive === 'payout' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <span>Payout</span>
            </a>

            <!-- Qualification -->
            <a href="{{ url('/qualification') }}" class="m-portal-tab {{ $currentActive === 'qualification' ? 'active' : '' }}">
                <svg width="15" height="15" style="width: 15px; height: 15px; min-width: 15px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                <span>Qualification</span>
            </a>
        @endif
    </div>
</div>
