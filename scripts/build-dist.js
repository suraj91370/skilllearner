import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const rootDir = path.resolve(__dirname, '..');
const distDir = path.resolve(rootDir, 'dist');
const publicDir = path.resolve(rootDir, 'public');

console.log('🚀 Starting static build for AWS Amplify...');

// 1. Ensure dist directory
if (fs.existsSync(distDir)) {
    fs.rmSync(distDir, { recursive: true, force: true });
}
fs.mkdirSync(distDir, { recursive: true });

// 2. Copy public directory to dist (images, build, favicon, etc.)
function copyRecursiveSync(src, dest) {
    const exists = fs.existsSync(src);
    const stats = exists && fs.statSync(src);
    const isDirectory = exists && stats.isDirectory();
    if (isDirectory) {
        if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
        fs.readdirSync(src).forEach((childItemName) => {
            copyRecursiveSync(path.join(src, childItemName), path.join(dest, childItemName));
        });
    } else if (exists) {
        fs.copyFileSync(src, dest);
    }
}

copyRecursiveSync(publicDir, distDir);
console.log('✅ Copied public assets to dist/');

// 3. Layout Header & Footer Templates
const getHtml = (title, content, activePage = '') => `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${title} — Skillleaner</title>
    
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
            background: #b8e1d3; 
            backdrop-filter: blur(16px); 
        }

        .brand { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            text-decoration: none; 
            color: #000; 
            font-size: 1.35rem; 
            font-weight: 800; 
            letter-spacing: -0.5px; 
        }
        .brand-logo-img { height: 44px; width: auto; object-fit: contain; }
        .nav-links { display: flex; gap: 1.8rem; align-items: center; }
        .nav-links a { 
            color: #000000; 
            text-decoration: none; 
            font-size: 0.95rem; 
            font-weight: 600; 
            transition: color 0.2s; 
        }
        .nav-links a:hover, .nav-links a.active { color: #05B396; }

        /* Course Package Hover Dropdown (Desktop) */
        .dropdown-wrapper { position: relative; display: inline-block; }
        .dropdown-trigger { display: flex; align-items: center; gap: 4px; cursor: pointer; color: #000000 !important; font-weight: 600; font-size: 0.95rem; }
        .dropdown-trigger:hover { color: #05B396 !important; }
        .dropdown-menu-box {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(15, 23, 42, 0.96);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 0.5rem 0;
            min-width: 170px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .dropdown-wrapper:hover .dropdown-menu-box { display: block; }
        .dropdown-item-link {
            display: block;
            padding: 0.65rem 1.2rem;
            color: #f8fafc !important;
            font-size: 0.88rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px;
            transition: all 0.2s;
        }
        .dropdown-item-link:hover {
            background: rgba(5, 179, 150, 0.18);
            color: #05B396 !important;
            padding-left: 1.45rem;
        }

        /* Buttons */
        .btn { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px; 
            padding: 0.65rem 1.35rem; 
            border-radius: var(--radius-md); 
            font-weight: 700; 
            text-decoration: none; 
            font-size: 0.92rem; 
            cursor: pointer; 
            border: none; 
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); 
        }
        .btn-primary { 
            background: var(--primary-gradient); 
            color: #fff; 
            box-shadow: 0 4px 15px rgba(5, 179, 150, 0.35); 
        }
        .btn-primary:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 6px 22px rgba(5, 179, 150, 0.5); 
        }
        .btn-secondary { 
            background: rgba(255, 255, 255, 0.05); 
            color: var(--text-title); 
            border: 1px solid var(--border-glass); 
        }
        .btn-secondary:hover { 
            background: rgba(255, 255, 255, 0.12); 
            transform: translateY(-2px); 
        }

        /* Mobile Hamburger & Slide-in Drawer */
        .mobile-toggle-btn {
            display: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            flex-direction: column;
            gap: 5px;
        }
        .mobile-toggle-btn span {
            display: block;
            width: 24px;
            height: 2.5px;
            background: #000;
            border-radius: 2px;
            transition: all 0.3s;
        }
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1001;
        }
        .mobile-overlay.active { display: block; }
        .mobile-drawer {
            position: fixed;
            top: 0; right: -300px;
            width: 280px; height: 100%;
            background: #0b1120;
            border-left: 1px solid var(--border-glass);
            z-index: 1002;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            transition: right 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
        }
        .mobile-drawer.active { right: 0; }
        .mobile-nav-link {
            color: #f8fafc;
            text-decoration: none;
            font-size: 1.05rem;
            font-weight: 700;
            display: block;
            padding: 0.6rem 0;
        }
        .mobile-accordion-btn {
            background: transparent;
            border: none;
            color: #f8fafc;
            font-size: 1.05rem;
            font-weight: 700;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0;
            cursor: pointer;
        }
        .mobile-accordion-content {
            display: none;
            flex-direction: column;
            gap: 0.4rem;
            padding-left: 1rem;
            margin-top: 0.2rem;
        }
        .mobile-accordion-content.open { display: flex; }
        .mobile-sub-item {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.4rem 0;
        }
        .mobile-sub-item:hover { color: #05B396; }

        @media (max-width: 900px) {
            .nav-links, .nav-actions { display: none !important; }
            .mobile-toggle-btn { display: flex; }
            header.nav { padding: 0.8rem 1.2rem; }
        }

        /* Layout & Common */
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; }
        .form-control {
            width: 100%;
            padding: 0.85rem 1.1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-glass);
            border-radius: 10px;
            color: #fff;
            outline: none;
            font-size: 0.95rem;
            margin-top: 0.35rem;
        }
        .form-control:focus {
            border-color: #05B396;
            box-shadow: 0 0 10px rgba(5, 179, 150, 0.3);
        }
        .form-group { margin-bottom: 1.2rem; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header class="nav">
        <a href="/" class="brand">
            <img src="/images/logo.png" alt="Skillleaner" class="brand-logo-img">
        </a>
        
        <nav class="nav-links">
            <a href="/" class="${activePage === 'home' ? 'active' : ''}">Home</a>
            <a href="/courses" class="${activePage === 'courses' ? 'active' : ''}">Courses</a>
            
            <!-- Desktop Course Package Dropdown -->
            <div class="dropdown-wrapper">
                <a href="/plans" class="dropdown-trigger ${activePage === 'plans' ? 'active' : ''}">
                    Course Package <span style="font-size: 0.75rem;">▾</span>
                </a>
                <div class="dropdown-menu-box">
                    <a href="/plans#basic" class="dropdown-item-link">BASIC</a>
                    <a href="/plans#advance" class="dropdown-item-link">ADVANCE</a>
                    <a href="/plans#premium" class="dropdown-item-link">PREMIUM</a>
                    <a href="/plans#growth" class="dropdown-item-link">GROWTH</a>
                    <a href="/plans#infinity" class="dropdown-item-link">INFINITY</a>
                </div>
            </div>

            <a href="/plans" class="${activePage === 'plans' ? 'active' : ''}">All Plans</a>
            <a href="/classroom" class="${activePage === 'classroom' ? 'active' : ''}">Classroom</a>
        </nav>

        <div class="nav-actions" style="display: flex; gap: 0.8rem; align-items: center;">
            <a href="/buy-now" class="btn btn-primary" style="background: #05B396; font-weight: 800;">Buy Now</a>
            <a href="/my-account" class="btn btn-secondary" style="color: #000; border-color: rgba(0,0,0,0.15);">My Account</a>
        </div>

        <button class="mobile-toggle-btn" id="mobileMenuBtn" aria-label="Toggle Navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <!-- Mobile Drawer Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Mobile Drawer -->
    <div class="mobile-drawer" id="mobileDrawer">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 1px solid var(--border-glass);">
            <img src="/images/logo.png" alt="Skillleaner" style="height: 36px; width: auto;">
            <button id="mobileCloseBtn" style="background: none; border: none; color: #fff; font-size: 1.4rem; cursor: pointer;">✕</button>
        </div>
        
        <a href="/" class="mobile-nav-link">Home</a>
        <a href="/courses" class="mobile-nav-link">Courses</a>
        
        <!-- Mobile Accordion for Course Package -->
        <div>
            <button class="mobile-accordion-btn" id="mobileCoursePackageBtn">
                Course Package <span>▾</span>
            </button>
            <div class="mobile-accordion-content" id="mobileCoursePackageContent">
                <a href="/plans#basic" class="mobile-sub-item">BASIC</a>
                <a href="/plans#advance" class="mobile-sub-item">ADVANCE</a>
                <a href="/plans#premium" class="mobile-sub-item">PREMIUM</a>
                <a href="/plans#growth" class="mobile-sub-item">GROWTH</a>
                <a href="/plans#infinity" class="mobile-sub-item">INFINITY</a>
            </div>
        </div>

        <a href="/plans" class="mobile-nav-link">All Plans</a>
        <a href="/classroom" class="mobile-nav-link">Classroom LMS</a>
        <a href="/my-account" class="mobile-nav-link">My Account / Login</a>
        <a href="/buy-now" class="btn btn-primary" style="margin-top: 1rem; width: 100%; background: #05B396; font-weight: 800;">Buy Now</a>
    </div>

    <main class="main-content">
        ${content}
    </main>

    <footer style="border-top: 1px solid var(--border-glass); padding: 3rem 1.5rem; text-align: center; color: var(--text-body); font-size: 0.9rem; margin-top: 4rem;">
        <div class="container">
            <img src="/images/logo.png" alt="Skillleaner" style="height: 40px; margin-bottom: 1rem;">
            <p style="margin-bottom: 1rem;">Skillleaner — Build Skills, Build Future. Practical Video Masterclasses & Community Mentorship.</p>
            <p>© 2026 Skillleaner. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileDrawer = document.getElementById('mobileDrawer');
            const mobileCloseBtn = document.getElementById('mobileCloseBtn');
            const accordionBtn = document.getElementById('mobileCoursePackageBtn');
            const accordionContent = document.getElementById('mobileCoursePackageContent');

            function toggleMenu() {
                mobileOverlay.classList.toggle('active');
                mobileDrawer.classList.toggle('active');
            }

            if (mobileBtn) mobileBtn.addEventListener('click', toggleMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', toggleMenu);
            if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', toggleMenu);

            if (accordionBtn && accordionContent) {
                accordionBtn.addEventListener('click', () => {
                    accordionContent.classList.toggle('open');
                });
            }
        });
    </script>
</body>
</html>`;

