@extends('layouts.app')

@section('title', 'Buy Now & Checkout — SkillLearner')

@section('content')
<div style="background: #f8fafc; min-height: 100vh; padding: 2.5rem 1rem 5rem;">
    <div style="max-width: 1140px; margin: 0 auto;">

        {{-- Top Notification Alerts --}}
        @if(session('success'))
            <div style="background: #f0fdf4; border-left: 4px solid #10b981; color: #166534; padding: 1rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.95rem;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.95rem;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem;">
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
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.9rem; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">
                        🌟 Select Package (All 5 Available):
                    </h2>
                    <span style="font-size: 0.84rem; color: #64748b; font-weight: 500;">
                        Click on any package to select it — all packages remain visible side-by-side.
                    </span>
                </div>
                <span id="topActiveBadge" style="background: #e0e7ff; color: #00137a; font-size: 0.76rem; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                    Currently Selected: {{ $selectedPackage['name'] }}
                </span>
            </div>

            <div class="packages-horizontal-row" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;">
                @foreach($packages as $p)
                    @php 
                        $isSelected = strtolower($selectedPackage['id']) === strtolower($p['id']); 
                    @endphp
                    <div 
                        onclick="selectPackage('{{ $p['id'] }}')" 
                        id="pkgCard_{{ $p['id'] }}" 
                        class="pkg-select-card {{ $isSelected ? 'selected' : '' }}"
                        style="background: {{ $isSelected ? '#eff6ff' : '#ffffff' }}; border: {{ $isSelected ? '2px solid #00137a' : '1.5px solid #e2e8f0' }}; border-radius: 12px; padding: 14px 10px; text-align: center; cursor: pointer; transition: all 0.2s; position: relative; box-shadow: {{ $isSelected ? '0 4px 14px rgba(0, 19, 122, 0.12)' : '0 1px 3px rgba(0,0,0,0.04)' }};"
                    >
                        <div class="pkg-selected-indicator" style="display: {{ $isSelected ? 'inline-block' : 'none' }}; position: absolute; top: -9px; left: 50%; transform: translateX(-50%); background: #00137a; color: #ffffff; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 10px; letter-spacing: 0.5px; text-transform: uppercase;">
                            ✓ SELECTED
                        </div>

                        <div style="font-size: 0.76rem; font-weight: 800; color: {{ $isSelected ? '#00137a' : '#64748b' }}; text-transform: uppercase; margin-bottom: 4px;">
                            {{ $p['name'] }}
                        </div>
                        <div style="font-size: 1.15rem; font-weight: 900; color: #0f172a; margin-bottom: 4px;">
                            ₹{{ number_format($p['price']) }}
                        </div>
                        <div style="font-size: 0.72rem; color: #94a3b8; text-decoration: line-through;">
                            ₹{{ number_format($p['old_price']) }}
                        </div>
                        <div style="font-size: 0.72rem; color: #05B396; font-weight: 700; margin-top: 4px;">
                            {{ count($p['courses_included'] ?? []) }}+ Courses
                        </div>
                    </div>
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

            <div class="checkout-layout-grid" style="display: grid; grid-template-columns: 1.35fr 1fr; gap: 24px; align-items: start;">
                
                {{-- -------------------------------------------------------- --}}
                {{-- LEFT CARD: BILLING DETAILS                                --}}
                {{-- -------------------------------------------------------- --}}
                <div class="checkout-white-card" style="background: #ffffff; border: 1.5px solid #3b82f6; border-radius: 12px; padding: 28px 24px; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);">
                    <h2 style="font-size: 1.4rem; font-weight: 700; color: #1e293b; margin: 0 0 1.6rem 0;">
                        Billing Details
                    </h2>

                    <!-- Have a referral code? -->
                    <div style="margin-bottom: 1.4rem;">
                        <div style="display: flex; gap: 8px;">
                            <input 
                                type="text" 
                                name="referral_code" 
                                id="referralCodeInput" 
                                value="{{ old('referral_code', request('ref', session('user.sponsor_id', 'SKL-ADMIN'))) }}" 
                                placeholder="Have a referral code?" 
                                style="flex: 1; padding: 0.78rem 1rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.95rem; color: #0f172a; outline: none; background: #ffffff; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#3b82f6';"
                                onblur="this.style.borderColor='#e2e8f0';"
                            >
                            <button 
                                type="button" 
                                onclick="verifyReferralCode()" 
                                id="verifyCodeBtn"
                                style="background: #00137a; color: #ffffff; font-weight: 700; font-size: 0.92rem; padding: 0.78rem 1.6rem; border: none; border-radius: 6px; cursor: pointer; white-space: nowrap; transition: opacity 0.2s;"
                                onmouseover="this.style.opacity='0.92';"
                                onmouseout="this.style.opacity='1';"
                            >
                                Verify Code
                            </button>
                        </div>
                        <div id="referralStatusFeedback" style="font-size: 0.82rem; margin-top: 6px; color: #10b981; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            <span>✓</span> Verified Sponsor: <strong>SkillLearner Official (SKL-ADMIN)</strong>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div style="margin-bottom: 1.4rem;">
                        <label for="fullNameInput" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="fullNameInput" 
                            required 
                            placeholder="Enter your full name" 
                            value="{{ old('name') }}"
                            style="width: 100%; padding: 0.78rem 1rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.95rem; color: #0f172a; outline: none; background: #ffffff; box-sizing: border-box; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6';"
                            onblur="this.style.borderColor='#e2e8f0';"
                        >
                    </div>

                    <!-- Phone Number -->
                    <div style="margin-bottom: 1.4rem;">
                        <label for="phoneInput" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Phone Number
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phoneInput" 
                            required 
                            placeholder="Enter your phone number" 
                            value="{{ old('phone') }}"
                            style="width: 100%; padding: 0.78rem 1rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.95rem; color: #0f172a; outline: none; background: #ffffff; box-sizing: border-box; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6';"
                            onblur="this.style.borderColor='#e2e8f0';"
                        >
                    </div>

                    <!-- Email Address -->
                    <div style="margin-bottom: 1.4rem;">
                        <label for="emailInput" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="emailInput" 
                            required 
                            placeholder="Enter your email address" 
                            value="{{ old('email') }}"
                            style="width: 100%; padding: 0.78rem 1rem; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.95rem; color: #0f172a; outline: none; background: #ffffff; box-sizing: border-box; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6';"
                            onblur="this.style.borderColor='#e2e8f0';"
                        >
                    </div>

                    <!-- Create Password (With Eye Icon attached on right) -->
                    <div style="margin-bottom: 0.5rem;">
                        <label for="createPasswordInput" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Create Password
                        </label>
                        <div style="display: flex; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; background: #ffffff; transition: border-color 0.2s;" id="passwordWrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="createPasswordInput" 
                                required 
                                placeholder="Create a strong password" 
                                style="flex: 1; padding: 0.78rem 1rem; border: none; font-size: 0.95rem; color: #0f172a; outline: none; background: transparent;"
                                onfocus="document.getElementById('passwordWrapper').style.borderColor='#3b82f6';"
                                onblur="document.getElementById('passwordWrapper').style.borderColor='#e2e8f0';"
                            >
                            <button 
                                type="button" 
                                onclick="toggleCreatePassword()" 
                                aria-label="Toggle password visibility"
                                style="border: none; border-left: 1px solid #e2e8f0; background: #ffffff; padding: 0 14px; cursor: pointer; color: #64748b; display: flex; align-items: center; justify-content: center; outline: none;"
                            >
                                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                <div class="checkout-white-card" style="background: #ffffff; border: 1.5px solid #3b82f6; border-radius: 12px; padding: 28px 24px; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);">
                    <h2 style="font-size: 1.4rem; font-weight: 700; color: #1e293b; margin: 0 0 1.6rem 0;">
                        Payment Method
                    </h2>

                    <!-- Option 1: Payment Link (Card Pill) -->
                    <label 
                        id="labelPaymentLink" 
                        class="payment-option-pill active" 
                        style="display: flex; align-items: center; gap: 12px; padding: 13px 16px; border: 1.5px solid #00137a; background: #f8fafc; border-radius: 8px; margin-bottom: 12px; cursor: pointer; transition: all 0.2s;"
                        onclick="setPaymentMethod('payment_link')"
                    >
                        <input type="radio" name="payment_method" value="payment_link" checked style="accent-color: #00137a; width: 17px; height: 17px; cursor: pointer;">
                        <span style="font-size: 0.96rem; font-weight: 600; color: #1e293b;">Payment Link</span>
                    </label>

                    <!-- Option 2: Referral Wallet (Card Pill) -->
                    <label 
                        id="labelReferralWallet" 
                        class="payment-option-pill" 
                        style="display: flex; align-items: center; gap: 12px; padding: 13px 16px; border: 1px solid #e2e8f0; background: #ffffff; border-radius: 8px; margin-bottom: 1.4rem; cursor: pointer; transition: all 0.2s;"
                        onclick="setPaymentMethod('referral_wallet')"
                    >
                        <input type="radio" name="payment_method" value="referral_wallet" style="accent-color: #00137a; width: 17px; height: 17px; cursor: pointer;">
                        <span style="font-size: 0.96rem; font-weight: 600; color: #1e293b;">Referral Wallet</span>
                    </label>

                    <!-- Selected Package & Price Summary Box -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-bottom: 1.4rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span style="font-size: 0.84rem; color: #64748b; font-weight: 600;">Selected Package:</span>
                            <span id="summaryPkgName" style="font-size: 0.95rem; font-weight: 800; color: #00137a;">
                                {{ $selectedPackage['name'] }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: baseline; border-top: 1px dashed #cbd5e1; padding-top: 8px; margin-top: 4px;">
                            <span style="font-size: 0.92rem; font-weight: 700; color: #1e293b;">Total Payable:</span>
                            <span id="summaryPkgPrice" style="font-size: 1.55rem; font-weight: 900; color: #05B396;">
                                ₹{{ number_format($selectedPackage['price']) }}
                            </span>
                        </div>
                    </div>

                    <!-- Terms & Conditions Checkbox -->
                    <div style="margin-bottom: 1.4rem;">
                        <label style="display: flex; align-items: center; gap: 9px; font-size: 0.88rem; color: #64748b; cursor: pointer; user-select: none;">
                            <input type="checkbox" name="agree_terms" required checked style="accent-color: #00137a; width: 16px; height: 16px; border-radius: 4px; cursor: pointer;">
                            <span>
                                I agree to the <a href="{{ url('/about') }}" target="_blank" style="color: #4f46e5; text-decoration: underline; font-weight: 600;">terms and conditions</a>
                            </span>
                        </label>
                    </div>

                    <!-- Proceed to Payment Button -->
                    <button 
                        type="submit" 
                        id="proceedPaymentSubmitBtn"
                        style="width: 100%; padding: 0.95rem; background: #00137a; color: #ffffff; font-size: 1.05rem; font-weight: 800; border: none; border-radius: 8px; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 14px rgba(0, 19, 122, 0.25);"
                        onmouseover="this.style.background='#001066';"
                        onmouseout="this.style.background='#00137a';"
                    >
                        Proceed to Payment
                    </button>

                    <!-- Important ID Security Notice -->
                    <div style="margin-top: 1.2rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 0.85rem 1rem; font-size: 0.8rem; color: #1e40af; line-height: 1.5;">
                        🔒 <strong>Admin Verification Rule:</strong> Aapka registration submit hone ke baad aapki ID Admin ke pass verification ke liye rahegi. Payment confirm hone ke baad hi aap login kar sakenge.
                    </div>

                    <div style="text-align: center; margin-top: 1.2rem;">
                        <a href="{{ url('/login') }}" style="color: #64748b; font-size: 0.86rem; text-decoration: none; font-weight: 600;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
                            Already registered &amp; paid? <span style="color: #3b82f6; text-decoration: underline;">Log In Here</span>
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</div>

@push('styles')
<style>
    .packages-horizontal-row {
        width: 100%;
        box-sizing: border-box;
    }

    .pkg-select-card:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 900px) {
        .checkout-layout-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }

        .packages-horizontal-row {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)) !important;
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

        // 2. Update summary box
        document.getElementById('summaryPkgName').innerText = p.name;
        document.getElementById('summaryPkgPrice').innerText = '₹' + p.price.toLocaleString();
        document.getElementById('topActiveBadge').innerText = 'Currently Selected: ' + p.name;

        // 3. Highlight selected card & unhighlight others (All 5 remain visible side-by-side)
        Object.keys(allPackagesData).forEach(key => {
            const card = document.getElementById('pkgCard_' + key);
            if (!card) return;
            const indicator = card.querySelector('.pkg-selected-indicator');

            if (key === pkgId) {
                card.style.background = '#eff6ff';
                card.style.borderColor = '#00137a';
                card.style.borderWidth = '2px';
                card.style.boxShadow = '0 4px 14px rgba(0, 19, 122, 0.12)';
                if (indicator) indicator.style.display = 'inline-block';
            } else {
                card.style.background = '#ffffff';
                card.style.borderColor = '#e2e8f0';
                card.style.borderWidth = '1.5px';
                card.style.boxShadow = '0 1px 3px rgba(0,0,0,0.04)';
                if (indicator) indicator.style.display = 'none';
            }
        });
    }

    function setPaymentMethod(method) {
        const linkLabel = document.getElementById('labelPaymentLink');
        const walletLabel = document.getElementById('labelReferralWallet');

        if (method === 'payment_link') {
            linkLabel.style.borderColor = '#00137a';
            linkLabel.style.borderWidth = '1.5px';
            linkLabel.style.background = '#f8fafc';
            walletLabel.style.borderColor = '#e2e8f0';
            walletLabel.style.borderWidth = '1px';
            walletLabel.style.background = '#ffffff';
        } else {
            walletLabel.style.borderColor = '#00137a';
            walletLabel.style.borderWidth = '1.5px';
            walletLabel.style.background = '#f8fafc';
            linkLabel.style.borderColor = '#e2e8f0';
            linkLabel.style.borderWidth = '1px';
            linkLabel.style.background = '#ffffff';
        }
    }

    function toggleCreatePassword() {
        const pwdInput = document.getElementById('createPasswordInput');
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
