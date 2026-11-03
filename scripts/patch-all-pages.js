import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const pagesDir = path.resolve(__dirname, 'pages');

const portalPages = [
    'classroom',
    'my-courses',
    'dashboard',
    'profile',
    'social-community',
    'kyc',
    'affiliate-link',
    'token-purchases',
    'affiliate-training',
    'marketing-tool',
    'my-payout',
    'leaderboard',
    'team-leaderboard',
    'qualification',
    'certificates'
];

const extraStyles = `
        /* Dual Mobile Drawers (Left Website Nav | Right Student Portal) */
        .mobile-drawer-left {
            left: -340px !important;
            right: auto !important;
            border-right: 1px solid #e2e8f0;
            transition: left 0.32s cubic-bezier(0.16, 1, 0.3, 1) !important;
            box-shadow: 15px 0 40px rgba(0, 0, 0, 0.18) !important;
        }
        .mobile-drawer-left.active {
            left: 0 !important;
        }
        .mobile-drawer-right {
            right: -340px !important;
            left: auto !important;
            border-left: 1px solid #e2e8f0;
            transition: right 0.32s cubic-bezier(0.16, 1, 0.3, 1) !important;
            box-shadow: -15px 0 40px rgba(0, 0, 0, 0.18) !important;
        }
        .mobile-drawer-right.active {
            right: 0 !important;
        }
        .mobile-left-toggle {
            display: none;
        }
        .mobile-portal-toggle-btn {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 2px;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: transform 0.15s ease;
            flex-shrink: 0;
        }
        .mobile-portal-toggle-btn:active {
            transform: scale(0.92);
        }
        .mobile-portal-nav {
            display: none !important;
        }
        @media (max-width: 992px) {
            .mobile-toggle { display: flex !important; }
            .mobile-left-toggle { display: flex !important; }
            .mobile-portal-toggle-btn { display: flex !important; }
            .notification-bell-btn { display: none !important; }
            .user-menu-wrapper { display: none !important; }
            .sl-circle-badge { display: none !important; }
            .mobile-portal-nav { display: none !important; }
            header.nav { padding: 0.65rem 1rem !important; }
            nav.menu { display: none !important; }
        }
        @media (max-width: 640px) {
            .notification-bell-btn { display: none !important; }
            .user-menu-wrapper { display: none !important; }
            .sl-circle-badge { display: none !important; }
            .mobile-portal-nav { display: none !important; }
            .mobile-left-toggle { display: flex !important; }
            .mobile-portal-toggle-btn { display: flex !important; }
            header.nav { padding: 0.5rem 0.65rem !important; }
            .brand-logo-img { max-width: 125px !important; }
        }
`;