// 4. Page Contents
const packages = [
    {
        id: 'basic',
        name: 'Basic Package',
        image: '/images/packages/basic.jpg',
        badge: '',
        courses: ['Canva Pro Mastery', 'MS Excel Essentials', 'Basic Spoken English', 'Social Media Fundamentals']
    },
    {
        id: 'advance',
        name: 'Advance Package',
        image: '/images/packages/advance.jpg',
        badge: 'MOST POPULAR',
        featured: true,
        courses: ['All Basic Courses', 'Video Editing (Premiere & CapCut)', 'Instagram Growth Formula', 'Organic Lead Generation']
    },
    {
        id: 'premium',
        name: 'Premium Package',
        image: '/images/packages/premium.jpg',
        badge: 'BEST VALUE',
        courses: ['All Advance Courses', 'Facebook & Instagram Paid Ads', 'AI & ChatGPT Monetization Kit', 'WordPress Web Development']
    },
    {
        id: 'growth',
        name: 'Growth Package',
        image: '/images/packages/growth.jpg',
        badge: 'HIGH GROWTH',
        courses: ['All Premium Courses', 'Complete Funnel Building', 'High-Ticket Sales Closing', 'Google & YouTube Ads']
    },
    {
        id: 'infinity',
        name: 'Infinity Package',
        image: '/images/packages/infinity.jpg',
        badge: 'ALL ACCESS LIFETIME',
        courses: ['Full Lifetime Access Pass', 'UI/UX Design Masterclass', '1-on-1 Mentorship & Weekly Live Masterminds', 'VIP Community & Support']
    }
];

