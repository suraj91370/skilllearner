<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CareerFixx — Learn, Create, Monetize')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-body: #070a12;
            --bg-card: rgba(15, 23, 42, 0.75);
            --bg-card-hover: rgba(30, 41, 59, 0.85);
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-accent: rgba(99, 102, 241, 0.35);
            --text-title: #f8fafc;
            --text-body: #94a3b8;
            --primary: #a855f7;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #d946ef 100%);
            --secondary-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --success: #10b981;
            --gold: #f59e0b;
            --danger: #ef4444;
            --radius-md: 14px;
            --radius-lg: 22px;
            --shadow-glow: 0 0 35px rgba(99, 102, 241, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-title); line-height: 1.6; overflow-x: hidden; padding-bottom: 70px; }
        .glass { background: var(--bg-card); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); border: 1px solid var(--border-glass); border-radius: var(--radius-md); }
        
        /* Navigation Bar (Desktop) */
        header.nav { 
            position: sticky; 
            top: 0; 
            z-index: 999; 
            padding: 1rem 2.5rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 1px solid var(--border-glass); 
            background: rgba(7, 10, 18, 0.92); 
            backdrop-filter: blur(16px); 
        }

        .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: #fff; font-weight: 800; font-size: 1.45rem; }
        .brand-badge { background: var(--primary-gradient); color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; }
        
        nav.menu { display: flex; gap: 2rem; align-items: center; }
        nav.menu > a { 
            color: var(--text-body); 
            text-decoration: none; 
            font-size: 1rem; 
            font-weight: 600; 
            transition: color 0.2s ease; 
        }
        nav.menu > a:hover, nav.menu > a.active { color: #fff; }

        /* Course Package Dropdown (Desktop Hover) */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #c084fc;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.5rem 0;
            transition: all 0.2s ease;
        }

        .dropdown-trigger svg.chevron {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            stroke: #c084fc;
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
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35), 0 5px 15px rgba(0, 0, 0, 0.15);
            padding: 0.9rem 0;
            margin-top: 0.6rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1000;
        }

        .dropdown-menu-box::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            width: 100%;
            height: 10px;
        }

        .nav-dropdown:hover .dropdown-menu-box {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item-link {
            display: block;
            padding: 0.7rem 1.6rem;
            color: #0f172a;
            font-size: 0.92rem;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 0.8px;
            transition: all 0.18s ease;
        }

        .dropdown-item-link:hover {
            color: #9333ea;
            background: #f5f3ff;
            padding-left: 1.9rem;
        }

        .nav-btns { display: flex; gap: 1rem; align-items: center; }

        /* Mobile Hamburger Toggle */
        .mobile-toggle {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            z-index: 1001;
        }

        .mobile-toggle .bar {
            width: 25px;
            height: 2.5px;
            background-color: #fff;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .mobile-toggle.active .bar:nth-child(1) {
            transform: translateY(7.5px) rotate(45deg);
        }
        .mobile-toggle.active .bar:nth-child(2) {
            opacity: 0;
        }
        .mobile-toggle.active .bar:nth-child(3) {
            transform: translateY(-7.5px) rotate(-45deg);
        }

        /* Mobile Backdrop Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(6px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Slide-In Drawer */
        .mobile-drawer {
            position: fixed;
            top: 0;
            right: -320px;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            background: #0b1120;
            border-left: 1px solid var(--border-glass);
            z-index: 1002;
            padding: 4.5rem 1.8rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            overflow-y: auto;
            transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: -15px 0 40px rgba(0, 0, 0, 0.6);
        }

        .mobile-drawer.active {
            right: 0;
        }

        .mobile-nav-link {
            color: #e2e8f0;
            font-size: 1.05rem;
            font-weight: 700;
            text-decoration: none;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: block;
        }

        .mobile-nav-link:hover, .mobile-nav-link.active {
            color: #c084fc;
        }

        /* Mobile Accordion for Course Package */
        .mobile-accordion-btn {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            color: #c084fc;
            font-size: 1.05rem;
            font-weight: 700;
            padding: 0.75rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            text-align: left;
        }

        .mobile-accordion-btn svg {
            transition: transform 0.25s ease;
            stroke: #c084fc;
        }

        .mobile-accordion-btn.open svg {
            transform: rotate(180deg);
        }

        .mobile-accordion-content {
            display: none;
            flex-direction: column;
            background: #ffffff; /* White background matching dropdown card */
            border-radius: 12px;
            margin: 0.4rem 0 0.8rem;
            padding: 0.5rem 0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .mobile-accordion-content.open {
            display: flex;
        }

        .mobile-sub-item {
            padding: 0.65rem 1.4rem;
            color: #0f172a;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.6px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .mobile-sub-item:hover {
            background: #f3e8ff;
            color: #9333ea;
        }
        
        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 0.65rem 1.4rem; font-size: 0.95rem; font-weight: 700; border-radius: 10px; cursor: pointer; text-decoration: none; border: none; transition: all 0.25s ease; }
        .btn-primary { background: var(--primary-gradient); color: #fff; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(99, 102, 241, 0.55); }
        .btn-secondary { background: rgba(255, 255, 255, 0.07); color: #fff; border: 1px solid var(--border-glass); }
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.14); }
        .btn-success { background: var(--secondary-gradient); color: #fff; }

        .container { max-width: 1200px; margin: 0 auto; padding: 4.5rem 2rem; }
        .text-gradient { background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* Floating Admin & Demo Bar */
        .demo-bar { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(15, 23, 42, 0.95); border-top: 1px solid rgba(99, 102, 241, 0.4); padding: 0.8rem 2rem; display: flex; justify-content: space-between; align-items: center; z-index: 1000; backdrop-filter: blur(12px); }
        .demo-bar-actions { display: flex; gap: 0.8rem; align-items: center; }

        /* Modals */
        .modal { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.75); display: none; align-items: center; justify-content: center; z-index: 9999; padding: 1rem; }
        .modal.active { display: flex; }
        .modal-box { width: 100%; max-width: 520px; padding: 2.2rem; border-radius: var(--radius-lg); position: relative; background: #0f172a; border: 1px solid var(--border-accent); }
        .close-btn { position: absolute; top: 20px; right: 20px; background: transparent; border: none; color: var(--text-body); font-size: 1.6rem; cursor: pointer; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-body); margin-bottom: 0.4rem; }
        .form-control { width: 100%; padding: 0.8rem 1rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-glass); border-radius: 8px; color: #fff; font-size: 0.95rem; outline: none; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25); }

        table.custom-table { width: 100%; border-collapse: collapse; font-size: 0.92rem; text-align: left; }
        table.custom-table th { padding: 10px; color: var(--text-body); border-bottom: 1px solid var(--border-glass); font-weight: 600; }
        table.custom-table td { padding: 12px 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.04); }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            header.nav { padding: 0.9rem 1.4rem; }
            nav.menu { display: none; }
            .nav-btns { display: none; }
            .mobile-toggle { display: flex; }
            .container { padding: 3rem 1.2rem; }
            .demo-bar { flex-direction: column; gap: 0.6rem; text-align: center; padding: 0.8rem 1rem; }
        }

        @media (max-width: 600px) {
            .brand { font-size: 1.25rem; }
            .hero h1 { font-size: 2.3rem !important; }
            .hero p { font-size: 1.05rem !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

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
        <div style="background: var(--primary); color: #fff; text-align: center; padding: 10px; font-weight: 700; font-size: 0.95rem;">
            🚀 Welcome to CareerFixx! Your package is active and your referral system is live.
        </div>
    @endif

    <!-- Top Navigation Bar -->
    <header class="nav">
        <a href="{{ url('/') }}" class="brand">
            <span class="brand-badge">CFX</span>
            <span>Career<strong class="text-gradient">Fixx</strong></span>
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="menu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>

            <!-- Course Package Dropdown with Arrow (Matching User's Image) -->
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
                    <a href="{{ url('/plans') }}#permium" class="dropdown-item-link">PREMIUM</a>
                    <a href="{{ url('/plans') }}#growth" class="dropdown-item-link">GROWTH</a>
                    <a href="{{ url('/plans') }}#infinity" class="dropdown-item-link">INFINITY</a>
                </div>
            </div>

            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        <!-- Desktop Action Buttons -->
        <div class="nav-btns">
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary">My Account</a>
            <a href="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'CFX-ADMIN') }}" class="btn btn-primary">Enroll Now</a>
        </div>

        <!-- Mobile Hamburger Toggle Button -->
        <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Navigation">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </header>

    <!-- Mobile Slide-In Drawer Navigation -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-drawer" id="mobileDrawer">
        <a href="{{ url('/') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ url('/about') }}" class="mobile-nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
        
        <!-- Mobile Accordion for Course Package -->
        <div>
            <button class="mobile-accordion-btn" id="mobileCoursePackageBtn">
                <span>Course Package</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="mobile-accordion-content" id="mobileCoursePackageContent">
                <a href="{{ url('/plans') }}#basic" class="mobile-sub-item">BASIC</a>
                <a href="{{ url('/plans') }}#advance" class="mobile-sub-item">ADVANCE</a>
                <a href="{{ url('/plans') }}#permium" class="mobile-sub-item">PREMIUM</a>
                <a href="{{ url('/plans') }}#growth" class="mobile-sub-item">GROWTH</a>
                <a href="{{ url('/plans') }}#infinity" class="mobile-sub-item">INFINITY</a>
            </div>
        </div>

        <a href="{{ url('/contact') }}" class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>

        <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.8rem;">
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary" style="width: 100%;">My Account</a>
            <a href="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'CFX-ADMIN') }}" class="btn btn-primary" style="width: 100%;">Enroll Now</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Razorpay Simulated Modal (Available Globally) -->
    <div id="razorpayModal" class="modal">
        <div class="modal-box">
            <button class="close-btn" onclick="closeModal('razorpayModal')">&times;</button>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.2rem;">
                <span style="background: #0284c7; color: #fff; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 800;">Razorpay</span>
                <h3 style="font-size: 1.25rem;">Secure Checkout</h3>
            </div>
            
            <div style="background: rgba(255, 255, 255, 0.05); padding: 1rem; border-radius: 8px; margin-bottom: 1.4rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span id="rzpPackage" style="font-weight: 700;">Advance Package</span>
                    <span id="rzpPrice" style="color: var(--success); font-weight: 800; font-size: 1.1rem;">₹3,499</span>
                </div>
                <div style="font-size: 0.78rem; color: var(--text-body); margin-top: 4px;">Instant Activation & Lifetime Access</div>
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
                <button type="submit" id="rzpSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 0.85rem;">
                    Pay & Complete Enrollment
                </button>
            </form>
        </div>
    </div>

    <!-- Floating Quick Actions Bar -->
    <div class="demo-bar">
        <div style="font-size: 0.88rem; color: #cbd5e1;">
            💡 <strong>CareerFixx Laravel Engine:</strong> Logged in as <strong>{{ session('user.name', 'Suraj Sharma') }}</strong> (Wallet: <span style="color: var(--success); font-weight: 700;">₹{{ number_format(session('user.wallet_balance', 14200)) }}</span>)
        </div>
        <div class="demo-bar-actions">
            <a href="{{ url('/simulate-sale') }}" class="btn btn-success" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">+ Simulate Sale (+₹2,200)</a>
            <a href="{{ url('/classroom') }}" class="btn btn-secondary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">Test LMS Video</a>
            <a href="{{ url('/reset-demo') }}" class="btn btn-secondary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem; color: #f87171;">Reset Data</a>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
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

        // --- Mobile Menu Toggle & Accordion Logic ---
        document.addEventListener('DOMContentLoaded', () => {
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileDrawer = document.getElementById('mobileDrawer');
            const accordionBtn = document.getElementById('mobileCoursePackageBtn');
            const accordionContent = document.getElementById('mobileCoursePackageContent');

            function toggleMobileMenu() {
                mobileBtn.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                mobileDrawer.classList.toggle('active');
            }

            if (mobileBtn) mobileBtn.addEventListener('click', toggleMobileMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', toggleMobileMenu);

            if (accordionBtn && accordionContent) {
                accordionBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    accordionBtn.classList.toggle('open');
                    accordionContent.classList.toggle('open');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