const jsDrawerScripts = `
    <script>
        // Dual Mobile Drawer System
        window.toggleLeftDrawer = function(e) {
            if (e) { e.preventDefault(); e.stopPropagation(); }
            const drawer = document.getElementById('mobileLeftDrawer');
            if (drawer && drawer.classList.contains('active')) {
                window.closeLeftDrawer();
            } else {
                window.closeRightDrawer();
                window.openLeftDrawer();
            }
        };

        window.openLeftDrawer = function() {
            const btn = document.getElementById('mobileLeftMenuBtn');
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileLeftDrawer');
            if (btn) btn.classList.add('active');
            if (overlay) overlay.classList.add('active');
            if (drawer) drawer.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.closeLeftDrawer = function() {
            const btn = document.getElementById('mobileLeftMenuBtn');
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileLeftDrawer');
            if (btn) btn.classList.remove('active');
            if (drawer) drawer.classList.remove('active');
            const rightDrawer = document.getElementById('mobileDrawer');
            if (!rightDrawer || !rightDrawer.classList.contains('active')) {
                if (overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        };

        window.toggleRightDrawer = function(e) {
            if (e) { e.preventDefault(); e.stopPropagation(); }
            const drawer = document.getElementById('mobileDrawer');
            if (drawer && drawer.classList.contains('active')) {
                window.closeRightDrawer();
            } else {
                window.closeLeftDrawer();
                window.openRightDrawer();
            }
        };

        window.openRightDrawer = function() {
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileDrawer');
            if (overlay) overlay.classList.add('active');
            if (drawer) drawer.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.closeRightDrawer = function() {
            const overlay = document.getElementById('mobileOverlay');
            const drawer = document.getElementById('mobileDrawer');
            if (drawer) drawer.classList.remove('active');
            const leftDrawer = document.getElementById('mobileLeftDrawer');
            if (!leftDrawer || !leftDrawer.classList.contains('active')) {
                if (overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        };

        window.closeAllMobileDrawers = function() {
            const leftDrawer = document.getElementById('mobileLeftDrawer');
            const rightDrawer = document.getElementById('mobileDrawer');
            const overlay = document.getElementById('mobileOverlay');
            const btn = document.getElementById('mobileLeftMenuBtn');
            const legacyBtn = document.getElementById('mobileMenuBtn');
            if (leftDrawer) leftDrawer.classList.remove('active');
            if (rightDrawer) rightDrawer.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            if (btn) btn.classList.remove('active');
            if (legacyBtn) legacyBtn.classList.remove('active');
            document.body.style.overflow = '';
        };

        window.toggleMobileMenu = function(e) { window.toggleRightDrawer(e); };
        window.openMobileMenu = function() { window.openRightDrawer(); };
        window.closeMobileMenu = function() { window.closeRightDrawer(); };
        window.toggleWebsiteDrawer = function(e) { window.toggleLeftDrawer(e); };
        window.openWebsiteDrawer = function() { window.openLeftDrawer(); };
        window.closeWebsiteDrawer = function() { window.closeLeftDrawer(); };

        window.toggleMobileAccordion = function(e) {
            if (e) e.preventDefault();
            const btn = document.getElementById('mobileCoursePackageBtn');
            const content = document.getElementById('mobileCoursePackageContent');
            if (btn) btn.classList.toggle('open');
            if (content) content.classList.toggle('open');
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.closeAllMobileDrawers();
            }
        });
    </script>
`;

function buildLeftDrawer(isPortal, fileKey) {
    const isHome = fileKey === 'index';
    const isAbout = fileKey === 'about';
    const isContact = fileKey === 'contact';
    const isCourses = fileKey === 'courses';
    const isPackage = ['plans', 'buy-now', 'programs'].includes(fileKey);

    return `
    <!-- Left Slide-In Drawer: Main Website Navigation (Matches User Screenshot: Home, About, Package, Contact, Courses, Job) -->
    <div class="mobile-drawer mobile-drawer-left" id="mobileLeftDrawer">
        <!-- Drawer Header with Logo & Close Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 0.8rem;">
            <a href="/" style="text-decoration: none; display: flex; align-items: center;">
                <img src="/images/logo.png" alt="SkillLearner" style="width: auto; max-width: 140px; object-fit: contain;">
            </a>
            <button type="button" id="mobileLeftCloseBtn" onclick="window.closeLeftDrawer()" aria-label="Close Navigation" style="background: #f8fafc; border: 1px solid #e2e8f0; width: 32px; height: 32px; border-radius: 50%; font-size: 1.25rem; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">&times;</button>
        </div>

        <!-- Main Website Navigation -->
        <div style="display: flex; flex-direction: column; gap: 2px;">
            <a href="/" class="mobile-nav-link ${isHome ? 'active' : ''}">Home</a>
            <a href="/about" class="mobile-nav-link ${isAbout ? 'active' : ''}">About</a>

            <!-- Package Accordion -->
            <div>
                <button type="button" class="mobile-accordion-btn" id="mobileCoursePackageBtn" onclick="window.toggleMobileAccordion(event)">
                    <span style="${isPackage ? 'color: #05B396;' : ''}">Package</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="mobile-accordion-content" id="mobileCoursePackageContent">
                    <a href="/buy-now?package=basic" class="mobile-sub-item">Basic</a>
                    <a href="/buy-now?package=growth" class="mobile-sub-item">Growth</a>
                    <a href="/buy-now?package=advance" class="mobile-sub-item">Advance</a>
                    <a href="/buy-now?package=premium" class="mobile-sub-item">Premium</a>
                    <a href="/buy-now?package=infinity" class="mobile-sub-item">Infinity</a>
                </div>
            </div>

            <a href="/contact" class="mobile-nav-link ${isContact ? 'active' : ''}">Contact</a>
            <a href="/courses" class="mobile-nav-link ${isCourses ? 'active' : ''}">Courses</a>
            <a href="javascript:void(0)" onclick="alert('Placement & Freelance Job board unlocks upon course completion!')" class="mobile-nav-link">Job</a>
        </div>

        ${isPortal ? `
        <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
            <button type="button" onclick="window.closeLeftDrawer(); window.openRightDrawer();" class="btn btn-secondary" style="width: 100%; font-weight: 700; color: #05B396; border-color: #05B396;">
                <span>Open Student Portal &rarr;</span>
            </button>
        </div>` : `
        <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 0.6rem;">
            <a href="/my-account" class="btn btn-primary" style="width: 100%; text-align: center; justify-content: center;">Login / My Account</a>
            <a href="/register" class="btn btn-secondary" style="width: 100%; text-align: center; justify-content: center;">Register</a>
        </div>`}
    </div>
    `;
}