// --- 4.1 Home Page Content ---
const homeContent = `
<section class="container" style="text-align: center; padding-top: 4rem; padding-bottom: 3rem;">
    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); padding: 6px 16px; border-radius: 30px; margin-bottom: 1.5rem; font-size: 0.85rem; font-weight: 700; color: #05B396;">
        <span style="font-size: 1.1rem;">🔥</span> Next-Gen Skill & Career Platform
    </div>
    <h1 style="font-size: clamp(2.2rem, 5vw, 3.8rem); font-weight: 800; line-height: 1.15; margin-bottom: 1.2rem; letter-spacing: -1px;">
        Build High-Income Digital Skills &amp; <span style="background: linear-gradient(135deg, #05B396, #0284c7); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Monetize in 2026</span>
    </h1>
    <p style="color: var(--text-body); font-size: 1.15rem; max-width: 720px; margin: 0 auto 2.5rem;">
        Master AI, Digital Marketing, Video Editing, and High-Ticket Freelancing with practical, project-based video masterclasses while building your passive income stream.
    </p>
    <div style="display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap;">
        <a href="/plans" class="btn btn-primary" style="padding: 1rem 2.2rem; font-size: 1.05rem;">Explore Packages ➔</a>
        <a href="/classroom" class="btn btn-secondary" style="padding: 1rem 2.2rem; font-size: 1.05rem;">Preview Classroom</a>
    </div>

    <div style="display: flex; justify-content: center; gap: 3rem; margin-top: 4rem; flex-wrap: wrap;">
        <div>
            <h3 style="font-size: 2.2rem; font-weight: 800; color: #05B396;">12,500+</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Enrolled Students</p>
        </div>
        <div>
            <h3 style="font-size: 2.2rem; font-weight: 800; color: #05B396;">₹45 Lakh+</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Affiliate Payouts</p>
        </div>
        <div>
            <h3 style="font-size: 2.2rem; font-weight: 800; color: #05B396;">4.9 / 5</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Student Rating</p>
        </div>
        <div>
            <h3 style="font-size: 2.2rem; font-weight: 800; color: #05B396;">70%</h3>
            <p style="color: var(--text-body); font-size: 0.9rem;">Direct Commission</p>
        </div>
    </div>
</section>

<!-- Packages Showcase -->
<section class="container" id="packages" style="padding-top: 2rem;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: #05B396; font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">Packages &amp; Tiers</div>
        <h2 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.5px;">Select Your Learning Track</h2>
        <p style="color: var(--text-body); max-width: 620px; margin: 0 auto;">Every package unlocks premium high-yield skills along with direct and passive referral commission rights.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
        ${packages.map(pkg => `
            <div id="${pkg.id}" class="glass" style="padding: 2.2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; ${pkg.featured ? 'border: 2px solid #05B396; background: linear-gradient(180deg, rgba(5, 179, 150, 0.16) 0%, rgba(15, 23, 42, 0.9) 100%);' : ''}">
                ${pkg.badge ? `<div style="position: absolute; top: -13px; right: 25px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">${pkg.badge}</div>` : ''}

                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 230px;">
                    <img src="${pkg.image}" alt="${pkg.name}" style="max-height: 220px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.5rem; text-align: center; margin-bottom: 0.8rem;">${pkg.name}</h3>

                <ul style="list-style: none; margin-bottom: 2rem; flex-grow: 1;">
                    ${pkg.courses.map(c => `
                        <li style="padding: 0.45rem 0; color: var(--text-body); font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #05B396; font-weight: bold;">✓</span> ${c}
                        </li>
                    `).join('')}
                </ul>

                <a href="/register?package=${encodeURIComponent(pkg.name)}" class="btn ${pkg.featured ? 'btn-primary' : 'btn-secondary'}" style="text-align: center; width: 100%; padding: 0.85rem; font-weight: 700;">
                    Buy Now ➔
                </a>
            </div>
        `).join('')}
    </div>
</section>
`;

// --- 4.2 Plans Page Content ---
const plansContent = `
<section class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: #05B396; font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">SKILLLEANER PACKAGES</div>
        <h2 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.5px;">All Course Bundles &amp; Tracks</h2>
        <p style="color: var(--text-body); max-width: 600px; margin: 0 auto;">Choose your desired bundle to gain lifetime access to all masterclasses and community mentorship.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
        ${packages.map(pkg => `
            <div id="${pkg.id}" class="glass" style="padding: 2.2rem 1.8rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; transition: transform 0.3s ease, border-color 0.3s ease; ${pkg.featured ? 'border: 2px solid #05B396; background: linear-gradient(180deg, rgba(5, 179, 150, 0.16) 0%, rgba(15, 23, 42, 0.9) 100%);' : ''}">
                ${pkg.badge ? `<div style="position: absolute; top: -13px; right: 25px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">${pkg.badge}</div>` : ''}

                <div style="text-align: center; margin: 0.5rem 0 1.2rem; display: flex; justify-content: center; align-items: center; min-height: 230px;">
                    <img src="${pkg.image}" alt="${pkg.name}" style="max-height: 220px; width: auto; object-fit: contain; filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5)); transition: transform 0.3s ease;">
                </div>

                <h3 style="font-size: 1.5rem; text-align: center; margin-bottom: 0.8rem;">${pkg.name}</h3>

                <ul style="list-style: none; margin-bottom: 2rem; flex-grow: 1;">
                    ${pkg.courses.map(c => `
                        <li style="padding: 0.45rem 0; color: var(--text-body); font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #05B396; font-weight: bold;">✓</span> ${c}
                        </li>
                    `).join('')}
                </ul>

                <a href="/register?package=${encodeURIComponent(pkg.name)}" class="btn ${pkg.featured ? 'btn-primary' : 'btn-secondary'}" style="text-align: center; width: 100%; padding: 0.85rem; font-weight: 700;">
                    Buy Now ➔
                </a>
            </div>
        `).join('')}
    </div>
</section>
`;

