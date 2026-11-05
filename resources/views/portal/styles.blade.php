<style>
    /* ==========================================================
       STUDENT PORTAL & DASHBOARD STYLES (MATCHES HOME PAGE THEME)
       ========================================================== */
    .student-portal-wrapper {
        background: #f8fafc;
        background-image: radial-gradient(circle at 12% 8%, rgba(5, 179, 150, 0.12) 0%, rgba(248, 250, 252, 0) 45%);
        min-height: calc(100vh - 80px);
        padding: 2.2rem 2rem 5rem;
        width: 100%;
        max-width: 100vw;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .portal-main-grid {
        max-width: 1440px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 2.2rem;
        align-items: start;
        width: 100%;
        box-sizing: border-box;
    }

    .portal-content-area {
        min-width: 0;
        max-width: 100%;
        width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Left Sidebar Card (Matches Home Page Emerald Theme) */
    .portal-sidebar-card {
        background: #ffffff;
        border: 1.5px solid #a7f3d0;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(5, 179, 150, 0.04);
        overflow: hidden;
        padding: 0.65rem 0;
        position: sticky;
        top: 90px;
    }

    /* Role Header in Sidebar */
    .sidebar-role-header {
        padding: 0.85rem 1.1rem;
        margin: 0.35rem 0.8rem 0.65rem 0.8rem;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .sidebar-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        padding: 3px 9px;
        border-radius: 20px;
        width: fit-content;
    }

    .sidebar-role-badge.super-admin {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.28);
    }

    .sidebar-role-badge.admin {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.28);
    }

    .sidebar-role-badge.user {
        background: rgba(5, 179, 150, 0.12);
        color: #05B396;
        border: 1px solid rgba(5, 179, 150, 0.35);
    }

    .sidebar-role-user-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-section-label {
        display: none !important;
    }

    .sidebar-item-badge-pill {
        margin-left: auto;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        background: rgba(5, 179, 150, 0.12);
        color: #05B396;
    }

    .sidebar-item-badge-pill.super {
        background: rgba(124, 58, 237, 0.14);
        color: #7c3aed;
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

    /* SVG icon safeguards */
    .side-icon,
    svg.side-icon,
    .sidebar-item .side-icon {
        width: 18px !important;
        height: 18px !important;
        min-width: 18px !important;
        max-width: 18px !important;
        min-height: 18px !important;
        max-height: 18px !important;
        color: #475569;
        flex-shrink: 0;
        transition: color 0.15s ease;
    }

    /* Admin Management Components */
    .admin-stat-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.1rem 1.3rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        box-sizing: border-box;
        overflow: hidden;
    }
    .admin-stat-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 0.35rem;
    }
    .admin-stat-val {
        font-size: 1.8rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.25rem;
    }
    .admin-stat-sub {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .admin-filter-pill {
        display: inline-block;
        padding: 0.45rem 0.95rem;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .admin-filter-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .admin-filter-pill.active {
        background: #05B396;
        color: #ffffff;
    }
    .clean-form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.92rem;
        color: #0f172a;
        background: #ffffff;
        box-sizing: border-box;
        outline: none;
        transition: border 0.2s;
    }
    .clean-form-input:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }

    /* Soft mint hover state */
    .sidebar-item:hover {
        background: #f0fdfa;
        color: #05B396;
    }

    .sidebar-item:hover .side-icon {
        color: #05B396;
    }

    /* Active State (4px emerald left bar) */
    .sidebar-item.active {
        background: #f0fdfa;
        color: #05B396;
        font-weight: 700;
        border-left-color: #05B396;
    }

    .sidebar-item.active .side-icon {
        color: #05B396;
    }

    /* Mobile Quick Tab Slider */
    .mobile-portal-nav {
        display: none !important;
        margin-bottom: 1.5rem;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        box-sizing: border-box;
    }

    .mobile-nav-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 0.65rem;
        padding: 0 2px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
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
        background: #f0fdfa;
        border: 1px solid #a7f3d0;
        border-radius: 20px;
        color: #05B396;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .mobile-open-drawer-btn:hover {
        background: #ccfbf1;
    }

    .mobile-tabs-scroll {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 6px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
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
        text-decoration: none;
        transition: all 0.2s;
    }

    .m-portal-tab.active {
        background: #05B396;
        color: #ffffff;
        border-color: #05B396;
    }

    .m-portal-tab:hover {
        border-color: #cbd5e1;
        color: #0f172a;
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
        color: #05B396;
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
        color: #05B396;
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

    /* Responsive Grid Wrappers */
   /* 5 Grid Income Cards Container */
.earnings-grid-container {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1.1rem;
    margin-bottom: 2.2rem;
}

.income-card {
    background: #ffffff;
    padding: 1.3rem 1.1rem;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.income-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
}

.income-card-label {
    color: #64748b;
    font-size: 0.74rem;
    text-transform: uppercase;
    margin-bottom: 0.35rem;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.income-card-value {
    font-size: 1.7rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 0.3rem;
}

.income-card-sub {
    font-size: 0.72rem;
    color: #94a3b8;
    font-weight: 600;
}

/* Card Accent Borders */
.border-today { border-left: 4px solid #10b981; }
.border-blue { border-left: 4px solid #0284c7; }
.border-purple { border-left: 4px solid #8b5cf6; }
.border-amber { border-left: 4px solid #f59e0b; }
.border-teal { border-left: 4px solid #05B396; }

/* Text Colors */
.text-emerald { color: #10b981; }
.text-dark { color: #0f172a; }
.text-purple { color: #8b5cf6; }
.text-amber { color: #f59e0b; }
.text-teal { color: #05B396; }

/* Responsive Grid for 5 Cards */
@media (max-width: 1200px) {
    .earnings-grid-container {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .earnings-grid-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.85rem;
    }
}

@media (max-width: 480px) {
    .earnings-grid-container {
        grid-template-columns: 1fr;
    }
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

    /* Generic Card Box */
    .portal-box-card {
        background: #ffffff;
        padding: 1.8rem;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        margin-bottom: 1.8rem;
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
            padding: 1.2rem 1rem 4rem !important;
            width: 100% !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            box-sizing: border-box !important;
        }

        .portal-main-grid {
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 1rem !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        .portal-content-area {
            min-width: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        /* Hide desktop sidebar on mobile, show quick horizontal slider */
        .portal-sidebar-card {
            display: none !important;
        }

        .mobile-portal-nav {
            display: none !important;
        }

        .courses-cards-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 600px) {
        .portal-greeting-row {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 0.85rem !important;
        }

        .portal-greeting-row button,
        .portal-greeting-row a {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
        }

        .admin-stats-grid {
            grid-template-columns: 1fr !important;
        }

        .referral-box-row {
            flex-direction: column;
        }
        .referral-box-row button {
            width: 100%;
        }
    }

    @media (max-width: 580px) {
        .student-portal-wrapper {
            padding: 0.85rem 0.65rem 3.5rem !important;
        }

        .welcome-heading {
            font-size: clamp(1.2rem, 4.5vw, 1.45rem) !important;
            margin-bottom: 0.85rem !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
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

    /* ==========================================================
       USER DASHBOARD MODERN REDESIGN (MATCHING SCREENSHOT LAYOUT)
       ========================================================== */
    .dashboard-greeting-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.85rem 1.4rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .greeting-bar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .greeting-bar-accent {
        width: 3.5px;
        height: 22px;
        background: #0f172a;
        border-radius: 3px;
        display: inline-block;
    }

    .greeting-bar-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.2px;
    }

    .greeting-refresh-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        color: #64748b;
        padding: 6px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .greeting-refresh-btn:hover {
        background: #f1f5f9;
        color: #05B396;
        transform: rotate(45deg);
    }

    /* Profile Hero Banner */
    .dashboard-profile-banner {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 2.2rem 1.5rem 1.8rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 190px;
    }

    .profile-banner-decor-left,
    .profile-banner-decor-right {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 320px;
        pointer-events: none;
        z-index: 1;
        opacity: 0.95;
    }

    .profile-banner-decor-left {
        left: 0;
    }

    .profile-banner-decor-right {
        right: 0;
    }

    .profile-hero-center {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile-hero-avatar-wrap {
        width: 86px;
        height: 86px;
        border-radius: 50%;
        border: 3.5px solid #ffffff;
        box-shadow: 0 4px 14px rgba(5, 179, 150, 0.25);
        outline: 2.5px solid #05B396;
        overflow: hidden;
        margin-bottom: 0.65rem;
        background: #ffffff;
    }

    .profile-hero-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-hero-name {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.5rem;
        letter-spacing: -0.3px;
    }

    .profile-hero-badge {
        background: #00137a;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 5px 18px;
        border-radius: 20px;
        letter-spacing: 0.3px;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(0, 19, 122, 0.25);
    }

    /* Revenue Grid - 2 cols desktop, 1 col mobile */
    .dashboard-revenue-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .revenue-card {
        border-radius: 12px;
        padding: 1.35rem 1.6rem 1.15rem;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .revenue-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .revenue-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.25rem;
    }

    .revenue-amount {
        font-size: 2.1rem;
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.5px;
    }

    .revenue-icon-box {
        opacity: 0.95;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .revenue-label {
        font-size: 0.96rem;
        font-weight: 600;
        opacity: 0.95;
        margin-bottom: 0.85rem;
    }

    .revenue-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.25);
        margin-bottom: 0.65rem;
    }

    .revenue-detail-link {
        font-size: 0.78rem;
        font-weight: 600;
        color: #ffffff;
        opacity: 0.92;
        text-decoration: none;
        display: inline-block;
        transition: opacity 0.15s ease;
    }

    .revenue-detail-link:hover {
        opacity: 1;
        text-decoration: underline;
    }

    /* Individual Card Color Gradients */
    .revenue-card.card-today {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    }

    .revenue-card.card-7days {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    }

    .revenue-card.card-30days {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .revenue-card.card-alltime {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .revenue-card.card-passive {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    }

    .revenue-card.card-industry {
        background: linear-gradient(135deg, #05B396 0%, #038a74 100%);
    }

    /* 7 Days Sales Graph Card */
    .dashboard-graph-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.5rem 1.8rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .graph-card-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 1.25rem;
    }

    .graph-svg-wrapper {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }

    .graph-svg {
        width: 100%;
        height: auto;
        min-height: 280px;
        display: block;
    }

    .graph-point {
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .graph-point:hover {
        transform: scale(1.35);
        transform-origin: center;
    }

    @media (max-width: 768px) {
        .dashboard-revenue-grid {
            grid-template-columns: 1fr;
            gap: 0.9rem;
        }

        .profile-banner-decor-left,
        .profile-banner-decor-right {
            width: 120px;
            opacity: 0.55;
        }

        .dashboard-profile-banner {
            padding: 1.8rem 1rem 1.5rem;
            min-height: 170px;
        }

        .revenue-amount {
            font-size: 1.85rem;
        }

        .dashboard-graph-card {
            padding: 1.2rem 1rem;
        }
    }
</style>
