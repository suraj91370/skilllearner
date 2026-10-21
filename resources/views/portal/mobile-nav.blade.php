@php
    $currentActive = $active ?? 'courses';
@endphp

<!-- Top Mobile Quick Tab Slider (Visible on Mobile/Tablet <= 992px) -->
<div class="mobile-portal-nav">
    <div class="mobile-nav-header-row">
        <span class="mobile-nav-title">PORTAL NAVIGATION</span>
        <button type="button" onclick="window.openMobileMenu()" class="mobile-open-drawer-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            <span>All 15 Sections</span>
        </button>
    </div>
    <div class="mobile-tabs-scroll">
        <!-- 1. My Course -->
        <a href="{{ url('/my-courses') }}" class="m-portal-tab {{ $currentActive === 'courses' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
            <span>My Course</span>
        </a>

        <!-- 2. Dashboard -->
        <a href="{{ url('/dashboard') }}" class="m-portal-tab {{ $currentActive === 'dashboard' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            <span>Dashboard</span>
        </a>

        <!-- 3. Profile -->
        <a href="{{ url('/profile') }}" class="m-portal-tab {{ $currentActive === 'profile' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Profile</span>
        </a>

        <!-- 4. Social Community -->
        <a href="{{ url('/social-community') }}" class="m-portal-tab {{ $currentActive === 'community' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <span>Social Community</span>
        </a>

        <!-- 5. Kyc -->
        <a href="{{ url('/kyc') }}" class="m-portal-tab {{ $currentActive === 'kyc' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span>Kyc</span>
        </a>

        <!-- 6. Affiliate Link -->
        <a href="{{ url('/affiliate-link') }}" class="m-portal-tab {{ $currentActive === 'affiliate-link' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            <span>Affiliate Link</span>
        </a>

        <!-- 7. Token Purchases -->
        <a href="{{ url('/token-purchases') }}" class="m-portal-tab {{ $currentActive === 'tokens' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span>Token Purchases</span>
        </a>

        <!-- 8. Affiliate Training -->
        <a href="{{ url('/affiliate-training') }}" class="m-portal-tab {{ $currentActive === 'training' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>Affiliate Training</span>
        </a>

        <!-- 9. Upgrade -->
        <a href="{{ url('/plans') }}" class="m-portal-tab {{ $currentActive === 'upgrade' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <span>Upgrade</span>
        </a>

        <!-- 10. Marketing Tool -->
        <a href="{{ url('/marketing-tool') }}" class="m-portal-tab {{ $currentActive === 'marketing' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            <span>Marketing Tool</span>
        </a>

        <!-- 11. My Payout -->
        <a href="{{ url('/my-payout') }}" class="m-portal-tab {{ $currentActive === 'payout' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            <span>My Payout</span>
        </a>

        <!-- 12. Leaderboard -->
        <a href="{{ url('/leaderboard') }}" class="m-portal-tab {{ $currentActive === 'leaderboard' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <span>Leaderboard</span>
        </a>

        <!-- 13. Team Leaderboard -->
        <a href="{{ url('/team-leaderboard') }}" class="m-portal-tab {{ $currentActive === 'team-leaderboard' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span>Team Leaderboard</span>
        </a>

        <!-- 14. Qualification -->
        <a href="{{ url('/qualification') }}" class="m-portal-tab {{ $currentActive === 'qualification' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            <span>Qualification</span>
        </a>

        <!-- 15. Certificate -->
        <a href="{{ url('/certificates') }}" class="m-portal-tab {{ $currentActive === 'certificates' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
            <span>Certificate</span>
        </a>
    </div>
</div>