// --- 4.3 Register Page Content ---
const registerContent = `
<section class="container" style="max-width: 760px; padding: 3rem 1.5rem;">
    <div class="glass" style="padding: 2.5rem; border-radius: var(--radius-lg); text-align: center;">
        
        <img src="/images/logo.png" alt="Skillleaner" style="height: 58px; width: auto; margin-bottom: 0.8rem; object-fit: contain;">
        
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.4rem;">Enroll in Skillleaner</h2>
        <p style="color: var(--text-body); font-size: 0.92rem; margin-bottom: 2rem;">Activate lifetime access to skill video masterclasses, community mentorship, and learning resources.</p>

        <form onsubmit="event.preventDefault(); alert('🎉 Registration simulated successfully! Welcome to Skillleaner.'); window.location.href='/dashboard';">
            
            <!-- Sponsor ID -->
            <div class="form-group" style="text-align: left; margin-bottom: 1.5rem;">
                <label style="font-size: 0.88rem; font-weight: 700; color: var(--text-body);">Sponsor / Referral ID (Auto-Locked)</label>
                <input type="text" name="sponsor_id" class="form-control" value="SKL-ADMIN" readonly style="background: rgba(5, 179, 150, 0.1); border-color: rgba(5, 179, 150, 0.35); color: #05B396; font-weight: 800; letter-spacing: 0.5px;">
            </div>

            <!-- Visual Package Selector with 3D Images (No Amounts) -->
            <div class="form-group" style="text-align: left; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <label style="font-size: 0.95rem; font-weight: 800; color: #fff; margin: 0;">Select Your Learning Package</label>
                    <span style="font-size: 0.8rem; color: #05B396; font-weight: 700;">● Click card to choose</span>
                </div>

                <input type="hidden" name="package" id="selectedPackageInput" value="Advance Package">

                <div class="package-visual-grid">
                    
                    <!-- 1. Basic Package -->
                    <div class="package-visual-card" data-package="Basic Package" onclick="chooseVisualPackage(this, 'Basic Package')">
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="/images/packages/basic.jpg" alt="Basic Package">
                        </div>
                        <div class="pkg-title">BASIC</div>
                    </div>

                    <!-- 2. Advance Package -->
                    <div class="package-visual-card selected" data-package="Advance Package" onclick="chooseVisualPackage(this, 'Advance Package')">
                        <span class="card-ribbon">POPULAR</span>
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="/images/packages/advance.jpg" alt="Advance Package">
                        </div>
                        <div class="pkg-title">ADVANCE</div>
                    </div>

                    <!-- 3. Premium Package -->
                    <div class="package-visual-card" data-package="Premium Package" onclick="chooseVisualPackage(this, 'Premium Package')">
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="/images/packages/premium.jpg" alt="Premium Package">
                        </div>
                        <div class="pkg-title">PREMIUM</div>
                    </div>

                    <!-- 4. Growth Package -->
                    <div class="package-visual-card" data-package="Growth Package" onclick="chooseVisualPackage(this, 'Growth Package')">
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="/images/packages/growth.jpg" alt="Growth Package">
                        </div>
                        <div class="pkg-title">GROWTH</div>
                    </div>

                    <!-- 5. Infinity Package -->
                    <div class="package-visual-card" data-package="Infinity Package" onclick="chooseVisualPackage(this, 'Infinity Package')">
                        <span class="card-ribbon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">VIP</span>
                        <div class="check-pill">✓</div>
                        <div class="img-wrapper">
                            <img src="/images/packages/infinity.jpg" alt="Infinity Package">
                        </div>
                        <div class="pkg-title">INFINITY</div>
                    </div>

                </div>
            </div>

            <!-- Student Form Inputs -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; text-align: left;">
                <div class="form-group">
                    <label>Your Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Suraj Kumar" required>
                </div>
                <div class="form-group">
                    <label>WhatsApp Number</label>
                    <input type="tel" name="phone" class="form-control" placeholder="9876543210" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; text-align: left;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="suraj@example.com" required>
                </div>
                <div class="form-group">
                    <label>Create Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <!-- Submit Button (No amount) -->
            <button type="submit" id="enrollSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1.5rem; font-size: 1.05rem; background: linear-gradient(135deg, #05B396 0%, #048873 100%); box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35);">
                Enroll in Advance Package
            </button>
        </form>
    </div>
</section>

<style>
    .package-visual-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.9rem;
        margin-top: 0.5rem;
    }

    .package-visual-card {
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 0.9rem 0.5rem 0.8rem;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }

    .package-visual-card:hover {
        transform: translateY(-4px);
        border-color: rgba(5, 179, 150, 0.5);
        background: rgba(255, 255, 255, 0.06);
    }

    .package-visual-card.selected {
        border-color: #05B396;
        background: linear-gradient(180deg, rgba(5, 179, 150, 0.16) 0%, rgba(15, 23, 42, 0.85) 100%);
        box-shadow: 0 0 25px rgba(5, 179, 150, 0.3);
        transform: translateY(-4px);
    }

    .package-visual-card .img-wrapper {
        width: 100%;
        height: 135px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
    }

    .package-visual-card img {
        max-height: 130px;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.45));
        transition: transform 0.25s ease;
    }

    .package-visual-card:hover img {
        transform: scale(1.05);
    }

    .package-visual-card .pkg-title {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #fff;
    }

    .package-visual-card.selected .pkg-title {
        color: #05B396;
    }

    .package-visual-card .check-pill {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: transparent;
        font-size: 0.72rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .package-visual-card.selected .check-pill {
        background: #05B396;
        color: #fff;
        box-shadow: 0 0 8px rgba(5, 179, 150, 0.6);
    }

    .package-visual-card .card-ribbon {
        position: absolute;
        top: -9px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #05B396, #0284c7);
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 10px;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .package-visual-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .package-visual-card:last-child {
            grid-column: span 2;
        }
    }
</style>

<script>
    function chooseVisualPackage(element, packageName) {
        document.querySelectorAll('.package-visual-card').forEach(card => {
            card.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('selectedPackageInput').value = packageName;
        const btn = document.getElementById('enrollSubmitBtn');
        if (btn) {
            btn.innerText = 'Enroll in ' + packageName;
        }
    }

    // Auto-select package from URL param if present
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const pkgParam = urlParams.get('package');
        if (pkgParam) {
            const matchCard = document.querySelector(\`.package-visual-card[data-package="\${pkgParam}"]\`);
            if (matchCard) {
                chooseVisualPackage(matchCard, pkgParam);
            }
        }
    });
</script>
`;

// --- 4.4 Classroom Page Content ---
const classroomContent = `
<section class="container" style="padding-top: 2rem;">
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700;">LMS CLASSROOM</span>
            <h2 id="activeLessonTitle" style="font-size: 1.8rem; margin-top: 0.4rem;">01. Introduction to High-Ticket Affiliate Funnels</h2>
        </div>
        <button onclick="alert('🏆 Certificate Generated! \\nIssued to: Suraj Sharma\\nCourse: Affiliate Mastery\\nStatus: 100% Completed')" class="btn btn-secondary">
            📜 Claim Course Certificate
        </button>
    </div>

    <div style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 2rem;">
        <div>
            <div class="player-container" style="position: relative; background: #000; border-radius: var(--radius-md); overflow: hidden; aspect-ratio: 16 / 9; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6); border: 1px solid var(--border-glass);">
                <video id="videoPlayer" controls poster="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&q=80" style="width: 100%; height: 100%; object-fit: cover;">
                    <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                </video>
            </div>

            <div class="glass" style="margin-top: 1.5rem; padding: 1.8rem; border-radius: var(--radius-md);">
                <h4 style="margin-bottom: 0.6rem;">Lesson Overview &amp; Resources</h4>
                <p style="color: var(--text-body); font-size: 0.95rem; margin-bottom: 1rem;">Learn the exact system used by top affiliates to close ₹20,000+ per week directly from organic social media traffic without paid ads.</p>
                <button onclick="alert('Download started: Affiliate_Blueprint_PDF.zip')" class="btn btn-secondary" style="font-size: 0.85rem;">
                    📥 Download Lesson PDF &amp; Scripts
                </button>
            </div>
        </div>

        <!-- Playlist -->
        <div class="glass" style="padding: 1.4rem; border-radius: var(--radius-md); height: fit-content;">
            <h4 style="margin-bottom: 1.2rem; font-size: 1.1rem;">Course Modules (18 Lessons)</h4>
            <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                <div style="padding: 0.8rem; background: rgba(5, 179, 150, 0.15); border: 1px solid #05B396; border-radius: 8px; cursor: pointer;">
                    <div style="font-size: 0.82rem; color: #05B396; font-weight: 700;">LESSON 1 (PLAYING)</div>
                    <div style="font-size: 0.92rem; font-weight: 600; margin-top: 2px;">Intro &amp; Strategy Setup</div>
                </div>
                <div style="padding: 0.8rem; background: rgba(255, 255, 255, 0.03); border-radius: 8px; cursor: pointer;">
                    <div style="font-size: 0.82rem; color: var(--text-body);">LESSON 2 (14:30)</div>
                    <div style="font-size: 0.92rem; font-weight: 600; margin-top: 2px;">Organic Lead Funnel Architecture</div>
                </div>
                <div style="padding: 0.8rem; background: rgba(255, 255, 255, 0.03); border-radius: 8px; cursor: pointer;">
                    <div style="font-size: 0.82rem; color: var(--text-body);">LESSON 3 (22:15)</div>
                    <div style="font-size: 0.92rem; font-weight: 600; margin-top: 2px;">High-Ticket Direct DM Closing</div>
                </div>
            </div>
        </div>
    </div>
</section>
`;

