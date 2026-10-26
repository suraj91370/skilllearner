<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillLearner — Learn, Create, Monetize')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-body: #070a12;
            --bg-card: rgba(15, 23, 42, 0.75);
            --bg-card-hover: rgba(30, 41, 59, 0.85);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-accent: rgba(5, 179, 150, 0.35);
            --text-title: #f8fafc;
            --text-body: #94a3b8;
            --primary: #05B396;
            --primary-gradient: linear-gradient(135deg, #05B396 0%, #048873 100%);
            --secondary-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --success: #10b981;
            --gold: #f59e0b;
            --danger: #ef4444;
            --radius-md: 14px;
            --radius-lg: 22px;
            --shadow-glow: 0 0 35px rgba(5, 179, 150, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-title); line-height: 1.6; overflow-x: hidden; }
        .glass { background: var(--bg-card); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); border: 1px solid var(--border-glass); border-radius: var(--radius-md); }
        
        /* Navigation Bar (Desktop) */
        header.nav { 
            position: sticky; 
            top: 0; 
            z-index: 1050; 
            padding: 0.85rem 2.5rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 1px solid #f1f5f9; 
            background: #ffffff; 
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .brand { display: flex; align-items: center; gap: 8px; text-decoration: none; flex-shrink: 0; }
        .brand-logo-img { height: 48px; width: auto; max-width: 220px; object-fit: contain; display: block; }
        
        nav.menu { display: flex; gap: 1.8rem; align-items: center; }
        nav.menu > a { 
            color: #334155; 
            text-decoration: none; 
            font-size: 0.95rem; 
            font-weight: 600; 
            transition: color 0.2s ease; 
        }
        nav.menu > a:hover, nav.menu > a.active { color: #05B396; }

        /* Course Package Dropdown (Desktop Hover) */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #334155;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.5rem 0;
            transition: all 0.2s ease;
        }

        .dropdown-trigger:hover {
            color: #05B396;
        }

        .dropdown-trigger svg.chevron {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            stroke: #05B396;
        }

        .nav-dropdown:hover .dropdown-trigger svg.chevron {
            transform: rotate(180deg);
        }

        .dropdown-menu-box {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 210px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 0.9rem 0;
            margin-top: 0.4rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1000;
            border: 1px solid #f1f5f9;
        }

        .nav-dropdown:hover .dropdown-menu-box {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item-link {
            display: block;
            padding: 0.65rem 1.4rem;
            color: #0f172a;
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .dropdown-item-link:hover {
            background: #f0fdfa;
            color: #05B396;
            padding-left: 1.6rem;
        }

        /* Top Right Icons & User Pill (Matches Home Page Emerald Theme) */
        .sl-circle-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #05B396;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(5, 179, 150, 0.08);
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(5, 179, 150, 0.18);
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .sl-circle-badge:hover {
            transform: scale(1.06);
        }

        .notification-bell-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            color: #475569;
            padding: 4px;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .notification-bell-btn:hover {
            color: #05B396;
        }

        .bell-count-badge {
            background: #05B396;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 12px;
            margin-left: 2px;
            line-height: 1.2;
        }

        /* User Profile Pill Button */
        .user-menu-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .user-pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 14px 4px 5px;
            border-radius: 50px;
            border: 1.5px solid #05B396;
            background: #ffffff;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(5, 179, 150, 0.15);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .user-pill-btn:hover {
            box-shadow: 0 4px 15px rgba(5, 179, 150, 0.25);
            transform: translateY(-1px);
        }

        .user-pill-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(5, 179, 150, 0.4);
        }

        .user-pill-name {
            color: #05B396;
            font-weight: 700;
            font-size: 0.92rem;
            white-space: nowrap;
        }

        /* User Dropdown Card */
        .user-dropdown-card {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 200px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            padding: 0.6rem 0;
            z-index: 1065;
            display: none;
            animation: fadeInDown 0.2s ease;
        }

        .user-dropdown-card.active {
            display: block;
        }

        .dropdown-link-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 1.4rem;
            color: #334155;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }

        .dropdown-link-item:hover {
            background: #f0fdfa;
            color: #05B396;
        }

        .dropdown-link-item svg {
            color: #64748b;
            transition: color 0.15s;
            flex-shrink: 0;
        }

        .dropdown-link-item:hover svg {
            color: #05B396;
        }

        /* ==========================================================
           MOBILE TOGGLE BUTTON & SLIDE-IN DRAWER
           ========================================================== */
        .mobile-toggle {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            z-index: 1060;
            position: relative;
            pointer-events: auto;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .mobile-toggle:hover {
            background: rgba(5, 179, 150, 0.08);
        }

        .mobile-toggle .bar {
            width: 22px;
            height: 2.5px;
            background-color: #0f172a;
            border-radius: 2px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        /* Hamburger to X Transformation */
        .mobile-toggle.active .bar:nth-child(1) { 
            transform: translateY(7.5px) rotate(45deg); 
            background-color: #05B396; 
        }
        .mobile-toggle.active .bar:nth-child(2) { 
            opacity: 0; 
            transform: scale(0.2); 
        }
        .mobile-toggle.active .bar:nth-child(3) { 
            transform: translateY(-7.5px) rotate(-45deg); 
            background-color: #05B396; 
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mobile-overlay.active { 
            opacity: 1; 
            visibility: visible; 
            pointer-events: auto; 
        }

        .mobile-drawer {
            position: fixed;
            top: 0;
            right: -340px;
            width: 86%;
            max-width: 330px;
            height: 100vh;
            background: #ffffff;
            border-left: 1px solid #e2e8f0;
            z-index: 1045;
            padding: 4.8rem 1.2rem 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            transition: right 0.32s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: -15px 0 40px rgba(0, 0, 0, 0.18);
        }

        .mobile-drawer.active { right: 0; }

        /* Mobile Portal Link Items */
        .mobile-portal-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 0.9rem;
            color: #334155;
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 10px;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }

        .mobile-portal-link .mob-icon {
            width: 18px;
            height: 18px;
            color: #64748b;
            flex-shrink: 0;
            transition: color 0.15s ease;
        }

        .mobile-portal-link:hover, .mobile-portal-link.active {
            background: #f0fdfa;
            color: #05B396;
            font-weight: 700;
            border-left-color: #05B396;
        }

        .mobile-portal-link:hover .mob-icon, .mobile-portal-link.active .mob-icon {
            color: #05B396;
        }

        .mobile-nav-link {
            color: #334155;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            padding: 0.65rem 0.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: block;
        }

        .mobile-nav-link:hover, .mobile-nav-link.active { color: #05B396; }

        .mobile-accordion-btn {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.95rem;
            font-weight: 700;
            padding: 0.65rem 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            text-align: left;
        }

        .mobile-accordion-btn svg { transition: transform 0.25s ease; stroke: #05B396; }
        .mobile-accordion-btn.open svg { transform: rotate(180deg); }

        .mobile-accordion-content {
            display: none;
            flex-direction: column;
            background: #f8fafc;
            border-radius: 10px;
            margin: 0.3rem 0 0.6rem;
            padding: 0.4rem 0;
        }

        .mobile-accordion-content.open { display: flex; }

        .mobile-sub-item {
            padding: 0.55rem 1.2rem;
            color: #0f172a;
            font-size: 0.88rem;
            font-weight: 800;
            text-decoration: none;
        }

        .mobile-sub-item:hover { color: #05B396; }

        /* Buttons & Utility */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 0.65rem 1.4rem; font-size: 0.95rem; font-weight: 700; border-radius: 10px; cursor: pointer; text-decoration: none; border: none; transition: all 0.25s ease; }
        .btn-primary { background: #05B396; color: #fff; }
        .btn-secondary { background: rgba(0, 0, 0, 0.05); color: #000; border: 1px solid rgba(0,0,0,0.1); }
        .btn-success { background: var(--secondary-gradient); color: #fff; }

        .container { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem; }
        .text-gradient { background: linear-gradient(135deg, #05B396 0%, #0284c7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* Modals */
        .modal { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.7); display: none; align-items: center; justify-content: center; z-index: 9999; padding: 1rem; }
        .modal.active { display: flex; }
        .modal-box { width: 100%; max-width: 520px; padding: 2.2rem; border-radius: 16px; position: relative; background: #ffffff; border: 1px solid #e2e8f0; }
        .close-btn { position: absolute; top: 20px; right: 20px; background: transparent; border: none; color: #64748b; font-size: 1.6rem; cursor: pointer; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem; }
        .form-control { width: 100%; padding: 0.8rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; color: #0f172a; font-size: 0.95rem; outline: none; }
        .form-control:focus { border-color: #05B396; box-shadow: 0 0 0 3px rgba(5, 179, 150, 0.15); }

        .nav-right-actions {
            display: flex;
            gap: 0.85rem;
            align-items: center;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            header.nav { padding: 0.75rem 1.2rem; }
            nav.menu { display: none; }
            .mobile-toggle { display: flex; }
            .container { padding: 2.2rem 1rem; }
        }

        @media (max-width: 640px) {
            header.nav { padding: 0.65rem 0.85rem; }
            .brand-logo-img { height: 38px; }
            .nav-right-actions { gap: 0.45rem; }
            .sl-circle-badge { width: 32px; height: 32px; }
            .notification-bell-btn svg { width: 18px; height: 18px; }
            .bell-count-badge { font-size: 0.65rem; padding: 2px 5px; }
            .user-pill-btn { padding: 3px 10px 3px 4px; gap: 6px; }
            .user-pill-avatar { width: 26px; height: 26px; }
            .user-pill-name { max-width: 78px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.85rem; }
            .user-dropdown-card { right: 0; min-width: 195px; }
        }

        @media (max-width: 420px) {
            header.nav { padding: 0.55rem 0.6rem; }
            .brand-logo-img { height: 32px; }
            .nav-right-actions { gap: 0.35rem; }
            .user-pill-name { max-width: 55px; font-size: 0.78rem; }
            .sl-circle-badge { width: 28px; height: 28px; }
            .sl-circle-badge span { font-size: 0.72rem; }
            .bell-count-badge { display: none; }
            .mobile-toggle { width: 34px; height: 34px; padding: 4px; }
            .mobile-toggle .bar { width: 20px; }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body.is-portal-page {
            background-color: #f8fafc !important;
            color: #0f172a;
        }
    </style>
    @php
        $isPortalOrAdmin = request()->is('admin*') || request()->is('my-courses*') || request()->is('dashboard*') || request()->is('profile*') || request()->is('kyc*') || request()->is('affiliate*') || request()->is('token*') || request()->is('marketing*') || request()->is('my-payout*') || request()->is('leaderboard*') || request()->is('team-leaderboard*') || request()->is('qualification*') || request()->is('certificates*') || request()->is('social-community*');
    @endphp
    @include('portal.styles')
    @stack('styles')
</head>
<body class="{{ $isPortalOrAdmin ? 'is-portal-page' : '' }}">

    <!-- Notification Alert Banners -->
    @if(session('alert') === 'sale_added')
        <div style="background: var(--success); color: #fff; text-align: center; padding: 10px; font-weight: 700; font-size: 0.95rem;">
            🎉 Congratulations! New Direct Commission of ₹2,200 credited to your wallet!
        </div>
    @elseif(session('alert') === 'payout_success')
        <div style="background: var(--success); color: #fff; text-align: center; padding: 10px; font-weight: 700; font-size: 0.95rem;">
            ✅ Payout request submitted! Your funds will be transferred to your account within 24 hours.
        </div>
    @elseif(session('alert') === 'welcome')
        <div style="background: #05B396; color: #fff; text-align: center; padding: 10px; font-weight: 700; font-size: 0.95rem;">
            🚀 Welcome to SkillLearner! Your student dashboard is ready and all courses are unlocked.
        </div>
    @endif

    <!-- Top Navigation Bar (Matches Home Page Emerald Theme) -->
    <header class="nav">
        <!-- Logo: SkillLearner Official Logo -->
        <a href="{{ url('/') }}" class="brand" aria-label="SkillLearner Home">
            <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" class="brand-logo-img">
        </a>

        <!-- Desktop Navigation Menu (Matching Image 1: Home, About, Course Package, Contact, Courses, Job) -->
        <nav class="menu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>

            <!-- Course Package Dropdown -->
            <div class="nav-dropdown">
                <a href="{{ url('/plans') }}" class="dropdown-trigger {{ request()->is('plans*') || request()->is('programs*') ? 'active' : '' }}">
                    <span>Course Package</span>
                    <svg class="chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>
                <div class="dropdown-menu-box">
                    <a href="{{ url('/plans') }}#basic" class="dropdown-item-link">BASIC</a>
                    <a href="{{ url('/plans') }}#advance" class="dropdown-item-link">ADVANCE</a>
                    <a href="{{ url('/plans') }}#premium" class="dropdown-item-link">PREMIUM</a>
                    <a href="{{ url('/plans') }}#growth" class="dropdown-item-link">GROWTH</a>
                    <a href="{{ url('/plans') }}#infinity" class="dropdown-item-link">INFINITY</a>
                </div>
            </div>

            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            <a href="{{ url('/courses') }}" class="{{ request()->is('courses*') ? 'active' : '' }}">Courses</a>
            <a href="javascript:void(0)" onclick="alert('Placement & Freelance Job board unlocks upon course completion!')" class="{{ request()->is('job*') ? 'active' : '' }}">Job</a>
        </nav>

        <!-- Right Side: SL badge, Notification Bell with 4830, User Pill -->
        <div class="nav-right-actions">
            @if (session()->has('user'))
                <!-- SkillLearner Monogram Verified Badge -->
                <div class="sl-circle-badge" title="SkillLearner Verified Member">
                    <span style="font-weight: 900; font-size: 0.82rem; color: #05B396; letter-spacing: -0.5px;">SL</span>
                </div>

                <!-- Notification Bell with Emerald Badge 4830 -->
                <div class="notification-bell-btn" title="4,830 New Notifications" onclick="alert('You have 4,830 unread student notifications & community updates.')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="bell-count-badge">4830</span>
                </div>

                <!-- User Profile Pill Button with Dropdown -->
                @php
                    $hUserRole = Auth::user()?->role ?? session('user.role', 'user');
                    if (in_array($hUserRole, ['affiliate', 'student'])) { $hUserRole = 'user'; }
                @endphp
                <div class="user-menu-wrapper">
                    <button class="user-pill-btn" id="userMenuBtn" onclick="toggleUserMenu(event)">
                        <img src="{{ session('user.avatar', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80') }}" alt="{{ session('user.name', 'User') }}" class="user-pill-avatar">
                        <span class="user-pill-name">{{ session('user.name', 'User') }}</span>
                        @if ($hUserRole === 'super_admin')
                            <span style="font-size: 0.65rem; background: #7c3aed; color: #fff; font-weight: 800; padding: 2px 6px; border-radius: 10px;">SUPER</span>
                        @elseif ($hUserRole === 'admin')
                            <span style="font-size: 0.65rem; background: #0284c7; color: #fff; font-weight: 800; padding: 2px 6px; border-radius: 10px;">ADMIN</span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="user-dropdown-card" id="userDropdownCard">
                        @if ($hUserRole === 'super_admin' || $hUserRole === 'admin')
                            <div style="font-size: 0.68rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; padding: 0.4rem 1rem 0.2rem 1rem;">Admin Controls</div>
                            <a href="{{ url('/admin/users') }}" class="dropdown-link-item" style="color: #7c3aed; font-weight: 700;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span>All Users &amp; Roles</span>
                            </a>
                            <a href="{{ url('/admin/kyc-requests') }}" class="dropdown-link-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="m9 15 2 2 4-4"/></svg>
                                <span>KYC Approvals</span>
                            </a>
                            <a href="{{ url('/admin/payout-requests') }}" class="dropdown-link-item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M12 14v4"/><path d="m10 16 2-2 2 2"/></svg>
                                <span>Payout Approvals</span>
                            </a>
                            @if ($hUserRole === 'super_admin')
                                <a href="{{ url('/admin/settings') }}" class="dropdown-link-item" style="color: #05B396;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                    <span>System Settings</span>
                                </a>
                            @endif
                            <div style="border-top: 1px solid #f1f5f9; margin: 0.4rem 0;"></div>
                        @endif

                        <a href="{{ url('/profile') }}" class="dropdown-link-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ url('/my-courses') }}" class="dropdown-link-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            <span>My Courses</span>
                        </a>
                        <a href="{{ url('/certificates') }}" class="dropdown-link-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            <span>Certificates</span>
                        </a>
                        <a href="{{ url('/dashboard') }}" class="dropdown-link-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>Affiliate Panel</span>
                        </a>
                        <a href="{{ url('/my-payout') }}" class="dropdown-link-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                            <span>My Payout</span>
                        </a>
                        <div style="border-top: 1px solid #f1f5f9; margin: 0.4rem 0;"></div>
                        <a href="{{ url('/logout') }}" class="dropdown-link-item" style="color: #ef4444;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ url('/my-account') }}" class="btn btn-secondary" style="color: #0f172a; border-color: #cbd5e1; font-weight: 700;">My Account</a>
                <a href="{{ url('/buy-now') }}" class="btn btn-primary" style="background: #05B396; font-weight: 800;">Buy Now</a>
            @endif

            <!-- Mobile Hamburger Toggle Button (Always visible on mobile, turns into X when active) -->
            <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Navigation" onclick="window.toggleMobileMenu(event)">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>
    </header>

    <!-- Mobile Slide-In Drawer Navigation Backdrop -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="window.closeMobileMenu()"></div>

    <!-- Mobile Slide-In Drawer Navigation Menu -->
    <div class="mobile-drawer" id="mobileDrawer">
        <!-- Drawer Header with Logo & Close Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 0.8rem;">
            <a href="{{ url('/') }}" style="text-decoration: none; display: flex; align-items: center;">
                <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" style="height: 38px; width: auto; object-fit: contain;">
            </a>
            <button type="button" id="mobileCloseBtn" onclick="window.closeMobileMenu()" aria-label="Close Navigation" style="background: #f8fafc; border: 1px solid #e2e8f0; width: 32px; height: 32px; border-radius: 50%; font-size: 1.25rem; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">&times;</button>
        </div>

        @if (session()->has('user'))
            <!-- Logged In Student Profile Summary Box -->
            <div style="background: #f0fdfa; border: 1.5px solid #a7f3d0; border-radius: 14px; padding: 0.85rem; margin-bottom: 0.9rem; display: flex; align-items: center; gap: 10px;">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="{{ session('user.name', 'Vansh Tandon') }}" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #05B396; flex-shrink: 0;">
                <div style="min-width: 0; flex: 1;">
                    <div style="font-weight: 800; font-size: 0.95rem; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ session('user.name', 'Vansh Tandon') }}</div>
                    <div style="font-size: 0.72rem; color: #05B396; font-weight: 700;">{{ session('user.affiliate_id', 'SL-8821') }} • Verified ✅</div>
                    <div style="font-size: 0.75rem; color: #048873; font-weight: 700; margin-top: 2px;">Wallet: ₹{{ number_format(session('user.wallet_balance', 14200)) }}</div>
                </div>
            </div>

            <!-- Quick Action: Simulate Sale -->
            <a href="{{ url('/simulate-sale') }}" class="btn btn-primary" style="width: 100%; padding: 0.55rem; font-size: 0.82rem; background: linear-gradient(135deg, #05B396 0%, #048873 100%); margin-bottom: 0.8rem; border-radius: 8px;">
                ⚡ Simulate ₹2,200 New Sale
            </a>

            <!-- Section Title: Student Portal Tabs -->
            <div style="font-size: 0.72rem; font-weight: 800; color: #94a3b8; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 0.35rem; padding-left: 0.3rem;">
                STUDENT PORTAL (15 SECTIONS)
            </div>

            <div style="display: flex; flex-direction: column; gap: 2px;">
                <!-- 1. My Course -->
                <a href="{{ url('/my-courses') }}" id="mob-link-courses" class="mobile-portal-link {{ request()->is('my-courses*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                        <line x1="12" y1="18" x2="12.01" y2="18"></line>
                    </svg>
                    <span>My Course</span>
                </a>

                <!-- 2. Dashboard -->
                <a href="{{ url('/dashboard') }}" id="mob-link-dashboard" class="mobile-portal-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- 3. Profile -->
                <a href="{{ url('/profile') }}" id="mob-link-profile" class="mobile-portal-link {{ request()->is('profile*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile</span>
                </a>

                <!-- 4. Social Community -->
                <a href="{{ url('/social-community') }}" id="mob-link-community" class="mobile-portal-link {{ request()->is('social-community*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Social Community</span>
                </a>

                <!-- 5. Kyc -->
                <a href="{{ url('/kyc') }}" id="mob-link-kyc" class="mobile-portal-link {{ request()->is('kyc*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Kyc</span>
                </a>

                <!-- 6. Affiliate Link -->
                <a href="{{ url('/affiliate-link') }}" id="mob-link-affiliate-link" class="mobile-portal-link {{ request()->is('affiliate-link*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    <span>Affiliate Link</span>
                </a>

                <!-- 7. Token Purchases -->
                <a href="{{ url('/token-purchases') }}" id="mob-link-tokens" class="mobile-portal-link {{ request()->is('token-purchases*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span>Token Purchases</span>
                </a>

                <!-- 8. Affiliate Training -->
                <a href="{{ url('/affiliate-training') }}" id="mob-link-training" class="mobile-portal-link {{ request()->is('affiliate-training*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Affiliate Training</span>
                </a>

                <!-- 9. Upgrade -->
                <a href="{{ url('/plans') }}" class="mobile-portal-link {{ request()->is('plans*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    <span>Upgrade</span>
                </a>

                <!-- 10. Marketing Tool -->
                <a href="{{ url('/marketing-tool') }}" id="mob-link-marketing" class="mobile-portal-link {{ request()->is('marketing-tool*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    <span>Marketing Tool</span>
                </a>

                <!-- 11. My Payout -->
                <a href="{{ url('/my-payout') }}" id="mob-link-payout" class="mobile-portal-link {{ request()->is('my-payout*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                    <span>My Payout</span>
                </a>

                <!-- 12. Leaderboard -->
                <a href="{{ url('/leaderboard') }}" id="mob-link-leaderboard" class="mobile-portal-link {{ request()->is('leaderboard*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Leaderboard</span>
                </a>

                <!-- 13. Team Leaderboard -->
                <a href="{{ url('/team-leaderboard') }}" id="mob-link-team-leaderboard" class="mobile-portal-link {{ request()->is('team-leaderboard*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    <span>Team Leaderboard</span>
                </a>

                <!-- 14. Qualification -->
                <a href="{{ url('/qualification') }}" id="mob-link-qualification" class="mobile-portal-link {{ request()->is('qualification*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="7"></circle>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                    </svg>
                    <span>Qualification</span>
                </a>

                <!-- 15. Certificate -->
                <a href="{{ url('/certificates') }}" id="mob-link-certificate" class="mobile-portal-link {{ request()->is('certificates*') ? 'active' : '' }}">
                    <svg class="mob-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"></circle>
                        <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>
                    </svg>
                    <span>Certificate</span>
            </div>

            <!-- Website Navigation Accordion -->
            <div style="font-size: 0.72rem; font-weight: 800; color: #94a3b8; letter-spacing: 0.6px; text-transform: uppercase; margin: 1.2rem 0 0.35rem; padding-left: 0.3rem;">
                WEBSITE PAGES
            </div>

            <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="mobile-nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
            <a href="{{ url('/courses') }}" class="mobile-nav-link {{ request()->is('courses*') ? 'active' : '' }}">Courses Catalog</a>

            <div>
                <button class="mobile-accordion-btn" id="mobileCoursePackageBtn" onclick="toggleMobileAccordion(event)">
                    <span>Course Packages</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="mobile-accordion-content" id="mobileCoursePackageContent">
                    <a href="{{ url('/plans') }}#basic" class="mobile-sub-item">BASIC</a>
                    <a href="{{ url('/plans') }}#advance" class="mobile-sub-item">ADVANCE</a>
                    <a href="{{ url('/plans') }}#premium" class="mobile-sub-item">PREMIUM</a>
                    <a href="{{ url('/plans') }}#growth" class="mobile-sub-item">GROWTH</a>
                    <a href="{{ url('/plans') }}#infinity" class="mobile-sub-item">INFINITY</a>
                </div>
            </div>

            <a href="{{ url('/contact') }}" class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact Us</a>

            <div style="margin-top: 1.2rem; padding-top: 0.8rem; border-top: 1px solid #f1f5f9;">
                <a href="{{ url('/logout') }}" class="btn btn-secondary" style="width: 100%; color: #ef4444; border-color: rgba(239, 68, 68, 0.3); font-weight: 700;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Logout Account</span>
                </a>
            </div>
        @else
            <!-- Guest Navigation Links -->
            <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="mobile-nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
            <a href="{{ url('/courses') }}" class="mobile-nav-link {{ request()->is('courses*') ? 'active' : '' }}">Courses</a>
            
            <div>
                <button class="mobile-accordion-btn" id="mobileCoursePackageBtn" onclick="toggleMobileAccordion(event)">
                    <span>Course Package</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="mobile-accordion-content" id="mobileCoursePackageContent">
                    <a href="{{ url('/plans') }}#basic" class="mobile-sub-item">BASIC</a>
                    <a href="{{ url('/plans') }}#advance" class="mobile-sub-item">ADVANCE</a>
                    <a href="{{ url('/plans') }}#premium" class="mobile-sub-item">PREMIUM</a>
                    <a href="{{ url('/plans') }}#growth" class="mobile-sub-item">GROWTH</a>
                    <a href="{{ url('/plans') }}#infinity" class="mobile-sub-item">INFINITY</a>
                </div>
            </div>

            <a href="{{ url('/contact') }}" class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>

            <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.8rem;">
                <a href="{{ url('/my-account') }}" class="btn btn-secondary" style="width: 100%;">My Account</a>
                <a href="{{ url('/buy-now') }}" class="btn btn-primary" style="width: 100%; background: #05B396; font-weight: 800;">Buy Now</a>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    @if (! $isPortalOrAdmin)
    <!-- Footer matching AWS Live -->
    <footer style="border-top: 1px solid var(--border-glass); padding: 3rem 1.5rem; text-align: center; color: var(--text-body); font-size: 0.9rem; margin-top: 4rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" style="height: 48px; width: auto; object-fit: contain; margin-bottom: 1rem;">
            <p style="margin-bottom: 1rem;">SkillLearner — Build Skills, Build Future. Practical Video Masterclasses & Community Mentorship.</p>
            <p>© 2026 SkillLearner. All Rights Reserved.</p>
        </div>
    </footer>
    @endif

    <!-- Razorpay Simulated Modal (Available Globally) -->
    <div id="razorpayModal" class="modal">
        <div class="modal-box">
            <button class="close-btn" onclick="closeModal('razorpayModal')">&times;</button>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.2rem;">
                <span style="background: #0284c7; color: #fff; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 800;">Razorpay</span>
                <h3 style="font-size: 1.25rem;">Secure Checkout</h3>
            </div>
            
            <div style="background: rgba(0, 0, 0, 0.04); padding: 1rem; border-radius: 8px; margin-bottom: 1.4rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span id="rzpPackage" style="font-weight: 700; color: #0f172a;">Advance Package</span>
                    <span id="rzpPrice" style="color: #10b981; font-weight: 800; font-size: 1.1rem;">₹3,499</span>
                </div>
                <div style="font-size: 0.78rem; color: #64748b; margin-top: 4px;">Instant Activation & Lifetime Access</div>
            </div>

            <form onsubmit="handleMockPayment(event)">
                <div class="form-group">
                    <label>Select Payment Option</label>
                    <select class="form-control">
                        <option>UPI (Google Pay, PhonePe, Paytm)</option>
                        <option>Debit / Credit Card</option>
                        <option>Net Banking</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>UPI ID or Phone Number</label>
                    <input type="text" class="form-control" placeholder="yourname@okhdfcbank" required>
                </div>
                <button type="submit" id="rzpSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 0.85rem; background: #05B396; font-weight: 800;">
                    Pay & Complete Enrollment
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Global Mobile Navigation Handlers
        window.toggleMobileMenu = function(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            const btn = document.getElementById('mobileMenuBtn');
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileDrawer');
            
            const isOpen = drawer && drawer.classList.contains('active');
            
            if (isOpen) {
                window.closeMobileMenu();
            } else {
                window.openMobileMenu();
            }
        };

        window.openMobileMenu = function() {
            const btn = document.getElementById('mobileMenuBtn');
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileDrawer');
            if (btn) btn.classList.add('active');
            if (overlay) overlay.classList.add('active');
            if (drawer) drawer.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.closeMobileMenu = function() {
            const btn = document.getElementById('mobileMenuBtn');
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileDrawer');
            if (btn) btn.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            if (drawer) drawer.classList.remove('active');
            document.body.style.overflow = '';
        };

        window.toggleMobileAccordion = function(e) {
            if (e) e.preventDefault();
            const btn = document.getElementById('mobileCoursePackageBtn');
            const content = document.getElementById('mobileCoursePackageContent');
            if (btn) btn.classList.toggle('open');
            if (content) content.classList.toggle('open');
        };

        window.mobileSwitchPortalTab = function(tabId) {
            window.closeMobileMenu();
            if (window.location.pathname.includes('/dashboard')) {
                if (typeof window.switchPortalTab === 'function') {
                    window.switchPortalTab(tabId);
                }
            } else {
                window.location.href = "{{ url('/dashboard') }}?tab=" + tabId;
            }
        };

        // Close drawer on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                window.closeMobileMenu();
                const card = document.getElementById('userDropdownCard');
                if (card) card.classList.remove('active');
            }
        });

        // User Profile Dropdown Toggle (Image 2)
        function toggleUserMenu(e) {
            e.stopPropagation();
            const card = document.getElementById('userDropdownCard');
            if (card) card.classList.toggle('active');
        }

        // Close dropdown when clicking anywhere outside
        document.addEventListener('click', (e) => {
            const card = document.getElementById('userDropdownCard');
            const btn = document.getElementById('userMenuBtn');
            if (card && card.classList.contains('active')) {
                if (btn && !btn.contains(e.target) && !card.contains(e.target)) {
                    card.classList.remove('active');
                }
            }
        });

        // Modal Handlers
        function openModal(id) {
            const m = document.getElementById(id);
            if (m) m.classList.add('active');
        }

        function closeModal(id) {
            const m = document.getElementById(id);
            if (m) m.classList.remove('active');
        }

        function openCheckout(name, price) {
            const pkg = document.getElementById('rzpPackage');
            const pr = document.getElementById('rzpPrice');
            if (pkg) pkg.innerText = name;
            if (pr) pr.innerText = '₹' + Number(price).toLocaleString('en-IN');
            openModal('razorpayModal');
        }

        function handleMockPayment(e) {
            e.preventDefault();
            const btn = document.getElementById('rzpSubmitBtn');
            btn.innerText = 'Connecting to Razorpay...';
            btn.disabled = true;

            setTimeout(() => {
                alert('🎉 Payment Successful!\nPackage activated and sponsor commission credited.');
                closeModal('razorpayModal');
                btn.innerText = 'Pay & Complete Enrollment';
                btn.disabled = false;
                window.location.href = "{{ url('/dashboard') }}?alert=welcome";
            }, 1500);
        }
    </script>
    @stack('scripts')
</body>
</html>
