@extends('layouts.app')

@section('title', 'Offer, Coupon & 5 Package Pricing Management — Super Admin')

@push('styles')
<style>
    /* Desktop & Base Offers Page Styling */
    .offers-header-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .offers-kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1.1rem;
        margin-bottom: 1.8rem;
    }
    .package-pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .offers-list-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.2rem;
    }
    .modal-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 1rem;
    }
    .pkg-checkbox-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .modal-sheet-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 680px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 1.8rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        position: relative;
        box-sizing: border-box;
    }
    .offers-tabs-scroll {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
    .offers-tabs-scroll::-webkit-scrollbar {
        height: 4px;
    }
    .offers-tabs-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    /* Mobile Responsive Optimizations (< 768px) */
    @media (max-width: 768px) {
        .portal-greeting-row {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 0.85rem !important;
        }
        .offers-header-actions {
            width: 100% !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
        }
        .offers-header-actions .btn {
            font-size: 0.82rem !important;
            padding: 0.6rem 0.65rem !important;
            justify-content: center !important;
            text-align: center !important;
        }
        .offers-header-actions .btn:last-child {
            grid-column: span 2;
        }
        .offers-kpi-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem !important;
            margin-bottom: 1.2rem !important;
        }
        .admin-stat-card {
            padding: 1rem !important;
            border-radius: 10px !important;
        }
        .admin-stat-card .stat-val {
            font-size: 1.45rem !important;
        }
        .package-pricing-grid,
        .offers-list-grid {
            grid-template-columns: 1fr !important;
            gap: 1.1rem !important;
        }
        .modal-sheet-card {
            padding: 1.25rem 1rem !important;
            max-width: 95% !important;
            border-radius: 12px !important;
        }
    }

    /* Extra Small Screen Optimizations (< 480px) */
    @media (max-width: 480px) {
        .welcome-heading {
            font-size: 1.35rem !important;
            flex-wrap: wrap !important;
        }
        .admin-stat-card {
            padding: 0.85rem !important;
        }
        .admin-stat-card .stat-val {
            font-size: 1.3rem !important;
        }
        .modal-grid-2 {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }
        .pkg-checkbox-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        .portal-box-card {
            padding: 1rem !important;
            border-radius: 10px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-offers'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-offers'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Welcome Banner -->
            <div class="portal-greeting-row">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.65rem; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 10px;">
                        <span>🏷️ Offer &amp; Discount Management</span>
                        <span style="font-size: 0.72rem; font-weight: 800; background: #fef3c7; color: #b45309; padding: 3px 9px; border-radius: 20px; border: 1px solid #fde68a;">
                            SUPER ADMIN
                        </span>
                    </h2>
                    <p style="font-size: 0.92rem; color: #64748b; margin: 0;">
                        Manage flash sales, coupon codes, festival discounts, bundle offers, and set the dynamic pricing &amp; referral commissions for your 5 core packages.
                    </p>
                </div>
                <div class="offers-header-actions">
                    <button type="button" onclick="openOfferModal()" class="btn" style="background: #05B396; color: #fff; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(5,179,150,0.25);">
                        <span>⚡ Launch Offer</span>
                    </button>
                    <button type="button" onclick="openCouponModal()" class="btn" style="background: #7c3aed; color: #fff; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(124,58,237,0.25);">
                        <span>🎟️ Create Coupon</span>
                    </button>
                    <a href="{{ route('admin.run-migrations') }}" class="btn" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1rem; border-radius: 8px; text-decoration: none;" title="Run DB migrations on live hosting">
                        🔄 Sync DB
                    </a>
                </div>
            </div>

            {{-- Flash Alert Messages --}}
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.94rem; font-weight: 600; box-shadow: 0 2px 6px rgba(5, 179, 150, 0.1);">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.94rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 1.2rem; font-weight: 600;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 1. Executive Summary KPI Cards -->
            <div class="offers-kpi-grid">
                <!-- KPI 1: Active Offers -->
                <div class="admin-stat-card" style="border-top: 4px solid #05B396; background: #ffffff; border-radius: 12px; padding: 1.3rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #05B396; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 4px;">
                        ⚡ ACTIVE OFFERS &amp; FLASH SALES
                    </div>
                    <div class="stat-val" style="font-size: 1.85rem; font-weight: 900; color: #0f172a; line-height: 1.2; margin-bottom: 4px;">
                        {{ $stats['active_offers'] }} <span style="font-size: 0.95rem; font-weight: 600; color: #64748b;">/ {{ $stats['total_offers'] }} total</span>
                    </div>
                    <div style="font-size: 0.78rem; color: #64748b; font-weight: 600;">
                        Live timer &amp; homepage flash banners
                    </div>
                </div>

                <!-- KPI 2: Active Coupons -->
                <div class="admin-stat-card" style="border-top: 4px solid #7c3aed; background: #ffffff; border-radius: 12px; padding: 1.3rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #7c3aed; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 4px;">
                        🎟️ ACTIVE COUPON CODES
                    </div>
                    <div class="stat-val" style="font-size: 1.85rem; font-weight: 900; color: #7c3aed; line-height: 1.2; margin-bottom: 4px;">
                        {{ $stats['active_coupons'] }} <span style="font-size: 0.95rem; font-weight: 600; color: #64748b;">/ {{ $stats['total_coupons'] }} total</span>
                    </div>
                    <div style="font-size: 0.78rem; color: #64748b; font-weight: 600;">
                        Checkout coupon code redemptions
                    </div>
                </div>

                <!-- KPI 3: Total Redemptions (Kitne logon ne use kiya) -->
                <div class="admin-stat-card" style="border-top: 4px solid #2563eb; background: #ffffff; border-radius: 12px; padding: 1.3rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #2563eb; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 4px;">
                        👥 TOTAL USERS REDEEMED
                    </div>
                    <div class="stat-val" style="font-size: 1.85rem; font-weight: 900; color: #2563eb; line-height: 1.2; margin-bottom: 4px;">
                        {{ number_format($stats['total_redemptions']) }}
                    </div>
                    <div style="font-size: 0.78rem; color: #64748b; font-weight: 600;">
                        Kitne students ne offer/coupon use kiya
                    </div>
                </div>

                <!-- KPI 4: Total Discount Disbursed -->
                <div class="admin-stat-card" style="border-top: 4px solid #ea580c; background: #ffffff; border-radius: 12px; padding: 1.3rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #ea580c; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 4px;">
                        💰 TOTAL DISCOUNT GIVEN
                    </div>
                    <div class="stat-val" style="font-size: 1.85rem; font-weight: 900; color: #ea580c; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['total_discount_given']) }}
                    </div>
                    <div style="font-size: 0.78rem; color: #64748b; font-weight: 600;">
                        Savings distributed to customers
                    </div>
                </div>
            </div>

            <!-- 2. Master Navigation Tabs -->
            <div class="offers-tabs-scroll" style="background: #ffffff; border-radius: 12px; padding: 6px; display: flex; gap: 8px; margin-bottom: 1.8rem; border: 1px solid #e2e8f0; overflow-x: auto; flex-wrap: nowrap; -webkit-overflow-scrolling: touch;">
                <a href="{{ route('admin.offers', ['tab' => 'offers']) }}" class="tab-btn {{ $currentTab === 'offers' ? 'active' : '' }}" style="padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; {{ $currentTab === 'offers' ? 'background: #05B396; color: #fff;' : 'color: #64748b; background: transparent;' }}">
                    <span>⚡ Offers &amp; Flash Sales ({{ $offers->count() }})</span>
                </a>
                <a href="{{ route('admin.offers', ['tab' => 'coupons']) }}" class="tab-btn {{ $currentTab === 'coupons' ? 'active' : '' }}" style="padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; {{ $currentTab === 'coupons' ? 'background: #7c3aed; color: #fff;' : 'color: #64748b; background: transparent;' }}">
                    <span>🎟️ Coupon Codes ({{ $coupons->count() }})</span>
                </a>
                <a href="{{ route('admin.offers', ['tab' => 'packages']) }}" class="tab-btn {{ $currentTab === 'packages' ? 'active' : '' }}" style="padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; {{ $currentTab === 'packages' ? 'background: #0284c7; color: #fff;' : 'color: #64748b; background: transparent;' }}">
                    <span>📦 5 Packages Pricing &amp; Commissions</span>
                </a>
                <a href="{{ route('admin.offers', ['tab' => 'reports']) }}" class="tab-btn {{ $currentTab === 'reports' ? 'active' : '' }}" style="padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; {{ $currentTab === 'reports' ? 'background: #1e293b; color: #fff;' : 'color: #64748b; background: transparent;' }}">
                    <span>📊 Performance Report ({{ $stats['total_redemptions'] }})</span>
                </a>
            </div>

            {{-- ======================================================== --}}
            {{-- TAB 1: OFFERS & FLASH SALES                              --}}
            {{-- ======================================================== --}}
            @if($currentTab === 'offers')
                <div class="portal-box-card" style="border-radius: 14px; padding: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.4rem; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                                Active Offers &amp; Festival Flash Sales
                            </h3>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                                Offers apply automatically to target packages and can display a live countdown timer banner on the homepage.
                            </p>
                        </div>
                        <button type="button" onclick="openOfferModal()" class="btn" style="background: #05B396; color: #fff; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.2rem; border-radius: 8px; border: none; cursor: pointer;">
                            + Launch New Offer
                        </button>
                    </div>

                    @if($offers->isEmpty())
                        <div style="text-align: center; padding: 3rem 1.5rem; background: #f8fafc; border-radius: 12px; border: 1.5px dashed #cbd5e1;">
                            <div style="font-size: 2.5rem; margin-bottom: 10px;">⚡</div>
                            <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">No Offers Created Yet</div>
                            <p style="font-size: 0.88rem; color: #64748b; max-width: 440px; margin: 0 auto 1.2rem;">
                                Launch your first flash sale, festival offer, or package discount to boost conversions and student enrollments.
                            </p>
                            <button type="button" onclick="openOfferModal()" class="btn" style="background: #05B396; color: #fff; font-weight: 700; padding: 0.6rem 1.4rem; border-radius: 8px; border: none; cursor: pointer;">
                                Launch Flash Sale Now
                            </button>
                        </div>
                    @else
                        <div class="offers-list-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.2rem;">
                            @foreach($offers as $offer)
                                @php
                                    $isLive = method_exists($offer, 'isLive') ? $offer->isLive() : ($offer->status === 'active');
                                    $appPkgs = is_array($offer->applicable_packages) ? $offer->applicable_packages : json_decode($offer->applicable_packages ?? '["all"]', true);
                                    if (empty($appPkgs)) { $appPkgs = ['all']; }
                                @endphp
                                <div style="background: #ffffff; border: 1.5px solid {{ $isLive ? '#05B396' : '#e2e8f0' }}; border-radius: 12px; padding: 1.3rem; display: flex; flex-direction: column; justify-content: space-between; position: relative; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                                    <div>
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 0.75rem;">
                                            <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; background: {{ $offer->offer_type === 'flash_sale' ? '#fef3c7; color: #b45309;' : ($offer->offer_type === 'festival' ? '#fce7f3; color: #be185d;' : '#e0f2fe; color: #0369a1;') }}">
                                                {{ strtoupper(str_replace('_', ' ', $offer->offer_type)) }}
                                            </span>
                                            <span style="font-size: 0.74rem; font-weight: 800; padding: 3px 8px; border-radius: 20px; {{ $isLive ? 'background: #dcfce7; color: #15803d;' : ($offer->status === 'paused' ? 'background: #fef3c7; color: #b45309;' : 'background: #f1f5f9; color: #64748b;') }}">
                                                {{ $isLive ? '● LIVE NOW' : strtoupper($offer->status) }}
                                            </span>
                                        </div>

                                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
                                            {{ $offer->title }}
                                        </h4>

                                        @if($offer->badge_text)
                                            <div style="display: inline-block; background: linear-gradient(135deg, #05B396, #0284c7); color: #fff; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px; margin-bottom: 8px;">
                                                {{ $offer->badge_text }}
                                            </div>
                                        @endif

                                        <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; font-size: 0.88rem;">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                                <span style="color: #64748b;">Discount Value:</span>
                                                <strong style="color: #05B396; font-size: 0.95rem;">
                                                    @if($offer->discount_type === 'percentage')
                                                        {{ number_format($offer->discount_value) }}% OFF
                                                    @elseif($offer->discount_type === 'flat')
                                                        ₹{{ number_format($offer->discount_value) }} FLAT OFF
                                                    @else
                                                        BUNDLE DEAL (Free Bonus)
                                                    @endif
                                                </strong>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                                <span style="color: #64748b;">Target Packages:</span>
                                                <strong style="color: #334155; text-transform: capitalize;">
                                                    {{ in_array('all', $appPkgs) ? 'All 5 Packages' : implode(', ', $appPkgs) }}
                                                </strong>
                                            </div>
                                            @if($offer->bundle_buy_package && $offer->bundle_free_package)
                                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px; color: #7c3aed; font-weight: 700;">
                                                    <span>Bundle Rule:</span>
                                                    <span>Buy {{ ucfirst($offer->bundle_buy_package) }} ➔ Get {{ ucfirst($offer->bundle_free_package) }} FREE</span>
                                                </div>
                                            @endif
                                            @if($offer->ends_at)
                                                <div style="display: flex; justify-content: space-between; margin-top: 4px; color: #dc2626; font-weight: 600;">
                                                    <span>Ends On:</span>
                                                    <span>{{ \Carbon\Carbon::parse($offer->ends_at)->format('d M Y, h:i A') }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div style="display: flex; gap: 14px; font-size: 0.82rem; color: #64748b; margin-bottom: 1rem;">
                                            <div>👥 <strong>{{ number_format($offer->uses_count ?? 0) }}</strong> uses</div>
                                            <div>💰 <strong>₹{{ number_format($offer->total_discount_given ?? 0) }}</strong> saved</div>
                                            @if($offer->show_timer)
                                                <div style="color: #05B396; font-weight: 700;">⏱️ Timer Active</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 0.85rem; flex-wrap: wrap;">
                                        @if($offer->id)
                                            @if($offer->status === 'active')
                                                <!-- 1. Pause Offer -->
                                                <form method="POST" action="{{ route('admin.offers.toggle-status', $offer->id) }}" style="flex: 1; min-width: 90px; margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn" title="Temporarily pause offer" style="width: 100%; font-size: 0.8rem; font-weight: 700; padding: 0.5rem; border-radius: 6px; border: 1px solid #cbd5e1; background: #ffffff; color: #334155; cursor: pointer;">
                                                        ⏸ Pause
                                                    </button>
                                                </form>

                                                <!-- 2. Stop Offer (Expires immediately) -->
                                                <form method="POST" action="{{ route('admin.offers.stop', $offer->id) }}" onsubmit="return confirm('Stop this offer immediately? It will expire now and remove all discounts.')" style="flex: 1; min-width: 100px; margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn" title="Stop and expire offer now" style="width: 100%; font-size: 0.8rem; font-weight: 800; padding: 0.5rem; border-radius: 6px; border: 1px solid #fed7aa; background: #fff7ed; color: #c2410c; cursor: pointer;">
                                                        ⏹️ Stop Offer
                                                    </button>
                                                </form>
                                            @elseif($offer->status === 'paused')
                                                <!-- Resume Offer -->
                                                <form method="POST" action="{{ route('admin.offers.toggle-status', $offer->id) }}" style="flex: 1; min-width: 90px; margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="width: 100%; font-size: 0.8rem; font-weight: 700; padding: 0.5rem; border-radius: 6px; border: 1px solid #86efac; background: #f0fdf4; color: #15803d; cursor: pointer;">
                                                        ▶ Resume
                                                    </button>
                                                </form>

                                                <!-- Stop Offer -->
                                                <form method="POST" action="{{ route('admin.offers.stop', $offer->id) }}" onsubmit="return confirm('Mark this offer as Expired permanently?')" style="flex: 1; min-width: 100px; margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="width: 100%; font-size: 0.8rem; font-weight: 800; padding: 0.5rem; border-radius: 6px; border: 1px solid #fed7aa; background: #fff7ed; color: #c2410c; cursor: pointer;">
                                                        ⏹️ Stop Offer
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Expired: Option to Re-activate -->
                                                <form method="POST" action="{{ route('admin.offers.toggle-status', $offer->id) }}" style="flex: 1; min-width: 110px; margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="width: 100%; font-size: 0.8rem; font-weight: 700; padding: 0.5rem; border-radius: 6px; border: 1px solid #cbd5e1; background: #ffffff; color: #334155; cursor: pointer;">
                                                        🔄 Re-activate
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- 3. Delete Offer -->
                                            <form method="POST" action="{{ route('admin.offers.destroy', $offer->id) }}" onsubmit="return confirm('Delete this offer permanently?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn" title="Delete Offer" style="font-size: 0.8rem; font-weight: 700; padding: 0.5rem 0.85rem; border-radius: 6px; border: 1px solid #fecaca; background: #fef2f2; color: #dc2626; cursor: pointer;">
                                                    🗑
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- ======================================================== --}}
            {{-- TAB 2: COUPON CODES MANAGEMENT                           --}}
            {{-- ======================================================== --}}
            @if($currentTab === 'coupons')
                <div class="portal-box-card" style="border-radius: 14px; padding: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.4rem; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                                Coupon Codes &amp; Usage Control
                            </h3>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                                Create promo codes with total usage caps, per-student limits, expiry dates, and package eligibility.
                            </p>
                        </div>
                        <button type="button" onclick="openCouponModal()" class="btn" style="background: #7c3aed; color: #fff; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.2rem; border-radius: 8px; border: none; cursor: pointer;">
                            + Create Coupon Code
                        </button>
                    </div>

                    @if($coupons->isEmpty())
                        <div style="text-align: center; padding: 3rem 1.5rem; background: #f8fafc; border-radius: 12px; border: 1.5px dashed #cbd5e1;">
                            <div style="font-size: 2.5rem; margin-bottom: 10px;">🎟️</div>
                            <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">No Coupon Codes Created</div>
                            <p style="font-size: 0.88rem; color: #64748b; max-width: 440px; margin: 0 auto 1.2rem;">
                                Create codes like <code>WELCOME20</code> or <code>DIWALI100</code> with custom limits that students can enter during checkout.
                            </p>
                            <button type="button" onclick="openCouponModal()" class="btn" style="background: #7c3aed; color: #fff; font-weight: 700; padding: 0.6rem 1.4rem; border-radius: 8px; border: none; cursor: pointer;">
                                Create First Coupon
                            </button>
                        </div>
                    @else
                        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table style="width: 100%; min-width: 620px; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-size: 0.78rem; text-transform: uppercase;">
                                        <th style="padding: 12px 14px;">Coupon Code</th>
                                        <th style="padding: 12px 14px;">Discount</th>
                                        <th style="padding: 12px 14px;">Eligible Packages</th>
                                        <th style="padding: 12px 14px;">Usage Limits</th>
                                        <th style="padding: 12px 14px;">Expiry Date</th>
                                        <th style="padding: 12px 14px;">Status</th>
                                        <th style="padding: 12px 14px; text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $c)
                                        @php
                                            $cPkgs = is_array($c->applicable_packages) ? $c->applicable_packages : json_decode($c->applicable_packages ?? '["all"]', true);
                                            if (empty($cPkgs)) { $cPkgs = ['all']; }
                                            $isCValid = method_exists($c, 'isValid') ? $c->isValid() : ($c->status === 'active');
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s ease;">
                                            <td style="padding: 12px 14px;">
                                                <div style="display: inline-flex; align-items: center; gap: 6px; background: #faf5ff; border: 1.5px dashed #a855f7; color: #7c3aed; font-family: monospace; font-size: 0.95rem; font-weight: 800; padding: 4px 10px; border-radius: 6px;">
                                                    {{ $c->code }}
                                                </div>
                                                @if($c->description)
                                                    <div style="font-size: 0.78rem; color: #64748b; margin-top: 4px;">{{ $c->description }}</div>
                                                @endif
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <strong style="color: #05B396; font-size: 0.95rem;">
                                                    @if($c->discount_type === 'percentage')
                                                        {{ number_format($c->discount_value) }}% OFF
                                                        @if($c->max_discount_amount)
                                                            <span style="font-size: 0.76rem; color: #64748b; font-weight: normal;">(Max ₹{{ number_format($c->max_discount_amount) }})</span>
                                                        @endif
                                                    @else
                                                        ₹{{ number_format($c->discount_value) }} FLAT OFF
                                                    @endif
                                                </strong>
                                                @if($c->min_order_amount > 0)
                                                    <div style="font-size: 0.76rem; color: #64748b;">Min Order: ₹{{ number_format($c->min_order_amount) }}</div>
                                                @endif
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <span style="font-size: 0.8rem; background: #f1f5f9; padding: 3px 8px; border-radius: 4px; color: #334155; font-weight: 600; text-transform: capitalize;">
                                                    {{ in_array('all', $cPkgs) ? 'All 5 Packages' : implode(', ', $cPkgs) }}
                                                </span>
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <div style="font-weight: 700; color: #0f172a;">
                                                    {{ number_format($c->used_count ?? 0) }} / {{ $c->usage_limit ? number_format($c->usage_limit) : '∞' }} used
                                                </div>
                                                <div style="font-size: 0.76rem; color: #64748b;">
                                                    Limit: {{ $c->per_user_limit ?? 1 }} per user
                                                </div>
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                @if($c->expires_at)
                                                    <div style="font-size: 0.82rem; font-weight: 600; color: #334155;">
                                                        {{ \Carbon\Carbon::parse($c->expires_at)->format('d M Y') }}
                                                    </div>
                                                    <div style="font-size: 0.74rem; color: #64748b;">
                                                        {{ \Carbon\Carbon::parse($c->expires_at)->format('h:i A') }}
                                                    </div>
                                                @else
                                                    <span style="color: #64748b; font-size: 0.82rem;">No Expiry (Lifetime)</span>
                                                @endif
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <span style="font-size: 0.75rem; font-weight: 800; padding: 3px 8px; border-radius: 20px; {{ $isCValid ? 'background: #dcfce7; color: #15803d;' : ($c->status === 'paused' ? 'background: #fef3c7; color: #b45309;' : 'background: #f1f5f9; color: #64748b;') }}">
                                                    {{ $isCValid ? 'ACTIVE' : strtoupper($c->status) }}
                                                </span>
                                            </td>
                                            <td style="padding: 12px 14px; text-align: right;">
                                                @if($c->id)
                                                    <div style="display: inline-flex; gap: 6px;">
                                                        <form method="POST" action="{{ route('admin.coupons.toggle-status', $c->id) }}" style="margin: 0;">
                                                            @csrf
                                                            <button type="submit" class="btn" style="font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1; background: #ffffff; color: #334155; cursor: pointer;">
                                                                {{ $c->status === 'active' ? '⏸ Pause' : '▶ Activate' }}
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.coupons.destroy', $c->id) }}" onsubmit="return confirm('Delete this coupon code?')" style="margin: 0;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn" style="font-size: 0.78rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; border: 1px solid #fecaca; background: #fef2f2; color: #dc2626; cursor: pointer;">
                                                                🗑
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ======================================================== --}}
            {{-- TAB 3: 5 PACKAGES PRICING & COMMISSION MATRIX            --}}
            {{-- ======================================================== --}}
            @if($currentTab === 'packages')
                <div class="portal-box-card" style="border-radius: 14px; padding: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                            📦 Dynamic 5 Packages Pricing &amp; Commission Matrix
                        </h3>
                        <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                            Agar aap kisi bhi package ka amount ya commission change karenge, to ye <strong>Homepage, Plans page, Buy Now checkout page, aur Affiliate commissions me TURANT update ho jayega!</strong>
                        </p>
                    </div>

                    <div class="package-pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                        @foreach($packages as $pkg)
                            <div style="background: #ffffff; border: 2px solid {{ $pkg['color'] ?? '#05B396' }}; border-radius: 14px; padding: 1.4rem; box-shadow: 0 6px 18px rgba(0,0,0,0.04); position: relative; display: flex; flex-direction: column; justify-content: space-between;">
                                <form method="POST" action="{{ route('admin.packages.update', $pkg['id']) }}">
                                    @csrf

                                    <!-- Top Package Header -->
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.85rem;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ asset($pkg['image']) }}" alt="{{ $pkg['name'] }}" style="width: 42px; height: 42px; object-fit: contain;">
                                            <div>
                                                <div style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                                                    {{ $pkg['name'] }}
                                                </div>
                                                <span style="font-size: 0.72rem; font-weight: 800; color: {{ $pkg['color'] ?? '#05B396' }}; text-transform: uppercase;">
                                                    SLUG: {{ $pkg['id'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <span style="background: {{ ($pkg['color'] ?? '#05B396') }}20; color: {{ $pkg['color'] ?? '#05B396' }}; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                                            {{ $pkg['access_badge'] ?? 'Access' }}
                                        </span>
                                    </div>

                                    <!-- Package Name Edit -->
                                    <div style="margin-bottom: 0.85rem;">
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 4px;">
                                            Package Display Name
                                        </label>
                                        <input type="text" name="name" value="{{ $pkg['name'] }}" required style="width: 100%; padding: 0.55rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 700; color: #1e293b; box-sizing: border-box;">
                                    </div>

                                    <!-- Selling Price & Old MRP (Two Columns) -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 0.85rem;">
                                        <div>
                                            <label style="display: block; font-size: 0.8rem; font-weight: 800; color: #05B396; margin-bottom: 4px;">
                                                Selling Price (₹)
                                            </label>
                                            <input type="number" step="1" name="price" value="{{ (int)$pkg['price'] }}" required style="width: 100%; padding: 0.55rem 0.75rem; border: 2px solid #05B396; border-radius: 8px; font-size: 1.1rem; font-weight: 900; color: #0f172a; box-sizing: border-box;">
                                        </div>
                                        <div>
                                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                                                Old Price / MRP (₹)
                                            </label>
                                            <input type="number" step="1" name="old_price" value="{{ (int)$pkg['old_price'] }}" style="width: 100%; padding: 0.55rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; color: #64748b; box-sizing: border-box;">
                                        </div>
                                    </div>

                                    <!-- 2-Tier Commission Matrix (Active & Passive) -->
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; margin-bottom: 0.85rem;">
                                        <div style="font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">
                                            Commission Distribution
                                        </div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                            <div>
                                                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #0284c7; margin-bottom: 3px;">
                                                    Active Income (₹)
                                                </label>
                                                <input type="number" step="1" name="active_income" value="{{ (int)($pkg['active_income'] ?? 0) }}" required style="width: 100%; padding: 0.5rem 0.65rem; border: 1.5px solid #bae6fd; border-radius: 6px; font-size: 0.95rem; font-weight: 800; color: #0284c7; box-sizing: border-box;">
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #7c3aed; margin-bottom: 3px;">
                                                    Passive Income (₹)
                                                </label>
                                                <input type="number" step="1" name="passive_income" value="{{ (int)($pkg['passive_income'] ?? 0) }}" required style="width: 100%; padding: 0.5rem 0.65rem; border: 1.5px solid #ddd6fe; border-radius: 6px; font-size: 0.95rem; font-weight: 800; color: #7c3aed; box-sizing: border-box;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Badge & Description -->
                                    <div style="margin-bottom: 0.85rem;">
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 4px;">
                                            Promotional Badge Text
                                        </label>
                                        <input type="text" name="badge" value="{{ $pkg['badge'] ?? '' }}" placeholder="e.g. MOST POPULAR, BEST VALUE" style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; font-weight: 600; box-sizing: border-box;">
                                    </div>

                                    <div style="margin-bottom: 1.2rem;">
                                        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 4px;">
                                            Short Description
                                        </label>
                                        <textarea name="desc" rows="2" style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.82rem; color: #334155; box-sizing: border-box; resize: vertical;">{{ $pkg['desc'] ?? '' }}</textarea>
                                    </div>

                                    <!-- Save Button -->
                                    <button type="submit" class="btn" style="width: 100%; background: #05B396; color: #ffffff; font-weight: 800; font-size: 0.88rem; padding: 0.65rem; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.2);">
                                        💾 Save {{ $pkg['name'] }} Pricing
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ======================================================== --}}
            {{-- TAB 4: OFFER PERFORMANCE REPORT                          --}}
            {{-- ======================================================== --}}
            @if($currentTab === 'reports')
                <div class="portal-box-card" style="border-radius: 14px; padding: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                    <div style="margin-bottom: 1.4rem;">
                        <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                            📊 Offer &amp; Coupon Performance Logs (Kitne Log Ne Use Kiya)
                        </h3>
                        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                            Audit report of every student who claimed a discount or applied a coupon code during checkout.
                        </p>
                    </div>

                    @if(!Schema::hasTable('offer_redemptions') || $redemptions->isEmpty())
                        <div style="text-align: center; padding: 3rem 1.5rem; background: #f8fafc; border-radius: 12px; border: 1.5px dashed #cbd5e1;">
                            <div style="font-size: 2.5rem; margin-bottom: 10px;">📊</div>
                            <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">No Redemptions Recorded Yet</div>
                            <p style="font-size: 0.88rem; color: #64748b; max-width: 440px; margin: 0 auto;">
                                When students apply coupon codes or purchase during an active flash sale, their order details and discount savings will appear here in real time.
                            </p>
                        </div>
                    @else
                        <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table style="width: 100%; min-width: 620px; border-collapse: collapse; font-size: 0.88rem; text-align: left;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-size: 0.78rem; text-transform: uppercase;">
                                        <th style="padding: 12px 14px;">Student / Buyer</th>
                                        <th style="padding: 12px 14px;">Package Purchased</th>
                                        <th style="padding: 12px 14px;">Code / Offer</th>
                                        <th style="padding: 12px 14px;">Original Price</th>
                                        <th style="padding: 12px 14px;">Discount Given</th>
                                        <th style="padding: 12px 14px;">Final Amount Paid</th>
                                        <th style="padding: 12px 14px;">Date &amp; Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($redemptions as $r)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 12px 14px;">
                                                <div style="font-weight: 700; color: #0f172a;">{{ $r->user_name ?: 'Student' }}</div>
                                                <div style="font-size: 0.78rem; color: #64748b;">{{ $r->user_email ?: $r->user_phone }}</div>
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <span style="font-weight: 700; color: #334155;">{{ $r->package_name }}</span>
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <span style="font-family: monospace; font-weight: 800; background: #faf5ff; color: #7c3aed; padding: 3px 8px; border-radius: 4px; border: 1px dashed #c084fc;">
                                                    {{ $r->code_used ?: 'Flash Sale' }}
                                                </span>
                                            </td>
                                            <td style="padding: 12px 14px; color: #64748b; text-decoration: line-through;">
                                                ₹{{ number_format($r->original_amount) }}
                                            </td>
                                            <td style="padding: 12px 14px; color: #16a34a; font-weight: 700;">
                                                - ₹{{ number_format($r->discount_amount) }}
                                            </td>
                                            <td style="padding: 12px 14px;">
                                                <strong style="color: #05B396; font-size: 1rem;">₹{{ number_format($r->final_amount) }}</strong>
                                            </td>
                                            <td style="padding: 12px 14px; font-size: 0.8rem; color: #64748b;">
                                                {{ $r->created_at ? $r->created_at->format('d M Y, h:i A') : 'Recently' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($redemptions, 'links'))
                            <div style="margin-top: 1.2rem;">
                                {{ $redemptions->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            @endif

        </main>
    </div>
</div>

{{-- ======================================================== --}}
{{-- MODAL 1: LAUNCH OFFER (FLASH SALE, FESTIVAL, BUNDLE)     --}}
{{-- ======================================================== --}}
<div id="offerModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1.5rem; box-sizing: border-box;">
    <div class="modal-sheet-card" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto; padding: 1.8rem; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; box-sizing: border-box;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.8rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <span>⚡ Launch New Offer / Flash Sale</span>
            </h3>
            <button type="button" onclick="closeOfferModal()" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.offers.store') }}">
            @csrf

            <!-- Offer Title -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                    Offer Title <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="title" required placeholder="e.g. Diwali Dhamaka 25% Off / 24-Hour Flash Sale" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; box-sizing: border-box;">
            </div>

            <!-- Offer Type & Discount Type (Two Columns) -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Offer Type
                    </label>
                    <select name="offer_type" id="offerTypeSelect" onchange="toggleBundleFields(this.value)" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 600; box-sizing: border-box;">
                        <option value="flash_sale">⚡ Flash Sale (Live Countdown Timer)</option>
                        <option value="festival">🎉 Festival Special Offer</option>
                        <option value="discount">🏷️ Flat Discount</option>
                        <option value="bundle">🎁 Bundle Offer (Buy 2 Get 1 Free)</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Discount Type
                    </label>
                    <select name="discount_type" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 600; box-sizing: border-box;">
                        <option value="percentage">Percentage (%) Discount</option>
                        <option value="flat">Flat Cash (₹) Discount</option>
                        <option value="bundle_free">Bundle Free Package</option>
                    </select>
                </div>
            </div>

            <!-- Discount Value & Badge Text -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Discount Value <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" step="0.01" name="discount_value" required value="20" placeholder="e.g. 20 (for 20%) or 500 (for ₹500)" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; font-weight: 700; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Badge Text (Shows on cards)
                    </label>
                    <input type="text" name="badge_text" placeholder="e.g. ⚡ 20% OFF FLASH SALE" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Bundle Settings Row (Hidden unless Bundle selected) -->
            <div id="bundleSettingsBox" style="display: none; background: #faf5ff; border: 1.5px dashed #a855f7; border-radius: 10px; padding: 12px 14px; margin-bottom: 1rem;">
                <div style="font-size: 0.82rem; font-weight: 800; color: #7c3aed; margin-bottom: 6px;">
                    🎁 Bundle Deal Rules
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #475569; margin-bottom: 3px;">
                            When Student Buys:
                        </label>
                        <select name="bundle_buy_package" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem;">
                            <option value="growth">Growth Package</option>
                            <option value="advance" selected>Advance Package</option>
                            <option value="premium">Premium Package</option>
                            <option value="infinity">Infinity Package</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.78rem; font-weight: 700; color: #475569; margin-bottom: 3px;">
                            Student Gets FREE:
                        </label>
                        <select name="bundle_free_package" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem;">
                            <option value="basic" selected>Basic Package (FREE)</option>
                            <option value="growth">Growth Package (FREE)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Applicable Packages Selection -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    Select Applicable Packages (Ye offer kin packages par lagega)
                </label>
                <div class="pkg-checkbox-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="basic" checked> Basic
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="growth" checked> Growth
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="advance" checked> Advance
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="premium" checked> Premium
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="infinity" checked> Infinity
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 700; color: #05B396; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="all" checked> All 5 Packages
                    </label>
                </div>
            </div>

            <!-- Start Date & End Date (With Timer) -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Start Date &amp; Time
                    </label>
                    <input type="datetime-local" name="starts_at" value="{{ now('Asia/Kolkata')->format('Y-m-d\TH:i') }}" style="width: 100%; padding: 0.6rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        End Date &amp; Time (For Timer)
                    </label>
                    <input type="datetime-local" name="ends_at" value="{{ now('Asia/Kolkata')->addDays(3)->format('Y-m-d\TH:i') }}" style="width: 100%; padding: 0.6rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Show Live Timer Checkbox -->
            <div style="margin-bottom: 1rem;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; font-weight: 700; color: #0f172a; cursor: pointer;">
                    <input type="checkbox" name="show_timer" value="1" checked style="width: 16px; height: 16px;">
                    <span>Display live countdown timer banner at the top of Homepage &amp; Plans page</span>
                </label>
            </div>

            <!-- Banner Message -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                    Banner Message (Optional promotional line)
                </label>
                <input type="text" name="banner_message" placeholder="e.g. Special Festival Offer: Get flat 20% discount on all packages! Offer expires soon." style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeOfferModal()" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 700; padding: 0.65rem 1.4rem; border-radius: 8px; border: none; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn" style="background: #05B396; color: #ffffff; font-weight: 800; padding: 0.65rem 1.8rem; border-radius: 8px; border: none; cursor: pointer;">
                    🚀 Launch Offer Now
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================================================== --}}
{{-- MODAL 2: CREATE COUPON CODE                              --}}
{{-- ======================================================== --}}
<div id="couponModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 99999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1.5rem; box-sizing: border-box;">
    <div class="modal-sheet-card" style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; padding: 1.8rem; box-shadow: 0 20px 40px rgba(0,0,0,0.2); position: relative; box-sizing: border-box;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.8rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <span>🎟️ Create Coupon Code</span>
            </h3>
            <button type="button" onclick="closeCouponModal()" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf

            <!-- Coupon Code & Discount Type -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Coupon Code <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="code" required placeholder="e.g. WELCOME20" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 800; text-transform: uppercase; font-family: monospace; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Discount Type
                    </label>
                    <select name="discount_type" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 600; box-sizing: border-box;">
                        <option value="percentage">Percentage (%) Discount</option>
                        <option value="flat">Flat Cash (₹) Discount</option>
                    </select>
                </div>
            </div>

            <!-- Discount Value & Max Discount Cap -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Discount Value <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" step="0.01" name="discount_value" required value="20" placeholder="e.g. 20 (for 20%) or 200 (for ₹200)" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; font-weight: 700; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Max Discount Cap (₹) (Optional)
                    </label>
                    <input type="number" step="1" name="max_discount_amount" placeholder="e.g. 1000" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Usage Limit & Per-User Limit -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Total Usage Limit (Overall uses)
                    </label>
                    <input type="number" name="usage_limit" placeholder="e.g. 100 (leave blank for unlimited)" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Per-User Limit
                    </label>
                    <input type="number" name="per_user_limit" value="1" min="1" required style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; font-weight: 700; box-sizing: border-box;">
                </div>
            </div>

            <!-- Minimum Order Amount & Expiry Date -->
            <div class="modal-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Min Order Amount (₹)
                    </label>
                    <input type="number" step="1" name="min_order_amount" value="0" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                        Expiry Date &amp; Time
                    </label>
                    <input type="datetime-local" name="expires_at" value="{{ now('Asia/Kolkata')->addDays(30)->format('Y-m-d\TH:i') }}" style="width: 100%; padding: 0.6rem 0.75rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
                </div>
            </div>

            <!-- Applicable Packages -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    Select Applicable Packages
                </label>
                <div class="pkg-checkbox-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="basic" checked> Basic
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="growth" checked> Growth
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="advance" checked> Advance
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="premium" checked> Premium
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="infinity" checked> Infinity
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 700; color: #7c3aed; cursor: pointer;">
                        <input type="checkbox" name="applicable_packages[]" value="all" checked> All Packages
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 5px;">
                    Coupon Description (Optional)
                </label>
                <input type="text" name="description" placeholder="e.g. Welcome promo code for 20% flat discount on any package" style="width: 100%; padding: 0.65rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; box-sizing: border-box;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeCouponModal()" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 700; padding: 0.65rem 1.4rem; border-radius: 8px; border: none; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn" style="background: #7c3aed; color: #ffffff; font-weight: 800; padding: 0.65rem 1.8rem; border-radius: 8px; border: none; cursor: pointer;">
                    🎟️ Save Coupon Code
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openOfferModal() {
    const modal = document.getElementById('offerModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}
function closeOfferModal() {
    const modal = document.getElementById('offerModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function openCouponModal() {
    const modal = document.getElementById('couponModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}
function closeCouponModal() {
    const modal = document.getElementById('couponModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function toggleBundleFields(val) {
    const box = document.getElementById('bundleSettingsBox');
    if (box) {
        box.style.display = (val === 'bundle') ? 'block' : 'none';
    }
}
</script>
@endsection