// --- 4.5 Dashboard Page Content ---
const dashboardContent = `
<section class="container" style="padding-top: 2rem;">
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 2.2rem;">
        <!-- Sidebar -->
        <aside class="glass" style="padding: 1.8rem; border-radius: var(--radius-md); height: fit-content;">
            <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-glass); margin-bottom: 1.5rem;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--primary-gradient); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 800;">
                    S
                </div>
                <div>
                    <h4 style="font-size: 1rem;">Suraj Sharma</h4>
                    <span style="font-size: 0.75rem; color: var(--success); font-weight: 700;">● Verified ✅</span>
                </div>
            </div>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                <li><a href="/dashboard" class="btn btn-secondary" style="width: 100%; justify-content: flex-start; background: rgba(5, 179, 150, 0.15); border-color: #05B396; color: #05B396;">📊 Overview &amp; Wallet</a></li>
                <li><a href="/classroom" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">🎓 My Courses</a></li>
                <li><a href="javascript:void(0)" onclick="alert('Payout request submitted for ₹5,000!')" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">💸 Request Payout</a></li>
                <li><a href="/" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">🏠 Main Website</a></li>
            </ul>
        </aside>

        <!-- Dashboard Content -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 2rem; font-weight: 800;">Affiliate Command Center</h2>
                    <p style="color: var(--text-body);">Active Tier: <strong style="color: #05B396;">Advance Package</strong> | Referral Code: <code>SKL-8821</code></p>
                </div>
            </div>

            <!-- Earnings Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
                <div class="glass" style="padding: 1.4rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.85rem; color: var(--text-body);">Wallet Balance</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #10b981; margin-top: 4px;">₹14,200</div>
                </div>
                <div class="glass" style="padding: 1.4rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.85rem; color: var(--text-body);">Today's Earnings</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #fff; margin-top: 4px;">₹2,200</div>
                </div>
                <div class="glass" style="padding: 1.4rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.85rem; color: var(--text-body);">Weekly Earnings</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #fff; margin-top: 4px;">₹7,400</div>
                </div>
                <div class="glass" style="padding: 1.4rem; border-radius: var(--radius-md);">
                    <div style="font-size: 0.85rem; color: var(--text-body);">All-Time Earnings</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #05B396; margin-top: 4px;">₹48,600</div>
                </div>
            </div>

            <!-- Referral Link Box -->
            <div class="glass" style="padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                <h4 style="margin-bottom: 0.6rem;">Your Affiliate Referral Link</h4>
                <div style="display: flex; gap: 0.8rem;">
                    <input type="text" readonly value="https://skillleaner.com/register?ref=SKL-8821" class="form-control" style="margin-top: 0; background: rgba(0,0,0,0.3); font-weight: 600;">
                    <button class="btn btn-primary" onclick="navigator.clipboard.writeText('https://skillleaner.com/register?ref=SKL-8821'); alert('Copied to clipboard!');">Copy</button>
                </div>
            </div>
        </div>
    </div>
</section>
`;


