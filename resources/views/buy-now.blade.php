@extends('layouts.app')

@section('title', 'Buy Now & Checkout — SkillLearner')

@section('content')
<div class="checkout-page-wrapper">
    <div style="max-width: 1140px; margin: 0 auto; width: 100%;">

        {{-- Top Notification Alerts --}}
        @if(session('success'))
            <div style="background: #f0fdf4; border-left: 4px solid #10b981; color: #166534; padding: 0.9rem 1.1rem; border-radius: 8px; margin-bottom: 1.3rem; font-weight: 600; font-size: 0.92rem;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.9rem 1.1rem; border-radius: 8px; margin-bottom: 1.3rem; font-weight: 600; font-size: 0.92rem;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.9rem 1.1rem; border-radius: 8px; margin-bottom: 1.3rem; font-size: 0.9rem;">
                <ul style="margin: 0; padding-left: 1.2rem; font-weight: 600;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ============================================================== --}}
        {{-- TOP: ALL 5 PACKAGES SIDE-BY-SIDE (SELECT TO HIGHLIGHT)         --}}
        {{-- ============================================================== --}}
        <div class="packages-section-container">
            <div class="packages-header-bar">
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">
                        🌟 Select Package (All 5 Available):
                    </h2>
                    <span style="font-size: 0.82rem; color: #64748b; font-weight: 500;">
                        Click on any package to select it — all packages remain visible side-by-side.
                    </span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                    <span class="mobile-swipe-hint">
                        👈 Swipe to view all 5 👉
                    </span>
                    <span id="topActiveBadge" class="top-active-badge">
                        Selected: {{ $selectedPackage['name'] }} (₹{{ number_format($selectedPackage['price']) }})
                    </span>
                </div>
            </div>

            <!-- Horizontal row of 5 packages (Desktop: 5 columns, Mobile: swipeable + snap) -->
            <div class="packages-horizontal-row" id="packagesScrollRow">
                @foreach($packages as $p)
                    @php 
                        $isSelected = strtolower($selectedPackage['id']) === strtolower($p['id']); 
                    @endphp
                    <div 
                        onclick="selectPackage('{{ $p['id'] }}')" 
                        id="pkgCard_{{ $p['id'] }}" 
                        class="pkg-select-card {{ $isSelected ? 'selected' : '' }}"
                    >
                        <div class="pkg-selected-indicator" style="display: {{ $isSelected ? 'inline-block' : 'none' }};">
                            ✓ SELECTED
                        </div>

                        <div class="pkg-card-title">
                            {{ $p['name'] }}
                        </div>
                        <div class="pkg-card-price">
                            ₹{{ number_format($p['price']) }}
                        </div>
                        <div class="pkg-card-old-price">
                            ₹{{ number_format($p['old_price']) }}
                        </div>
                        <div class="pkg-card-courses-tag">
                            {{ count($p['courses_included'] ?? []) }}+ Courses
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mobile quick selector chips (allows 1-tap switching without scrolling) -->
            <div class="mobile-quick-selector" aria-label="Mobile Package Selector">
                @foreach($packages as $p)
                    @php 
                        $isSelected = strtolower($selectedPackage['id']) === strtolower($p['id']); 
                    @endphp
                    <button 
                        type="button" 
                        onclick="selectPackage('{{ $p['id'] }}')" 
                        id="mobileChip_{{ $p['id'] }}" 
                        class="mobile-pkg-chip {{ $isSelected ? 'active' : '' }}"
                    >
                        {{ $p['name'] }} • ₹{{ number_format($p['price']) }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ============================================================== --}}
        {{-- MAIN CHECKOUT FORM: BILLING DETAILS & PAYMENT METHOD           --}}
        {{-- Exact matching of user's uploaded screenshot design            --}}
        {{-- ============================================================== --}}
        <form method="POST" action="{{ route('process.buynow') }}" id="mainCheckoutForm">
            @csrf
            {{-- Hidden input for selected package --}}
            <input type="hidden" name="package" id="hiddenPackageInput" value="{{ $selectedPackage['id'] }}">

            <div class="checkout-layout-grid">
                
                {{-- -------------------------------------------------------- --}}
                {{-- LEFT CARD: BILLING DETAILS                                --}}
                {{-- -------------------------------------------------------- --}}
                <div class="checkout-white-card">
                    <h2 class="card-main-title">
                        Billing Details
                    </h2>

                    <!-- Have a referral code? -->
                    <div style="margin-bottom: 1.35rem;">
                        <div class="referral-field-row">
                            <input 
                                type="text" 
                                name="referral_code" 
                                id="referralCodeInput" 
                                value="{{ old('referral_code', request('ref', session('user.sponsor_id', 'SKL-ADMIN'))) }}" 
                                placeholder="Have a referral code?" 
                                class="form-input-field"
                                style="flex: 1; min-width: 0;"
                            >
                            <button 
                                type="button" 
                                onclick="verifyReferralCode()" 
                                id="verifyCodeBtn"
                                class="btn-verify-code"
                            >
                                Verify Code
                            </button>
                        </div>
                        <div id="referralStatusFeedback" style="font-size: 0.82rem; margin-top: 6px; color: #10b981; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            <span>✓</span> Verified Sponsor: <strong>SkillLearner Official (SKL-ADMIN)</strong>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div style="margin-bottom: 1.35rem;">
                        <label for="fullNameInput" class="form-field-label">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="fullNameInput" 
                            required 
                            placeholder="Enter your full name" 
                            value="{{ old('name') }}"
                            class="form-input-field"
                        >
                    </div>

                    <!-- Phone Number -->
                    <div style="margin-bottom: 1.35rem;">
                        <label for="phoneInput" class="form-field-label">
                            Phone Number
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phoneInput" 
                            required 
                            placeholder="Enter your phone number" 
                            value="{{ old('phone') }}"
                            class="form-input-field"
                        >
                    </div>

                    <!-- Email Address -->
                    <div style="margin-bottom: 1.35rem;">
                        <label for="emailInput" class="form-field-label">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="emailInput" 
                            required 
                            placeholder="Enter your email address" 
                            value="{{ old('email') }}"
                            class="form-input-field"
                        >
                    </div>

                    <!-- Create Password (with bordered square eye icon on the right as in screenshot) -->
                    <div style="margin-bottom: 0.5rem;">
                        <label for="createPasswordInput" class="form-field-label">
                            Create Password
                        </label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="createPasswordInput" 
                                required 
                                placeholder="Create a strong password" 
                                class="form-input-field password-inner-input"
                            >
                            <button 
                                type="button" 
                                onclick="toggleCreatePassword()" 
                                id="eyeToggleBtn"
                                aria-label="Toggle password visibility"
                                class="eye-toggle-box"
                            >
                                <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                {{-- -------------------------------------------------------- --}}
                {{-- RIGHT CARD: PAYMENT METHOD                                --}}
                {{-- -------------------------------------------------------- --}}
                <div class="checkout-white-card">
                    <h2 class="card-main-title">
                        Payment Method
                    </h2>

                    <!-- Option 1: Payment Link (Rounded Pill Box) -->
                    <label 
                        id="labelPaymentLink" 
                        class="payment-method-box active" 
                        onclick="setPaymentMethod('payment_link')"
                    >
                        <input type="radio" name="payment_method" value="payment_link" checked class="payment-radio-input">
                        <span class="payment-radio-text">Payment Link</span>
                    </label>

                    <!-- Option 2: Referral Wallet (Rounded Pill Box) -->
                    <label 
                        id="labelReferralWallet" 
                        class="payment-method-box" 
                        onclick="setPaymentMethod('referral_wallet')"
                    >
                        <input type="radio" name="payment_method" value="referral_wallet" class="payment-radio-input">
                        <span class="payment-radio-text">Referral Wallet</span>
                    </label>

                    <!-- Terms & Conditions Checkbox -->
                    <div style="margin: 1.5rem 0 1.5rem 0;">
                        <label class="terms-checkbox-label">
                            <input type="checkbox" name="agree_terms" required checked class="terms-checkbox-input">
                            <span class="terms-checkbox-text">
                                I agree to the <a href="{{ url('/about') }}" target="_blank" class="terms-link">terms and conditions</a>
                            </span>
                        </label>
                    </div>

                    <!-- Proceed to Payment Button -->
                    <button 
                        type="submit" 
                        id="proceedPaymentSubmitBtn"
                        class="btn-proceed-payment"
                    >
                        Proceed to Payment (<span id="btnPriceDisplay">₹{{ number_format($selectedPackage['price']) }}</span>)
                    </button>

                    <!-- Important ID Security Notice -->
                    <div class="security-info-box">
                        🔒 <strong>Admin Verification Rule:</strong> Registration ke baad aapki ID Admin ke pass verification ke liye rahegi. Payment confirm hone ke baad hi aap login kar sakenge.
                    </div>

                    <div style="text-align: center; margin-top: 1.1rem;">
                        <a href="{{ url('/login') }}" class="login-redirect-link">
                            Already registered &amp; paid? <span style="color: #2563eb; text-decoration: underline;">Log In Here</span>
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</div>

@push('styles')
<style>
    /* Base Page Styling */
    .checkout-page-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding: 2.5rem 1.2rem 5rem;
        box-sizing: border-box;
    }

    .packages-section-container {
        margin-bottom: 2rem;
    }

    .packages-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 8px;
    }

    .top-active-badge {
        background: #e0e7ff;
        color: #00137a;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 5px 14px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .mobile-swipe-hint {
        display: none;
        font-size: 0.74rem;
        color: #00137a;
        font-weight: 700;
        background: #e0e7ff;
        padding: 4px 10px;
        border-radius: 12px;
    }

    /* Packages Horizontal Row - 5 Side-by-Side */
    .packages-horizontal-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(130px, 1fr));
        gap: 12px;
        width: 100%;
        box-sizing: border-box;
    }

    .pkg-select-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        user-select: none;
        box-sizing: border-box;
    }

    .pkg-select-card:hover {
        transform: translateY(-2px);
        border-color: #93c5fd;
    }

    .pkg-select-card.selected {
        background: #eff6ff !important;
        border: 2px solid #00137a !important;
        box-shadow: 0 4px 14px rgba(0, 19, 122, 0.12) !important;
    }

    .pkg-selected-indicator {
        position: absolute;
        top: -9px;
        left: 50%;
        transform: translateX(-50%);
        background: #00137a;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .pkg-card-title {
        font-size: 0.78rem;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pkg-select-card.selected .pkg-card-title {
        color: #00137a;
    }

    .pkg-card-price {
        font-size: 1.2rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .pkg-card-old-price {
        font-size: 0.72rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .pkg-card-courses-tag {
        font-size: 0.72rem;
        color: #05B396;
        font-weight: 700;
        margin-top: 4px;
    }

    /* Mobile Quick Selector Chips (hidden on desktop) */
    .mobile-quick-selector {
        display: none;
    }

    /* Checkout 2-Card Layout (Matches user's uploaded screenshot) */
    .checkout-layout-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 24px;
        align-items: start;
        width: 100%;
        box-sizing: border-box;
    }

    .checkout-white-card {
        background: #ffffff;
        border: 2px solid #3884ff; /* Light blue accent border from screenshot */
        border-radius: 12px;
        padding: 30px 26px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        box-sizing: border-box;
    }

    .card-main-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.5rem 0;
        letter-spacing: -0.2px;
    }

    .form-field-label {
        display: block;
        font-size: 0.92rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.45rem;
    }

    .form-input-field {
        width: 100%;
        padding: 0.78rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.95rem;
        color: #0f172a;
        outline: none;
        background: #ffffff;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input-field:focus {
        border-color: #3884ff;
        box-shadow: 0 0 0 3px rgba(56, 132, 255, 0.12);
    }

    .form-input-field::placeholder {
        color: #94a3b8;
    }

    .referral-field-row {
        display: flex;
        gap: 8px;
        align-items: stretch;
    }

    .btn-verify-code {
        background: #00137a; /* Dark navy blue from screenshot */
        color: #ffffff;
        font-weight: 700;
        font-size: 0.92rem;
        padding: 0.78rem 1.4rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        white-space: nowrap;
        transition: opacity 0.2s;
        flex-shrink: 0;
    }

    .btn-verify-code:hover {
        opacity: 0.92;
    }

    /* Password field with bordered square eye icon on the right (matches screenshot) */
    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .password-inner-input {
        padding-right: 48px !important;
    }

    .eye-toggle-box {
        position: absolute;
        right: 8px;
        width: 34px;
        height: 32px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        background: #ffffff;
        cursor: pointer;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        outline: none;
        transition: all 0.15s ease;
    }

    .eye-toggle-box:hover {
        border-color: #3884ff;
        color: #00137a;
    }

    /* Payment Method Option Boxes (Matches screenshot) */
    .payment-method-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 8px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        box-sizing: border-box;
    }

    .payment-method-box.active {
        border-color: #00137a;
        background: #f8fafc;
    }

    .payment-radio-input {
        accent-color: #00137a;
        width: 17px;
        height: 17px;
        cursor: pointer;
        margin: 0;
    }

    .payment-radio-text {
        font-size: 0.96rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Terms and Conditions Checkbox */
    .terms-checkbox-label {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 0.9rem;
        color: #64748b;
        cursor: pointer;
        user-select: none;
    }

    .terms-checkbox-input {
        accent-color: #00137a;
        width: 16px;
        height: 16px;
        border-radius: 4px;
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
    }

    .terms-checkbox-text {
        line-height: 1.4;
    }

    .terms-link {
        color: #5b5bd6; /* Purple-blue link color from screenshot */
        text-decoration: underline;
        font-weight: 500;
    }

    /* Proceed to Payment Button */
    .btn-proceed-payment {
        width: 100%;
        min-height: 48px;
        padding: 0.85rem 1rem;
        background: #00137a; /* Exact dark navy blue from screenshot */
        color: #ffffff;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 4px 14px rgba(0, 19, 122, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-proceed-payment:hover {
        background: #001066;
    }

    .security-info-box {
        margin-top: 1.25rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 0.85rem 1rem;
        font-size: 0.8rem;
        color: #1e40af;
        line-height: 1.5;
    }

    .login-redirect-link {
        color: #64748b;
        font-size: 0.86rem;
        text-decoration: none;
        font-weight: 600;
    }

    .login-redirect-link:hover {
        color: #0f172a;
    }

    /* ============================================================== */
    /* RESPONSIVE DESIGN: TABLETS & MOBILE PHONES                     */
    /* ============================================================== */
    @media (max-width: 900px) {
        .checkout-page-wrapper {
            padding: 1.5rem 0.85rem 4rem !important;
        }

        .checkout-layout-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }

        /* Packages: Smooth Horizontal Swipe on Tablets/Mobile */
        .packages-horizontal-row {
            display: flex !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            scroll-snap-type: x mandatory !important;
            gap: 10px !important;
            padding-bottom: 12px !important;
            margin-bottom: 0.6rem !important;
            scrollbar-width: thin;
        }

        .packages-horizontal-row::-webkit-scrollbar {
            height: 6px;
        }

        .packages-horizontal-row::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 10px;
        }

        .pkg-select-card {
            flex: 0 0 142px !important;
            min-width: 142px !important;
            scroll-snap-align: center !important;
            box-sizing: border-box !important;
        }

        .mobile-swipe-hint {
            display: inline-block !important;
        }

        /* Mobile quick chip row */
        .mobile-quick-selector {
            display: flex !important;
            overflow-x: auto !important;
            gap: 6px !important;
            padding-bottom: 6px !important;
            margin-top: 4px !important;
            scrollbar-width: none;
        }

        .mobile-quick-selector::-webkit-scrollbar {
            display: none;
        }

        .mobile-pkg-chip {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 16px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .mobile-pkg-chip.active {
            background: #00137a;
            color: #ffffff;
            border-color: #00137a;
        }
    }

    @media (max-width: 600px) {
        .checkout-page-wrapper {
            padding: 1rem 0.65rem 3.5rem !important;
        }

        .checkout-white-card {
            padding: 22px 16px !important;
            border-radius: 10px !important;
        }

        .card-main-title {
            font-size: 1.25rem !important;
            margin-bottom: 1.2rem !important;
        }

        /* Prevent iOS Safari from auto-zooming by forcing 16px minimum font size */
        .form-input-field,
        #referralCodeInput,
        #createPasswordInput {
            font-size: 16px !important;
            padding: 0.72rem 0.85rem !important;
        }

        .password-inner-input {
            padding-right: 44px !important;
        }

        .btn-verify-code {
            padding: 0.72rem 1.05rem !important;
            font-size: 0.86rem !important;
        }

        .pkg-select-card {
            flex: 0 0 136px !important;
            min-width: 136px !important;
            padding: 12px 8px !important;
        }

        .top-active-badge {
            font-size: 0.72rem !important;
            padding: 4px 10px !important;
        }

        .btn-proceed-payment {
            min-height: 50px !important;
            font-size: 1rem !important;
        }
    }

    @media (max-width: 380px) {
        .btn-verify-code {
            padding: 0.72rem 0.85rem !important;
            font-size: 0.82rem !important;
        }

        .checkout-white-card {
            padding: 18px 12px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const allPackagesData = {
        'basic': { id: 'basic', name: 'Basic Package', price: 599, oldPrice: 1199 },
        'growth': { id: 'growth', name: 'Growth Package', price: 1199, oldPrice: 2499 },
        'advance': { id: 'advance', name: 'Advance Package', price: 2499, oldPrice: 4999 },
        'premium': { id: 'premium', name: 'Premium Package', price: 4999, oldPrice: 9999 },
        'infinity': { id: 'infinity', name: 'Infinity Package', price: 7999, oldPrice: 15999 }
    };

    function selectPackage(pkgId) {
        pkgId = (pkgId || '').toLowerCase();
        if (!allPackagesData[pkgId]) return;
        const p = allPackagesData[pkgId];

        // 1. Update hidden form input
        document.getElementById('hiddenPackageInput').value = pkgId;

        // 2. Update badge & button price text
        const topBadge = document.getElementById('topActiveBadge');
        if (topBadge) {
            topBadge.innerText = 'Selected: ' + p.name + ' (₹' + p.price.toLocaleString() + ')';
        }

        const btnPrice = document.getElementById('btnPriceDisplay');
        if (btnPrice) {
            btnPrice.innerText = '₹' + p.price.toLocaleString();
        }

        // 3. Highlight selected card & unhighlight others (All 5 remain visible side-by-side)
        Object.keys(allPackagesData).forEach(key => {
            const card = document.getElementById('pkgCard_' + key);
            const chip = document.getElementById('mobileChip_' + key);
            
            if (card) {
                const indicator = card.querySelector('.pkg-selected-indicator');
                if (key === pkgId) {
                    card.classList.add('selected');
                    if (indicator) indicator.style.display = 'inline-block';
                    // Auto-scroll card into view smoothly on mobile if out of viewport
                    card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    card.classList.remove('selected');
                    if (indicator) indicator.style.display = 'none';
                }
            }

            if (chip) {
                if (key === pkgId) {
                    chip.classList.add('active');
                } else {
                    chip.classList.remove('active');
                }
            }
        });
    }

    function setPaymentMethod(method) {
        const linkLabel = document.getElementById('labelPaymentLink');
        const walletLabel = document.getElementById('labelReferralWallet');

        if (method === 'payment_link') {
            if (linkLabel) linkLabel.classList.add('active');
            if (walletLabel) walletLabel.classList.remove('active');
            const radio = linkLabel ? linkLabel.querySelector('input[type="radio"]') : null;
            if (radio) radio.checked = true;
        } else {
            if (walletLabel) walletLabel.classList.add('active');
            if (linkLabel) linkLabel.classList.remove('active');
            const radio = walletLabel ? walletLabel.querySelector('input[type="radio"]') : null;
            if (radio) radio.checked = true;
        }
    }

    function toggleCreatePassword() {
        const pwdInput = document.getElementById('createPasswordInput');
        if (!pwdInput) return;
        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
        } else {
            pwdInput.type = 'password';
        }
    }

    async function verifyReferralCode() {
        const refInput = document.getElementById('referralCodeInput');
        const feedback = document.getElementById('referralStatusFeedback');
        const code = (refInput ? refInput.value : '').trim();

        feedback.innerHTML = '<span style="color:#64748b;">⏳ Verifying referral code...</span>';

        try {
            const res = await fetch('/verify-referral/' + encodeURIComponent(code || 'SKL-ADMIN'));
            const data = await res.json();
            if (data.valid) {
                feedback.innerHTML = `<span style="color:#10b981;">✓ Verified Sponsor: <strong>${data.sponsor_name} (${data.sponsor_id})</strong></span>`;
            } else {
                feedback.innerHTML = `<span style="color:#ef4444;">❌ ${data.message || 'Invalid Referral Code'}. Defaulted to SKL-ADMIN.</span>`;
            }
        } catch (e) {
            feedback.innerHTML = `<span style="color:#10b981;">✓ Verified Sponsor: <strong>SkillLearner Official (SKL-ADMIN)</strong></span>`;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const pkgParam = urlParams.get('package');
        if (pkgParam && allPackagesData[pkgParam.toLowerCase()]) {
            selectPackage(pkgParam.toLowerCase());
        }

        const refParam = urlParams.get('ref');
        if (refParam) {
            verifyReferralCode();
        }
    });
</script>
@endpush
@endsection
