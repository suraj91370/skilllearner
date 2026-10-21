@php
    $currentActive = $active ?? 'courses';
@endphp

<aside class="portal-sidebar-card">
    <nav class="portal-sidebar-nav">
        <!-- 1. My Course -->
        <a href="{{ url('/my-courses') }}" class="sidebar-item {{ $currentActive === 'courses' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                <line x1="12" y1="18" x2="12.01" y2="18"></line>
            </svg>
            <span>My Course</span>
        </a>
        
        <!-- 2. Dashboard -->
        <a href="{{ url('/dashboard') }}" class="sidebar-item {{ $currentActive === 'dashboard' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- 3. Profile -->
        <a href="{{ url('/profile') }}" class="sidebar-item {{ $currentActive === 'profile' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profile</span>
        </a>

        <!-- 4. Social Community -->
        <a href="{{ url('/social-community') }}" class="sidebar-item {{ $currentActive === 'community' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Social Community</span>
        </a>

        <!-- 5. Kyc -->
        <a href="{{ url('/kyc') }}" class="sidebar-item {{ $currentActive === 'kyc' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Kyc</span>
        </a>

        <!-- 6. Affiliate Link -->
        <a href="{{ url('/affiliate-link') }}" class="sidebar-item {{ $currentActive === 'affiliate-link' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
            </svg>
            <span>Affiliate Link</span>
        </a>

        <!-- 7. Token Purchases -->
        <a href="{{ url('/token-purchases') }}" class="sidebar-item {{ $currentActive === 'tokens' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span>Token Purchases</span>
        </a>

        <!-- 8. Affiliate Training -->
        <a href="{{ url('/affiliate-training') }}" class="sidebar-item {{ $currentActive === 'training' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Affiliate Training</span>
        </a>

        <!-- 9. Upgrade -->
        <a href="{{ url('/plans') }}" class="sidebar-item {{ $currentActive === 'upgrade' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span>Upgrade</span>
        </a>

        <!-- 10. Marketing Tool -->
        <a href="{{ url('/marketing-tool') }}" class="sidebar-item {{ $currentActive === 'marketing' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
            <span>Marketing Tool</span>
        </a>

        <!-- 11. My Payout -->
        <a href="{{ url('/my-payout') }}" class="sidebar-item {{ $currentActive === 'payout' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                <line x1="2" y1="10" x2="22" y2="10"></line>
            </svg>
            <span>My Payout</span>
        </a>

        <!-- 12. Leaderboard -->
        <a href="{{ url('/leaderboard') }}" class="sidebar-item {{ $currentActive === 'leaderboard' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            <span>Leaderboard</span>
        </a>

        <!-- 13. Team Leaderboard -->
        <a href="{{ url('/team-leaderboard') }}" class="sidebar-item {{ $currentActive === 'team-leaderboard' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
            <span>Team Leaderboard</span>
        </a>

        <!-- 14. Qualification -->
        <a href="{{ url('/qualification') }}" class="sidebar-item {{ $currentActive === 'qualification' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="7"></circle>
                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
            </svg>
            <span>Qualification</span>
        </a>

        <!-- 15. Certificate -->
        <a href="{{ url('/certificates') }}" class="sidebar-item {{ $currentActive === 'certificates' ? 'active' : '' }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="6"></circle>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>
            </svg>
            <span>Certificate</span>
        </a>
    </nav>
</aside>