// --- 4.6 Login Page Content ---
const loginContent = `
<div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 2.8rem 1.5rem; text-align: center;">
    <h1 style="font-size: 2.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem; letter-spacing: -0.5px;">Login &amp; Register</h1>
    <p style="font-size: 0.92rem; color: #64748b; font-weight: 600;">
        <a href="/" style="color: #64748b; text-decoration: none; transition: color 0.2s;">Home</a>
        <span style="margin: 0 8px; color: #94a3b8;">&gt;</span>
        <span style="color: #0f172a;">Login &amp; Register</span>
    </p>
</div>

<section style="background: #ffffff; padding: 4rem 1.5rem; min-height: 560px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 1080px; width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;" class="login-grid-wrapper">
        
        <!-- Left: Illustration -->
        <div style="display: flex; justify-content: center; align-items: center;" class="login-illustration-col">
            <svg viewBox="0 0 520 420" width="100%" height="auto" style="max-width: 480px; display: block;" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="260" cy="385" rx="220" ry="14" fill="#f1f5f9"/>
                <line x1="80" y1="385" x2="480" y2="385" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"/>

                <g id="plant-group">
                    <path d="M 430 385 L 430 350 Q 425 320 410 290 Q 425 315 432 350 Z" fill="#1e293b"/>
                    <path d="M 430 350 Q 450 310 460 270 Q 448 300 435 345 Z" fill="#334155"/>
                    <path d="M 425 340 Q 395 310 380 270 Q 405 295 423 335 Z" fill="#0f172a"/>
                    <path d="M 428 330 Q 415 280 430 240 Q 438 275 431 325 Z" fill="#1e293b"/>
                    <path d="M 433 330 Q 455 290 470 250 Q 455 285 436 325 Z" fill="#475569"/>
                    <polygon points="410,350 450,350 444,385 416,385" fill="#3b82f6"/>
                    <polygon points="405,345 455,345 450,352 410,352" fill="#2563eb"/>
                </g>

                <g id="boxes-group" opacity="0.6">
                    <rect x="330" y="325" width="60" height="60" rx="3" fill="#f8fafc" stroke="#cbd5e1" stroke-width="1.5"/>
                    <line x1="330" y1="345" x2="390" y2="345" stroke="#e2e8f0" stroke-width="1.5"/>
                    <rect x="355" y="295" width="55" height="30" rx="3" fill="#ffffff" stroke="#cbd5e1" stroke-width="1.5"/>
                </g>

                <g id="browser-window-group" transform="translate(190, 80)">
                    <rect x="0" y="0" width="220" height="160" rx="8" fill="#ffffff" stroke="#cbd5e1" stroke-width="1.5" filter="drop-shadow(0 10px 20px rgba(0,0,0,0.06))"/>
                    <line x1="0" y1="26" x2="220" y2="26" stroke="#f1f5f9" stroke-width="1.5"/>
                    <circle cx="15" cy="13" r="3" fill="#94a3b8"/>
                    <circle cx="26" cy="13" r="3" fill="#cbd5e1"/>
                    <circle cx="37" cy="13" r="3" fill="#e2e8f0"/>

                    <circle cx="110" cy="55" r="24" fill="none" stroke="#e2e8f0" stroke-dasharray="2,3" stroke-width="1.5"/>
                    <path d="M 103 52 L 103 45 A 7 7 0 0 1 117 45 L 117 52" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round"/>
                    <rect x="99" y="52" width="22" height="17" rx="3" fill="#3b82f6"/>
                    <circle cx="110" cy="59" r="2" fill="#ffffff"/>
                    <line x1="110" y1="61" x2="110" y2="65" stroke="#ffffff" stroke-width="1.5"/>

                    <rect x="25" y="88" width="170" height="22" rx="4" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1"/>
                    <text x="110" y="103" font-size="8.5" fill="#334155" text-anchor="middle" font-family="'Inter', sans-serif" font-weight="600">username@gmail.com</text>

                    <rect x="25" y="118" width="170" height="22" rx="4" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1"/>
                    <text x="110" y="133" font-size="11" fill="#64748b" text-anchor="middle" font-family="'Inter', sans-serif" letter-spacing="2">••••••••</text>
                </g>

                <g id="student-group">
                    <rect x="100" y="300" width="75" height="85" rx="6" fill="#3b82f6"/>
                    <rect x="106" y="380" width="8" height="10" fill="#1e293b"/>
                    <rect x="161" y="380" width="8" height="10" fill="#1e293b"/>

                    <path d="M 125 305 L 145 375 L 170 380 L 155 385 L 138 380 Z" fill="#0f172a"/>
                    <path d="M 115 280 Q 105 320 120 360 L 135 365 L 145 385 L 125 388 L 110 360 Z" fill="#1e293b"/>
                    <path d="M 143 382 L 160 384 L 160 388 L 140 388 Z" fill="#334155"/>
                    <path d="M 122 384 L 140 386 L 140 390 L 120 390 Z" fill="#334155"/>

                    <path d="M 108 220 Q 115 195 130 195 Q 145 195 152 220 L 158 290 Q 135 305 105 290 Z" fill="#0f172a"/>

                    <path d="M 130 225 Q 150 250 170 260 L 165 270 Q 145 260 125 240 Z" fill="#fed7aa"/>
                    <path d="M 125 215 Q 140 215 145 235 L 130 240 Z" fill="#0f172a"/>

                    <polygon points="160,250 195,250 190,290 155,290" fill="#cbd5e1" stroke="#94a3b8" stroke-width="1"/>
                    <circle cx="175" cy="270" r="3" fill="#ffffff" opacity="0.8"/>
                    <polygon points="152,290 198,290 205,295 150,295" fill="#94a3b8"/>

                    <rect x="130" y="175" width="12" height="22" fill="#fed7aa"/>
                    <circle cx="136" cy="165" r="16" fill="#fed7aa"/>
                    <circle cx="143" cy="164" r="1.5" fill="#0f172a"/>
                    <path d="M 140 171 Q 144 174 148 171" fill="none" stroke="#0f172a" stroke-width="1.2" stroke-linecap="round"/>

                    <path d="M 122 165 Q 120 148 135 148 Q 152 148 150 162 Q 136 154 122 165 Z" fill="#0f172a"/>
                    <circle cx="123" cy="148" r="8" fill="#0f172a"/>
                </g>
            </svg>
        </div>

        <!-- Right: Login Card -->
        <div style="display: flex; justify-content: center; width: 100%;">
            <div class="login-card-box" style="background: #ffffff; border-radius: 16px; padding: 2.8rem 2.4rem; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); border: 1px solid #f1f5f9; width: 100%; max-width: 480px;">
                <form onsubmit="event.preventDefault(); window.location.href='/dashboard';">
                    
                    <div style="margin-bottom: 1.4rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                            Username or email <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" id="loginUsernameInput" required style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; color: #0f172a; font-size: 0.95rem; outline: none;" placeholder="suraj@skillleaner.test" value="suraj@skillleaner.test">
                    </div>

                    <div style="margin-bottom: 1.3rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">
                            Password <span style="color: #ef4444;">*</span>
                        </label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" id="loginPasswordInput" required style="width: 100%; padding: 0.85rem 1.1rem; padding-right: 48px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; color: #0f172a; font-size: 0.95rem; outline: none;" placeholder="••••••••" value="password123">
                            <button type="button" onclick="const p = document.getElementById('loginPasswordInput'); p.type = p.type === 'password' ? 'text' : 'password';" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #64748b; padding: 6px; display: flex;">
                                👁️
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.8rem; font-size: 0.88rem;">
                        <label style="display: flex; align-items: center; gap: 8px; color: #64748b; cursor: pointer; user-select: none;">
                            <input type="checkbox" checked style="accent-color: #05B396; width: 16px; height: 16px;">
                            Remember me
                        </label>
                        <a href="javascript:void(0)" onclick="alert('Password reset link will be sent to your registered email.')" style="color: #64748b; text-decoration: none;">
                            Forgot your password ?
                        </a>
                    </div>

                    <button type="submit" style="width: 100%; padding: 0.92rem 1.5rem; font-size: 1.05rem; font-weight: 700; color: #ffffff; background: #05B396; border: none; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 18px rgba(219, 39, 119, 0.35); display: flex; align-items: center; justify-content: center;">
                        Log In &nbsp;➔
                    </button>

                    <div style="text-align: center; margin-top: 1.6rem; font-size: 0.92rem; color: #64748b;">
                        Don't have an account yet? 
                        <a href="/register" style="color: #05B396; font-weight: 700; text-decoration: none;">
                            Register Now →
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
`;