const files = fs.readdirSync(pagesDir).filter(f => f.endsWith('.html'));

console.log(`Processing ${files.length} pages in scripts/pages/...`);

for (const file of files) {
    const fileKey = file.replace('.html', '');
    const isPortal = portalPages.includes(fileKey);
    const filePath = path.join(pagesDir, file);
    let html = fs.readFileSync(filePath, 'utf-8');

    // 1. Inject extra dual-drawer CSS before </style> if not already present
    if (!html.includes('.mobile-drawer-left')) {
        html = html.replace('</style>', `${extraStyles}\n    </style>`);
    }

    // 2. Ensure Left Hamburger Toggle is inside header left brand area
    if (!html.includes('id="mobileLeftMenuBtn"')) {
        // Find <header class="nav"> and wrap logo with left hamburger button
        const oldBrandRegex = /(<header[^>]*>[\s\S]*?)(<a\s+href="[^"]*"\s+class="brand"[^>]*>[\s\S]*?<\/a>)/i;
        if (oldBrandRegex.test(html)) {
            html = html.replace(oldBrandRegex, `$1<div style="display: flex; align-items: center; gap: 6px;">
            <button class="mobile-toggle mobile-left-toggle" id="mobileLeftMenuBtn" aria-label="Toggle Website Navigation" onclick="window.toggleLeftDrawer(event)" title="Website Menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            $2
        </div>`);
        }
    }

    // 3. Ensure Right Mobile Portal / Guest Button is inside nav-right-actions
    if (!html.includes('id="mobilePortalToggleBtn"') && !html.includes('id="mobileGuestToggleBtn"')) {
        const portalToggleBtn = isPortal ? `
            <!-- Mobile Student Portal Button (Visible only on mobile <= 992px) -->
            <button class="mobile-portal-toggle-btn" id="mobilePortalToggleBtn" onclick="window.toggleRightDrawer(event)" aria-label="Student Portal" title="Open Student Portal">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Vansh Tandon" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #05B396; display: block;">
            </button>` : `
            <!-- Mobile Guest Account Button (Visible only on mobile <= 992px) -->
            <button class="mobile-portal-toggle-btn" id="mobileGuestToggleBtn" onclick="window.toggleRightDrawer(event)" aria-label="Account Menu" title="Login / Register">
                <div style="width: 34px; height: 34px; border-radius: 50%; background: #f1f5f9; border: 1.5px solid #cbd5e1; display: flex; align-items: center; justify-content: center; color: #475569;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </button>`;

        // Insert before legacy mobileMenuBtn or before </header>
        if (html.includes('id="mobileMenuBtn"')) {
            html = html.replace(/<button[^>]*id="mobileMenuBtn"[^>]*>[\s\S]*?<\/button>/i, `${portalToggleBtn}
            <button class="mobile-toggle" id="mobileMenuBtn" aria-label="Toggle Navigation" onclick="window.toggleRightDrawer(event)" style="display: none;">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>`);
        }
    }

    // 4. Clean up Backdrop Overlay
    html = html.replace(/<div class="mobile-overlay"[^>]*><\/div>/g, '<div class="mobile-overlay" id="mobileOverlay" onclick="window.closeAllMobileDrawers()"></div>');

    // 5. Update or insert #mobileLeftDrawer
    if (!html.includes('id="mobileLeftDrawer"')) {
        const leftDrawerHtml = buildLeftDrawer(isPortal, fileKey);
        // Insert right after mobileOverlay
        html = html.replace('<div class="mobile-overlay" id="mobileOverlay" onclick="window.closeAllMobileDrawers()"></div>', `<div class="mobile-overlay" id="mobileOverlay" onclick="window.closeAllMobileDrawers()"></div>\n${leftDrawerHtml}`);
    }

    // 6. Ensure #mobileDrawer has class "mobile-drawer mobile-drawer-right" and close button calls window.closeRightDrawer()
    html = html.replace(/class="mobile-drawer(?!\s+mobile-drawer-right)"/g, 'class="mobile-drawer mobile-drawer-right"');
    html = html.replace(/onclick="window\.closeMobileMenu\(\)"/g, 'onclick="window.closeRightDrawer()"');

    // In portal pages, if #mobileDrawer still has the website links (Home, About, Package, etc.), remove them so it's strictly the Student Portal!
    if (isPortal) {
        // If #mobileDrawer contains "Main Website Navigation", remove that block from #mobileDrawer
        const mobDrawerStart = html.indexOf('<div class="mobile-drawer mobile-drawer-right" id="mobileDrawer">');
        if (mobDrawerStart !== -1) {
            const drawerContent = html.substring(mobDrawerStart);
            const websiteNavComment = '<!-- Main Website Navigation';
            if (drawerContent.includes(websiteNavComment)) {
                // Find where Student Portal or profile summary starts
                const portalSummaryIndex = drawerContent.indexOf('<!-- Logged In Student Profile Summary Box -->');
                const portalAltIndex = drawerContent.indexOf('<!-- Section Title: Student Portal Tabs -->');
                const cutoff = portalSummaryIndex !== -1 ? portalSummaryIndex : portalAltIndex;
                if (cutoff !== -1) {
                    const drawerHeader = `<!-- Drawer Header with Title & Close Button -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 0.8rem;">
            <div style="font-weight: 800; font-size: 0.95rem; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                <span>Student Portal</span>
            </div>
            <button type="button" id="mobileCloseBtn" onclick="window.closeRightDrawer()" aria-label="Close Navigation" style="background: #f8fafc; border: 1px solid #e2e8f0; width: 32px; height: 32px; border-radius: 50%; font-size: 1.25rem; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">&times;</button>
        </div>\n        `;
                    const newDrawerHtml = `<div class="mobile-drawer mobile-drawer-right" id="mobileDrawer">\n        ${drawerHeader}${drawerContent.substring(cutoff)}`;
                    html = html.substring(0, mobDrawerStart) + newDrawerHtml;
                }
            }
        }
    }

    // 7. Inject JS scripts if window.toggleLeftDrawer is not present
    if (!html.includes('window.toggleLeftDrawer')) {
        html = html.replace('</body>', `${jsDrawerScripts}\n</body>`);
    }

    fs.writeFileSync(filePath, html, 'utf-8');
    console.log(`✅ Patched: ${file}`);
}

console.log('🎉 All files in scripts/pages/ successfully updated with dual mobile drawers!');

