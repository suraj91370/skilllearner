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
        {{-- TOP: SELECT YOUR PACKAGE (MATCHES USER REFERENCE IMAGE 1)      --}}
        {{-- Simple, Clean, Package Images + Names Only, #05B396 Theme       --}}
        {{-- ============================================================== --}}
        <div class="packages-section-container">
            <h2 class="packages-header-title">
                Select Your Package
            </h2>

            @if(!empty($currentPackage))
                <div style="background: #ecfdf5; border: 1.5px solid #10b981; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 1.25rem;">💎</span>
                        <span style="font-size: 0.92rem; font-weight: 700; color: #065f46;">
                            Active Plan: <strong>{{ $currentPackage['name'] }} (₹{{ number_format($currentPackage['price']) }})</strong>.
                            Current package value is automatically deducted when upgrading to higher tiers!
                        </span>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 800; color: #059669; background: #d1fae5; padding: 3px 10px; border-radius: 12px;">
                        Upgrade Discount Active
                    </span>
                </div>
            @endif

            <!-- 5 Package Cards Side-by-Side (Desktop: 5 cols, Mobile: smooth horizontal swipe) -->
            <div class="packages-horizontal-row" id="packagesScrollRow">
                @foreach($packages as $p)
                    @php 
                        $isSelected = strtolower($selectedPackage['id']) === strtolower($p['id']); 
                        $upg = $p['upgrade'] ?? null;
                    @endphp
                    <div 
                        onclick="selectPackage('{{ $p['id'] }}')" 
                        id="pkgCard_{{ $p['id'] }}" 
                        class="pkg-select-card {{ $isSelected ? 'selected' : '' }}"
                    >
                        @if(!empty($upg['is_upgrade']))
                            <div style="background: #10b981; color: #fff; font-size: 0.68rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; margin-bottom: 4px;">
                                Upgrade: ₹{{ number_format($upg['payable_price']) }}
                            </div>
                        @elseif(!empty($upg['is_current']))
                            <div style="background: #0284c7; color: #fff; font-size: 0.68rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; margin-bottom: 4px;">
                                Current Plan
                            </div>
                        @elseif(!empty($upg['is_lower']))
                            <div style="background: #64748b; color: #fff; font-size: 0.68rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; margin-bottom: 4px;">
                                Owned
                            </div>
                        @endif
                        <div class="pkg-img-box">
                            <img src="{{ asset('images/packages/' . $p['id'] . '.png') }}" alt="{{ $p['name'] }}">
                        </div>
                        <div class="pkg-simple-title">
                            {{ $p['name'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============================================================== --}}
        {{-- MAIN CHECKOUT FORM: BILLING DETAILS & PAYMENT METHOD           --}}
        {{-- Border Color: Project Color #05B396                            --}}
        {{-- Image 2 (Referral row) REMOVED as requested                    --}}
        {{-- ============================================================== --}}
        <form method="POST" action="{{ route('payment.cashfree.initiate') }}" id="mainCheckoutForm">
            @csrf
            {{-- Hidden input for selected package --}}
            <input type="hidden" name="package" id="hiddenPackageInput" value="{{ $selectedPackage['id'] }}">

            {{-- Hidden input for referral code so affiliate tracking works without UI clutter --}}
            <input type="hidden" name="referral_code" id="referralCodeInput" value="{{ old('referral_code', request('ref', session('user.sponsor_id', 'SKL-ADMIN'))) }}">

            <div class="checkout-layout-grid">
                
                {{-- -------------------------------------------------------- --}}
                {{-- LEFT CARD: BILLING DETAILS (Border: #05B396)              --}}
                {{-- -------------------------------------------------------- --}}
                <div class="checkout-card-box">
                    <h2 class="card-main-title">
                        Billing Details
                    </h2>

                    @php
                        $userLoggedIn = Auth::check() || session()->has('user.id');
                        $prefillName = old('name', Auth::user()->name ?? session('user.name', ''));
                        $prefillPhone = old('phone', Auth::user()->phone ?? session('user.phone', ''));
                        $prefillEmail = old('email', Auth::user()->email ?? session('user.email', ''));
                    @endphp

                    @if($userLoggedIn)
                        <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 10px 12px; margin-bottom: 1.2rem; font-size: 0.88rem; color: #166534; display: flex; align-items: center; gap: 8px;">
                            <span>✓</span>
                            <span>Aap apne logged-in account (<strong>{{ $prefillName }}</strong>) se upgrade kar rahe hain. Naya package aapki isi ID par activate hoga.</span>
                        </div>
                    @endif

                    <!-- Full Name -->
                    <div class="form-group-item">
                        <label for="fullNameInput" class="form-field-label">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="fullNameInput" 
                            required 
                            placeholder="Enter your full name" 
                            value="{{ $prefillName }}"
                            class="form-input-field"
                        >
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group-item">
                        <label for="phoneInput" class="form-field-label">
                            Phone Number
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phoneInput" 
                            required 
                            placeholder="Enter your phone number" 
                            value="{{ $prefillPhone }}"
                            class="form-input-field"
                        >
                    </div>

                    <!-- Email Address -->
                    <div class="form-group-item">
                        <label for="emailInput" class="form-field-label">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="emailInput" 
                            required 
                            placeholder="Enter your email address" 
                            value="{{ $prefillEmail }}"
                            class="form-input-field"
                        >
                    </div>

                    @if($userLoggedIn)
                        <input type="hidden" name="password" value="ALREADY_LOGGED_IN">
                    @else
                        <!-- Create Password (with bordered square eye icon on the right as in screenshot) -->
                        <div class="form-group-item" style="margin-bottom: 0.5rem;">
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
                    @endif

                </div>

                {{-- -------------------------------------------------------- --}}
                {{-- RIGHT CARD: PAYMENT METHOD (Border: #05B396)              --}}
                {{-- -------------------------------------------------------- --}}
                <div class="checkout-card-box">
                    <h2 class="card-main-title">
                        Payment Method
                    </h2>

                    <!-- Payment Methods Selection (Cashfree Instant vs Manual Transfer) -->
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 1.2rem;">
                        <!-- Method 1: Cashfree Online Payment (Instant) -->
                        <label 
                            id="labelCashfree" 
                            class="payment-method-box active" 
                            onclick="setPaymentMethod('cashfree')"
                            style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border: 2px solid #05B396; border-radius: 12px; background: #f0fdf9; cursor: pointer; transition: all 0.2s ease;"
                        >
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="cashfree" checked class="payment-radio-input" style="accent-color: #05B396; width: 17px; height: 17px;">
                                <div style="text-align: left;">
                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;">
                                        <span>Instant Online Payment</span>
                                        <span style="background: #05B396; color: #ffffff; font-size: 0.68rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">Instant</span>
                                    </div>
                                    <div style="font-size: 0.78rem; color: #047857; font-weight: 600; margin-top: 2px;">
                                        ⚡ Automatic Activation &bull; UPI (GPay, PhonePe, Paytm), Cards, NetBanking
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Method 2: Manual UPI / QR Transfer -->
                        <label 
                            id="labelManual" 
                            class="payment-method-box" 
                            onclick="setPaymentMethod('manual')"
                            style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border: 1.5px solid #cbd5e1; border-radius: 12px; background: #ffffff; cursor: pointer; transition: all 0.2s ease;"
                        >
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="radio" name="payment_method" value="manual" class="payment-radio-input" style="accent-color: #05B396; width: 17px; height: 17px;">
                                <div style="text-align: left;">
                                    <div style="font-weight: 700; color: #334155; font-size: 0.92rem;">Manual UPI / QR Transfer</div>
                                    <div style="font-size: 0.78rem; color: #64748b; margin-top: 2px;">Pay via QR Code &amp; Submit UTR (Requires Admin Verification)</div>
                                </div>
                            </div>
                        </label>
                    </div>

                    @php
                        $initUpg = $selectedPackage['upgrade'] ?? null;
                        $initIsUpgrade = !empty($initUpg['is_upgrade']);
                        $initIsCurrent = !empty($initUpg['is_current']);
                        $initIsLower = !empty($initUpg['is_lower']);
                        $initPayable = $initIsUpgrade ? $initUpg['payable_price'] : $selectedPackage['price'];
                        $initDiscount = $initIsUpgrade ? $initUpg['discount'] : 0;
                    @endphp

                    <!-- Upgrade Calculation Breakdown Box -->
                    <div id="upgradeCalculationBox" style="{{ $initIsUpgrade ? 'display: block;' : 'display: none;' }} background: #f0fdf4; border: 1.5px dashed #05B396; border-radius: 10px; padding: 14px 16px; margin: 1.2rem 0;">
                        <div style="font-weight: 800; font-size: 0.95rem; color: #065f46; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <span>🎉</span> <span>Upgrade Breakdown Applied</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.88rem; color: #475569; margin-bottom: 5px;">
                            <span id="targetPkgNameDisplay">{{ $selectedPackage['name'] }} Price:</span>
                            <span id="targetPkgPriceDisplay" style="font-weight: 700;">₹{{ number_format($selectedPackage['price']) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.88rem; color: #059669; font-weight: 700; margin-bottom: 8px;">
                            <span id="deductedPkgLabel">{{ $currentPackage['name'] ?? 'Current Plan' }} Deducted:</span>
                            <span id="deductedPkgAmount">- ₹{{ number_format($initDiscount) }}</span>
                        </div>
                        <div style="border-top: 1px solid #cbd5e1; padding-top: 8px; display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 900; color: #0f172a;">
                            <span>You Pay:</span>
                            <span id="netPayableAmount" style="color: #05B396;">₹{{ number_format($initPayable) }}</span>
                        </div>
                    </div>

                    <!-- Already Owned / Lower Warning Box -->
                    <div id="alreadyOwnedWarning" style="{{ ($initIsCurrent || $initIsLower) ? 'display: block;' : 'display: none;' }} background: #eff6ff; border: 1.5px solid #3b82f6; border-radius: 10px; padding: 12px 14px; margin: 1.2rem 0; color: #1e40af; font-size: 0.9rem; font-weight: 700; text-align: center;">
                        @if($initIsCurrent)
                            ✓ Aap pehle se {{ $selectedPackage['name'] }} par hain.
                        @elseif($initIsLower)
                            ✓ Aapka vartaman plan is se uncha hai ({{ $currentPackage['name'] ?? '' }}).
                        @endif
                    </div>

                    <!-- Coupon Code Input Box -->
                    <div style="background: #ffffff; border: 1.5px dashed #05B396; border-radius: 10px; padding: 12px 14px; margin: 1.2rem 0;">
                        <label for="couponCodeInput" style="display: block; font-size: 0.86rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">
                            🎟️ Have a Coupon Code?
                        </label>
                        <div style="display: flex; gap: 8px;">
                            <input 
                                type="text" 
                                id="couponCodeInput" 
                                placeholder="Enter coupon code" 
                                style="flex: 1; text-transform: uppercase; font-family: monospace; font-weight: 800; padding: 0.6rem 0.85rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; outline: none;"
                            >
                            <button 
                                type="button" 
                                onclick="applyCouponCode()" 
                                id="applyCouponBtn" 
                                style="background: #05B396; color: #ffffff; border: none; border-radius: 8px; padding: 0.6rem 1.1rem; font-size: 0.88rem; font-weight: 800; cursor: pointer; transition: all 0.2s ease; white-space: nowrap;"
                            >
                                Apply
                            </button>
                            <button 
                                type="button" 
                                onclick="removeCouponCode()" 
                                id="removeCouponBtn" 
                                style="display: none; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 8px; padding: 0.6rem 0.9rem; font-size: 0.84rem; font-weight: 700; cursor: pointer; white-space: nowrap;"
                            >
                                ✕ Remove
                            </button>
                        </div>
                        <div id="couponFeedbackMessage" style="display: none; margin-top: 8px; font-size: 0.82rem; font-weight: 700;"></div>
                    </div>
                    <input type="hidden" name="coupon_code" id="hiddenCouponCodeInput" value="">
                    <input type="hidden" name="coupon_discount" id="hiddenCouponDiscountInput" value="0">

                    <!-- Terms & Conditions Checkbox (Not checked by default) -->
                    <div style="margin: 1.2rem 0 1.2rem 0;">
                        <label class="terms-checkbox-label">
                            <input type="checkbox" name="agree_terms" required class="terms-checkbox-input">
                            <span class="terms-checkbox-text">
                                I agree to the <a href="{{ url('/about') }}" target="_blank" class="terms-link">terms and conditions</a>
                            </span>
                        </label>
                    </div>

                    <!-- Proceed to Payment Button with dynamic price -->
                    <button 
                        type="submit" 
                        id="proceedPaymentSubmitBtn"
                        class="btn-proceed-payment"
                        @if($initIsCurrent || $initIsLower) disabled style="opacity: 0.6; cursor: not-allowed;" @endif
                    >
                        @if($initIsUpgrade)
                            Upgrade to {{ $selectedPackage['name'] }} (<span id="btnPriceDisplay">₹{{ number_format($initPayable) }}</span>)
                        @elseif($initIsCurrent)
                            Current Active Plan (Already Owned)
                        @elseif($initIsLower)
                            Included in Your Current Plan
                        @else
                            Proceed to Payment (<span id="btnPriceDisplay">₹{{ number_format($selectedPackage['price']) }}</span>)
                        @endif
                    </button>

                    <div style="text-align: center; margin-top: 1.25rem;">
                        <a href="{{ url('/login') }}" class="login-redirect-link">
                            Already registered? <span style="color: #05B396; text-decoration: underline;">Log In Here</span>
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

    /* ============================================================== */
    /* TOP CONTAINER: "Select Your Package" matching Image 1          */
    /* Border: Project color #05B396, rounded, white background       */
    /* ============================================================== */
    .packages-section-container {
        background: #ffffff;
        border: 2px solid #05B396; /* Project Brand Color */
        border-radius: 12px;
        padding: 22px 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        box-sizing: border-box;
        width: 100%;
    }

    .packages-header-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.2rem 0;
        letter-spacing: -0.2px;
    }

    /* 5 Package Cards Row - Desktop 5 columns, Mobile swipeable */
    .packages-horizontal-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .pkg-select-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 10px 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.22s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        box-sizing: border-box;
        user-select: none;
    }

    .pkg-select-card:hover {
        transform: translateY(-2px);
        border-color: #05B396;
    }

    /* Selected state: highlighted with project brand color border */
    .pkg-select-card.selected {
        border: 2px solid #05B396 !important;
        background: #f0fdfa !important; /* Subtle soft emerald tint */
        box-shadow: 0 4px 14px rgba(5, 179, 150, 0.18) !important;
    }

    .pkg-img-box {
        width: 100%;
        height: 155px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
    }

    .pkg-img-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.12));
        transition: transform 0.2s ease;
    }

    .pkg-select-card:hover .pkg-img-box img {
        transform: scale(1.04);
    }

    .pkg-simple-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e293b;
        text-align: center;
        line-height: 1.3;
        margin-top: 2px;
    }

    .pkg-select-card.selected .pkg-simple-title {
        color: #05B396;
    }

    /* ============================================================== */
    /* CHECKOUT 2-CARD GRID (Billing Details & Payment Method)        */
    /* Border: Project color #05B396                                  */
    /* ============================================================== */
    .checkout-layout-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 24px;
        align-items: start;
        width: 100%;
        box-sizing: border-box;
    }

    .checkout-card-box {
        background: #ffffff;
        border: 2px solid #05B396; /* Project Brand Color */
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

    .form-group-item {
        margin-bottom: 1.35rem;
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
        border-color: #05B396;
        box-shadow: 0 0 0 3px rgba(5, 179, 150, 0.15);
    }

    .form-input-field::placeholder {
        color: #94a3b8;
    }

    /* Password field with bordered square eye icon on the right */
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
        border-color: #05B396;
        color: #05B396;
    }

    /* Payment Method Option Boxes */
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
        border-color: #05B396;
        background: #f0fdfa;
    }

    .payment-radio-input {
        accent-color: #05B396;
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
        accent-color: #05B396;
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
        color: #05B396; /* Project Brand Color */
        text-decoration: underline;
        font-weight: 600;
    }

    /* Proceed to Payment Button */
    .btn-proceed-payment {
        width: 100%;
        min-height: 50px;
        padding: 0.85rem 1rem;
        background: #00137a; /* Dark navy blue from reference design */
        color: #ffffff;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(0, 19, 122, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-proceed-payment:hover {
        background: #000f60;
        transform: translateY(-1px);
    }

    .security-info-box {
        margin-top: 1.25rem;
        background: #f0fdfa;
        border: 1px solid rgba(5, 179, 150, 0.35);
        border-radius: 8px;
        padding: 0.85rem 1rem;
        font-size: 0.8rem;
        color: #0f766e;
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
    /* Simple, clean, no clutter, smooth touch swipe                  */
    /* ============================================================== */
    @media (max-width: 900px) {
        .checkout-page-wrapper {
            padding: 1.5rem 0.85rem 4rem !important;
        }

        .checkout-layout-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }

        /* Packages: Clean Horizontal Swipe on Mobile (simple, just images + titles) */
        .packages-horizontal-row {
            display: flex !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            scroll-snap-type: x mandatory !important;
            gap: 12px !important;
            padding-bottom: 12px !important;
            scrollbar-width: thin;
        }

        .packages-horizontal-row::-webkit-scrollbar {
            height: 6px;
        }

        .packages-horizontal-row::-webkit-scrollbar-thumb {
            background: #99f6e4;
            border-radius: 10px;
        }

        .pkg-select-card {
            flex: 0 0 135px !important;
            min-width: 135px !important;
            scroll-snap-align: start !important;
            padding: 10px 8px 12px !important;
        }

        .pkg-img-box {
            height: 125px !important;
        }

        .pkg-simple-title {
            font-size: 0.84rem !important;
        }
    }

    @media (max-width: 600px) {
        .checkout-page-wrapper {
            padding: 1rem 0.65rem 3.5rem !important;
        }

        .packages-section-container {
            padding: 16px 14px 18px !important;
            border-radius: 10px !important;
            margin-bottom: 18px !important;
        }

        .packages-header-title {
            font-size: 1.15rem !important;
            margin-bottom: 1rem !important;
        }

        .checkout-card-box {
            padding: 22px 16px !important;
            border-radius: 10px !important;
        }

        .card-main-title {
            font-size: 1.25rem !important;
            margin-bottom: 1.2rem !important;
        }

        /* Prevent iOS Safari from auto-zooming by forcing 16px minimum font size */
        .form-input-field,
        #createPasswordInput {
            font-size: 16px !important;
            padding: 0.72rem 0.85rem !important;
        }

        .password-inner-input {
            padding-right: 44px !important;
        }

        .pkg-select-card {
            flex: 0 0 128px !important;
            min-width: 128px !important;
        }

        .pkg-img-box {
            height: 115px !important;
        }

        .btn-proceed-payment {
            min-height: 50px !important;
            font-size: 1rem !important;
        }
    }

    @media (max-width: 380px) {
        .checkout-card-box {
            padding: 18px 12px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const currentPackage = @json($currentPackage);
    const allPackagesData = {
        @foreach($packages as $p)
        '{{ $p['id'] }}': {
            id: '{{ $p['id'] }}',
            name: '{{ $p['name'] }}',
            price: {{ (int) $p['price'] }},
            is_upgrade: {{ (!empty($p['upgrade']['is_upgrade'])) ? 'true' : 'false' }},
            is_current: {{ (!empty($p['upgrade']['is_current'])) ? 'true' : 'false' }},
            is_lower: {{ (!empty($p['upgrade']['is_lower'])) ? 'true' : 'false' }},
            discount: {{ (int) ($p['upgrade']['discount'] ?? 0) }},
            payable_price: {{ (int) ($p['upgrade']['payable_price'] ?? $p['price']) }}
        },
        @endforeach
    };

    function selectPackage(pkgId) {
        pkgId = (pkgId || '').toLowerCase();
        if (!allPackagesData[pkgId]) return;
        const p = allPackagesData[pkgId];

        // 1. Update hidden form input
        const hiddenInput = document.getElementById('hiddenPackageInput');
        if (hiddenInput) hiddenInput.value = pkgId;

        // 2. Update button price and status
        const btnPrice = document.getElementById('btnPriceDisplay');
        const submitBtn = document.getElementById('proceedPaymentSubmitBtn');
        const upgBox = document.getElementById('upgradeCalculationBox');
        const ownedBox = document.getElementById('alreadyOwnedWarning');

        if (p.is_upgrade) {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
                submitBtn.innerHTML = `Upgrade to ${p.name} (<span id="btnPriceDisplay">₹${p.payable_price.toLocaleString()}</span>)`;
            }
            if (upgBox) {
                upgBox.style.display = 'block';
                document.getElementById('targetPkgNameDisplay').innerText = p.name + ' Price:';
                document.getElementById('targetPkgPriceDisplay').innerText = '₹' + p.price.toLocaleString();
                document.getElementById('deductedPkgLabel').innerText = (currentPackage ? currentPackage.name : 'Current Plan') + ' Deducted:';
                document.getElementById('deductedPkgAmount').innerText = '- ₹' + p.discount.toLocaleString();
                document.getElementById('netPayableAmount').innerText = '₹' + p.payable_price.toLocaleString();
            }
            if (ownedBox) ownedBox.style.display = 'none';
        } else if (p.is_current) {
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.innerHTML = `Current Active Plan (Already Owned)`;
            }
            if (upgBox) upgBox.style.display = 'none';
            if (ownedBox) {
                ownedBox.style.display = 'block';
                ownedBox.innerText = `✓ Aap pehle se ${p.name} par hain.`;
            }
        } else if (p.is_lower) {
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.innerHTML = `Included in Your Current Plan`;
            }
            if (upgBox) upgBox.style.display = 'none';
            if (ownedBox) {
                ownedBox.style.display = 'block';
                ownedBox.innerText = `✓ Aapka vartaman plan is se uncha hai (${currentPackage ? currentPackage.name : ''}).`;
            }
        } else {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
                submitBtn.innerHTML = `Proceed to Payment (<span id="btnPriceDisplay">₹${p.price.toLocaleString()}</span>)`;
            }
            if (upgBox) upgBox.style.display = 'none';
            if (ownedBox) ownedBox.style.display = 'none';
        }

        // 3. Highlight selected card & unhighlight others
        Object.keys(allPackagesData).forEach(key => {
            const card = document.getElementById('pkgCard_' + key);
            if (card) {
                if (key === pkgId) {
                    card.classList.add('selected');
                    // Smoothly scroll card into view on mobile
                    card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    card.classList.remove('selected');
                }
            }
        });
    }

    function setPaymentMethod(method) {
        const form = document.getElementById('mainCheckoutForm');
        const labelCashfree = document.getElementById('labelCashfree');
        const labelManual = document.getElementById('labelManual');

        if (method === 'cashfree') {
            if (form) form.action = "{{ route('payment.cashfree.initiate') }}";
            if (labelCashfree) {
                labelCashfree.classList.add('active');
                labelCashfree.style.borderColor = '#05B396';
                labelCashfree.style.background = '#f0fdf9';
                const radio = labelCashfree.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }
            if (labelManual) {
                labelManual.classList.remove('active');
                labelManual.style.borderColor = '#cbd5e1';
                labelManual.style.background = '#ffffff';
                const radio = labelManual.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            }
        } else {
            if (form) form.action = "{{ route('process.buynow') }}";
            if (labelManual) {
                labelManual.classList.add('active');
                labelManual.style.borderColor = '#05B396';
                labelManual.style.background = '#f0fdf9';
                const radio = labelManual.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }
            if (labelCashfree) {
                labelCashfree.classList.remove('active');
                labelCashfree.style.borderColor = '#cbd5e1';
                labelCashfree.style.background = '#ffffff';
                const radio = labelCashfree.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            }
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

    let activeCouponDiscount = 0;

    async function applyCouponCode() {
        const codeInput = document.getElementById('couponCodeInput');
        const code = (codeInput ? codeInput.value : '').trim().toUpperCase();
        const msgBox = document.getElementById('couponFeedbackMessage');
        const hiddenPkg = document.getElementById('hiddenPackageInput');
        const pkgId = hiddenPkg ? hiddenPkg.value : 'advance';
        const emailInput = document.getElementById('emailInput');
        const email = emailInput ? emailInput.value : '';

        if (!code) {
            if (msgBox) {
                msgBox.style.display = 'block';
                msgBox.style.color = '#dc2626';
                msgBox.innerText = '⚠️ Please enter a coupon code.';
            }
            return;
        }

        const applyBtn = document.getElementById('applyCouponBtn');
        if (applyBtn) {
            applyBtn.innerText = 'Checking...';
            applyBtn.disabled = true;
        }

        try {
            const resp = await fetch('{{ route("api.apply-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    code: code,
                    package: pkgId,
                    email: email
                })
            });

            const data = await resp.json();

            if (data.success && data.data) {
                activeCouponDiscount = data.data.discount_amount || 0;
                document.getElementById('hiddenCouponCodeInput').value = data.data.code;
                document.getElementById('hiddenCouponDiscountInput').value = activeCouponDiscount;

                if (msgBox) {
                    msgBox.style.display = 'block';
                    msgBox.style.color = '#16a34a';
                    msgBox.innerText = '✓ ' + data.message;
                }

                if (codeInput) codeInput.readOnly = true;
                if (applyBtn) applyBtn.style.display = 'none';
                const removeBtn = document.getElementById('removeCouponBtn');
                if (removeBtn) removeBtn.style.display = 'inline-block';

                // Recalculate and update price display
                const p = allPackagesData[pkgId];
                if (p) {
                    const base = p.is_upgrade ? p.payable_price : p.price;
                    const finalPayable = Math.max(0, base - activeCouponDiscount);
                    const netSpan = document.getElementById('netPayableAmount');
                    if (netSpan) netSpan.innerText = '₹' + finalPayable.toLocaleString();
                    const btnPrice = document.getElementById('btnPriceDisplay');
                    if (btnPrice) btnPrice.innerText = '₹' + finalPayable.toLocaleString();
                }
            } else {
                if (msgBox) {
                    msgBox.style.display = 'block';
                    msgBox.style.color = '#dc2626';
                    msgBox.innerText = '⚠️ ' + (data.message || 'Invalid coupon code.');
                }
            }
        } catch (err) {
            if (msgBox) {
                msgBox.style.display = 'block';
                msgBox.style.color = '#dc2626';
                msgBox.innerText = '⚠️ Could not verify coupon. Please try again.';
            }
        } finally {
            if (applyBtn && applyBtn.style.display !== 'none') {
                applyBtn.innerText = 'Apply';
                applyBtn.disabled = false;
            }
        }
    }

    function removeCouponCode() {
        activeCouponDiscount = 0;
        const codeInput = document.getElementById('couponCodeInput');
        if (codeInput) {
            codeInput.value = '';
            codeInput.readOnly = false;
        }
        document.getElementById('hiddenCouponCodeInput').value = '';
        document.getElementById('hiddenCouponDiscountInput').value = '0';

        const applyBtn = document.getElementById('applyCouponBtn');
        if (applyBtn) {
            applyBtn.style.display = 'inline-block';
            applyBtn.innerText = 'Apply';
            applyBtn.disabled = false;
        }
        const removeBtn = document.getElementById('removeCouponBtn');
        if (removeBtn) removeBtn.style.display = 'none';

        const msgBox = document.getElementById('couponFeedbackMessage');
        if (msgBox) msgBox.style.display = 'none';

        // Reset to original package price
        const hiddenPkg = document.getElementById('hiddenPackageInput');
        const pkgId = hiddenPkg ? hiddenPkg.value : 'advance';
        if (allPackagesData[pkgId]) {
            selectPackage(pkgId);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const pkgParam = urlParams.get('package');
        if (pkgParam && allPackagesData[pkgParam.toLowerCase()]) {
            selectPackage(pkgParam.toLowerCase());
        }
    });
</script>
@endpush
@endsection