// Courses Page Content
const coursesContent = `
<section style="background: linear-gradient(180deg, rgba(5, 179, 150, 0.12) 0%, rgba(7, 10, 18, 0) 100%); padding: 4.5rem 2rem 3rem; text-align: center;">
    <div class="container" style="max-width: 950px; padding: 0; margin: 0 auto;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.4rem;">
            <span>🎓 2026 High-Income Skill Masterclasses</span>
        </div>
        <h1 style="font-size: 3.2rem; font-weight: 800; line-height: 1.2; letter-spacing: -1px; margin-bottom: 1.2rem;">
            Explore Courses with <br><span class="text-gradient">Detailed Descriptions &amp; Syllabuses</span>
        </h1>
        <p style="color: var(--text-body); font-size: 1.15rem; max-width: 700px; margin: 0 auto 2.2rem; line-height: 1.6;">
            Learn practical, high-income skills directly from industry experts. Every course includes step-by-step video training, downloadable blueprints, and lifetime mentor support.
        </p>
    </div>
</section>

<section class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2.2rem;">
        
        <!-- Course 1 -->
        <div class="glass" style="border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; border: 1px solid var(--border-glass);">
            <div style="height: 190px; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                <div style="font-size: 4.8rem;">🚀</div>
                <span style="position: absolute; top: 14px; left: 16px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 800;">BESTSELLER</span>
                <span style="position: absolute; bottom: 12px; right: 14px; background: rgba(0, 0, 0, 0.75); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; color: #fff;">⏱ 6h 40m • 18 Lessons</span>
            </div>
            <div style="padding: 1.8rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">AFFILIATE BUSINESS</span>
                    <h3 style="font-size: 1.32rem; font-weight: 800; margin: 0.5rem 0 0.8rem; color: #f8fafc;">High-Ticket Affiliate Marketing Masterclass</h3>
                    <p style="color: var(--text-body); font-size: 0.92rem; line-height: 1.55; margin-bottom: 1.2rem;">Step-by-step blueprint to generate ₹50,000+ monthly via organic leads and high-ticket affiliate funnels without paid ads.</p>
                </div>
                <div style="border-top: 1px solid var(--border-glass); padding-top: 1.2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1rem;">
                        <div>
                            <span style="font-size: 1.45rem; font-weight: 800; color: #ffffff;">₹1,499</span>
                            <span style="font-size: 0.9rem; text-decoration: line-through; color: #64748b; margin-left: 6px;">₹3,999</span>
                        </div>
                        <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">INCLUDED IN ADVANCE</span>
                    </div>
                    <a href="/buy-now?course=affiliate-marketing-masterclass" class="btn btn-primary" style="background: #05B396; width: 100%; padding: 0.8rem; font-weight: 800; text-align: center;">Buy Now ➔</a>
                </div>
            </div>
        </div>

        <!-- Course 2 -->
        <div class="glass" style="border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; border: 1px solid var(--border-glass);">
            <div style="height: 190px; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                <div style="font-size: 4.8rem;">🤖</div>
                <span style="position: absolute; top: 14px; left: 16px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 800;">TRENDING</span>
                <span style="position: absolute; bottom: 12px; right: 14px; background: rgba(0, 0, 0, 0.75); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; color: #fff;">⏱ 5h 15m • 14 Lessons</span>
            </div>
            <div style="padding: 1.8rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">ARTIFICIAL INTELLIGENCE</span>
                    <h3 style="font-size: 1.32rem; font-weight: 800; margin: 0.5rem 0 0.8rem; color: #f8fafc;">AI, ChatGPT &amp; Automation Cashflow</h3>
                    <p style="color: var(--text-body); font-size: 0.92rem; line-height: 1.55; margin-bottom: 1.2rem;">Harness ChatGPT, Midjourney, Claude &amp; automation bots to deliver paid freelance services in minutes.</p>
                </div>
                <div style="border-top: 1px solid var(--border-glass); padding-top: 1.2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1rem;">
                        <div>
                            <span style="font-size: 1.45rem; font-weight: 800; color: #ffffff;">₹1,299</span>
                            <span style="font-size: 0.9rem; text-decoration: line-through; color: #64748b; margin-left: 6px;">₹3,499</span>
                        </div>
                        <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">INCLUDED IN PREMIUM</span>
                    </div>
                    <a href="/buy-now?course=ai-chatgpt-automation" class="btn btn-primary" style="background: #05B396; width: 100%; padding: 0.8rem; font-weight: 800; text-align: center;">Buy Now ➔</a>
                </div>
            </div>
        </div>

        <!-- Course 3 -->
        <div class="glass" style="border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; border: 1px solid var(--border-glass);">
            <div style="height: 190px; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                <div style="font-size: 4.8rem;">🎬</div>
                <span style="position: absolute; top: 14px; left: 16px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 800;">HOT SKILL</span>
                <span style="position: absolute; bottom: 12px; right: 14px; background: rgba(0, 0, 0, 0.75); padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; color: #fff;">⏱ 8h 20m • 22 Lessons</span>
            </div>
            <div style="padding: 1.8rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">VIDEO &amp; MEDIA</span>
                    <h3 style="font-size: 1.32rem; font-weight: 800; margin: 0.5rem 0 0.8rem; color: #f8fafc;">Short-Form Video Editing (CapCut &amp; Premiere Pro)</h3>
                    <p style="color: var(--text-body); font-size: 0.92rem; line-height: 1.55; margin-bottom: 1.2rem;">Edit viral Instagram Reels, YouTube Shorts, and TikTok ads that grab attention in the first 2 seconds.</p>
                </div>
                <div style="border-top: 1px solid var(--border-glass); padding-top: 1.2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1rem;">
                        <div>
                            <span style="font-size: 1.45rem; font-weight: 800; color: #ffffff;">₹1,499</span>
                            <span style="font-size: 0.9rem; text-decoration: line-through; color: #64748b; margin-left: 6px;">₹3,999</span>
                        </div>
                        <span style="background: rgba(5, 179, 150, 0.15); color: #05B396; padding: 3px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 800;">INCLUDED IN ADVANCE</span>
                    </div>
                    <a href="/buy-now?course=short-form-video-editing" class="btn btn-primary" style="background: #05B396; width: 100%; padding: 0.8rem; font-weight: 800; text-align: center;">Buy Now ➔</a>
                </div>
            </div>
        </div>

    </div>
</section>
`;

// Buy Now Page Content
const buyNowContent = `
<section style="background: linear-gradient(180deg, rgba(5, 179, 150, 0.14) 0%, rgba(7, 10, 18, 0) 100%); padding: 3rem 1.5rem 2rem; text-align: center;">
    <div class="container" style="max-width: 800px; padding: 0;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); color: #05B396; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1rem;">
            <span>⚡ Instant Enrollment &amp; Access</span>
        </div>
        <h1 style="font-size: 2.8rem; font-weight: 800; margin-bottom: 0.6rem; letter-spacing: -0.5px;">
            Complete Your <span class="text-gradient">Purchase</span>
        </h1>
        <p style="color: var(--text-body); font-size: 1.05rem;">
            You are 1 minute away from lifetime video masterclasses, community mentorship, and direct learning access.
        </p>
    </div>
</section>

<section class="container" style="max-width: 1100px; padding-top: 1rem; padding-bottom: 5rem;">
    <div style="display: grid; grid-template-columns: 1.15fr 1fr; gap: 2.5rem; align-items: start;">
        
        <!-- Order Summary Card -->
        <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); border: 2px solid #05B396; position: relative;">
            <span style="position: absolute; top: 16px; right: 20px; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800;">
                MOST POPULAR
            </span>

            <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 1.4rem;">
                <div style="width: 78px; height: 78px; border-radius: 14px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                    <img src="/images/packages/advance.jpg" alt="Advance Package" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div>
                    <div style="font-size: 0.78rem; color: #05B396; font-weight: 800; text-transform: uppercase;">SKILLLEANER BUNDLE</div>
                    <h3 style="font-size: 1.55rem; font-weight: 800; color: #ffffff; margin: 2px 0;">Advance Package</h3>
                    <div style="font-size: 0.85rem; color: #94a3b8;">4 Full Masterclasses Included</div>
                </div>
            </div>

            <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; background: rgba(255, 255, 255, 0.02); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-glass);">
                Our flagship bundle unlocking high-ticket video editing, Instagram organic growth formulas, and 70% direct referral commission rights.
            </p>

            <div style="background: rgba(15, 23, 42, 0.9); border: 1px solid var(--border-glass); border-radius: 12px; padding: 1.4rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.92rem; color: #94a3b8; margin-bottom: 0.5rem;">
                    <span>Original Course Fee</span>
                    <span style="text-decoration: line-through;">₹4,999</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.92rem; color: #05B396; margin-bottom: 0.5rem;">
                    <span>Limited Student Discount</span>
                    <span>-₹2,500</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.92rem; color: #94a3b8; margin-bottom: 0.8rem;">
                    <span>GST &amp; Platform Access</span>
                    <span style="color: #22c55e; font-weight: 700;">FREE (₹0)</span>
                </div>
                <div style="border-top: 1px solid var(--border-glass); padding-top: 0.8rem; display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-size: 1.1rem; font-weight: 800; color: #ffffff;">Total Payable Today</span>
                    <span style="font-size: 1.9rem; font-weight: 800; color: #05B396;">₹2,499</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="glass" style="padding: 2.4rem; border-radius: var(--radius-lg); border: 1px solid var(--border-glass);">
            <h3 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.4rem; color: #fff;">Student Enrollment &amp; Payment</h3>
            <p style="color: var(--text-body); font-size: 0.88rem; margin-bottom: 1.8rem;">Enter your details to unlock your learning dashboard.</p>
            
            <form onsubmit="event.preventDefault(); window.location.href='/classroom';">
                <div style="margin-bottom: 1.1rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">Student Full Name *</label>
                    <input type="text" required value="Suraj Sharma" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                </div>
                <div style="margin-bottom: 1.1rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">WhatsApp Number *</label>
                    <input type="tel" required value="+91 98765 43210" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                </div>
                <div style="margin-bottom: 1.4rem;">
                    <label style="font-size: 0.86rem; font-weight: 700; color: #e2e8f0; margin-bottom: 0.4rem; display: block;">Email Address *</label>
                    <input type="email" required value="suraj@skillleaner.test" class="form-control" style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-glass); padding: 0.8rem 1rem; border-radius: 8px; color: #fff; width: 100%;">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.05rem; font-size: 1.15rem; font-weight: 800; background: #05B396; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; border: none; color: #fff;">
                    Complete Order &amp; Buy Now ➔
                </button>
            </form>
        </div>

    </div>
</section>
`;

// 5. Output pages to dist
const pages = [
    { path: 'index.html', html: getHtml('Skillleaner — Build Skills, Build Future', homeContent, 'home') },
    { path: 'plans.html', html: getHtml('Packages & Plans', plansContent, 'plans') },
    { path: 'plans/index.html', html: getHtml('Packages & Plans', plansContent, 'plans') },
    { path: 'courses.html', html: getHtml('All Courses & Syllabuses', coursesContent, 'courses') },
    { path: 'courses/index.html', html: getHtml('All Courses & Syllabuses', coursesContent, 'courses') },
    { path: 'buy-now.html', html: getHtml('Buy Now & Instant Enrollment', buyNowContent, 'buy-now') },
    { path: 'buy-now/index.html', html: getHtml('Buy Now & Instant Enrollment', buyNowContent, 'buy-now') },
    { path: 'programs/index.html', html: getHtml('Packages & Plans', plansContent, 'plans') },
    { path: 'register.html', html: getHtml('Enroll in Skillleaner', registerContent, 'register') },
    { path: 'register/index.html', html: getHtml('Enroll in Skillleaner', registerContent, 'register') },
    { path: 'classroom.html', html: getHtml('Classroom LMS', classroomContent, 'classroom') },
    { path: 'classroom/index.html', html: getHtml('Classroom LMS', classroomContent, 'classroom') },
    { path: 'dashboard.html', html: getHtml('Student Dashboard', dashboardContent, 'dashboard') },
    { path: 'dashboard/index.html', html: getHtml('Student Dashboard', dashboardContent, 'dashboard') },
    { path: 'login.html', html: getHtml('Login & Register', loginContent, 'login') },
    { path: 'login/index.html', html: getHtml('Login & Register', loginContent, 'login') },
    { path: 'my-account.html', html: getHtml('My Account', loginContent, 'login') },
    { path: 'my-account/index.html', html: getHtml('My Account', loginContent, 'login') },
];

pages.forEach(p => {
    const fullPath = path.resolve(distDir, p.path);
    const dir = path.dirname(fullPath);
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
    fs.writeFileSync(fullPath, p.html, 'utf-8');
    console.log(`✅ Generated ${p.path}`);
});

console.log('🎉 Static build completed successfully! dist/ is ready for AWS Amplify.');
