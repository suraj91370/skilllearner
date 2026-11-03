@extends('layouts.app')

@section('title', 'Affiliate Referral Links — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'affiliate-link'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'affiliate-link'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card" style="max-width: 920px;">
                <div style="margin-bottom: 1.8rem;">
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.78rem; font-weight: 800; padding: 4px 12px; border-radius: 20px; margin-bottom: 0.5rem; letter-spacing: 0.5px;">
                        🔗 MULTI-LINK AFFILIATE ENGINE
                    </div>
                    <h3 style="font-size: 1.6rem; color: #0f172a; font-weight: 800; margin: 0 0 6px 0;">
                        Your Affiliate Marketing Referral Links
                    </h3>
                    <p style="color: #64748b; font-size: 0.94rem; margin: 0; line-height: 1.5;">
                        Aapke paas do tarah ke referral links hain: <strong>1 Common Link</strong> jisme lead ko sabhi 5 packages dikhenge, aur <strong>5 Separate Links</strong> jinhe share karne par direct wahi package khulega.
                    </p>
                </div>

                @php
                    $affId = session('user.affiliate_id', 'SL-8821');
                    $commonPlansUrl = url('/plans') . '?ref=' . urlencode($affId);
                    $commonBuyNowUrl = url('/buy-now') . '?package=all&ref=' . urlencode($affId);
                    $signupUrl = url('/register') . '?ref=' . urlencode($affId);

                    $packagesList = [
                        [
                            'id' => 'basic',
                            'name' => '1. Basic Package',
                            'price' => 599,
                            'active' => 420,
                            'passive' => 50,
                            'color' => '#8b5cf6',
                            'desc' => 'Affiliate Marketing Basics, Spoken English & Communication Skills',
                        ],
                        [
                            'id' => 'growth',
                            'name' => '2. Growth Package',
                            'price' => 1199,
                            'active' => 840,
                            'passive' => 100,
                            'color' => '#10b981',
                            'desc' => 'Canva Graphic Designing, Reel Mastery & VN Mobile Video Editing',
                        ],
                        [
                            'id' => 'advance',
                            'name' => '3. Advance Package',
                            'price' => 2499,
                            'active' => 1900,
                            'passive' => 200,
                            'color' => '#0284c7',
                            'desc' => 'E-mail Marketing, Sales Mastery, High-Ticket Video Marketing',
                        ],
                        [
                            'id' => 'premium',
                            'name' => '4. Premium Package',
                            'price' => 4999,
                            'active' => 3800,
                            'passive' => 400,
                            'color' => '#f59e0b',
                            'desc' => 'Full YouTube Monetization, Meta Facebook Ads, Web Designing',
                        ],
                        [
                            'id' => 'infinity',
                            'name' => '5. Infinity Package',
                            'price' => 7999,
                            'active' => 5500,
                            'passive' => 500,
                            'color' => '#ef4444',
                            'desc' => '0 to Hero AI Content Creation, AI Automation, Stock Market Mastery',
                        ],
                    ];
                @endphp

                {{-- ========================================================= --}}
                {{-- 1. COMMON ALL-PACKAGES LINK (Sabhi 5 Packages Khulenge)    --}}
                {{-- ========================================================= --}}
                <div style="background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%); border: 2px solid #05B396; border-radius: 14px; padding: 1.6rem; margin-bottom: 2.2rem; box-shadow: 0 4px 16px rgba(5, 179, 150, 0.08);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 8px;">
                        <span style="font-size: 0.8rem; background: #05B396; color: #ffffff; font-weight: 800; text-transform: uppercase; padding: 4px 12px; border-radius: 20px; letter-spacing: 0.6px;">
                            🌟 1. COMMON ALL-PACKAGES LINK (MASTER LINK)
                        </span>
                        <span style="font-size: 0.82rem; color: #047857; font-weight: 700;">
                            ✨ Sabhi 5 Packages Ek Sath Khulenge
                        </span>
                    </div>

                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #064e3b; margin: 0 0 6px 0;">
                        All Packages Showcase &amp; Direct Enrollment Link
                    </h4>
                    <p style="color: #475569; font-size: 0.88rem; margin: 0 0 1.1rem 0; line-height: 1.5;">
                        Agar aap ye link kisi ko share karenge, to buyer ke samne <strong>sabhi 5 packages (Basic se Infinity tak)</strong> khulenge aur buyer apni pasand se koi bhi package select karke Buy Now kar sakta hai. Aapka sponsor referral ID auto-attach rahega!
                    </p>

                    <!-- Link Box -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.1rem;">
                        <input type="text" id="commonAllPackagesLink" style="flex: 1; min-width: 280px; padding: 0.85rem 1rem; border: 1.5px solid #a7f3d0; border-radius: 8px; font-size: 0.95rem; font-weight: 700; background: #ffffff; color: #065f46;" value="{{ $commonPlansUrl }}" readonly>
                        <button type="button" onclick="copyTextToClipboard('commonAllPackagesLink', '🌟 Common All-Packages Link Copied!')" class="btn btn-primary" style="background: #05B396; font-weight: 800; padding: 0.85rem 1.6rem; border-radius: 8px; white-space: nowrap;">
                            📋 Copy Common Link
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                        <a href="https://api.whatsapp.com/send?text=Explore%20all%20digital%20skill%20packages%20and%20start%20learning%20today:%20{{ urlencode($commonPlansUrl) }}" target="_blank" class="btn" style="background: #25d366; color: #fff; font-size: 0.84rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 7px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <span>📲 Share on WhatsApp</span>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode($commonPlansUrl) }}&text=Master%20Digital%20Skills%20with%20SkillLearner" target="_blank" class="btn" style="background: #0088cc; color: #fff; font-size: 0.84rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 7px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <span>✈️ Share on Telegram</span>
                        </a>
                        <a href="{{ $commonPlansUrl }}" target="_blank" class="btn" style="background: #ffffff; color: #047857; border: 1.5px solid #a7f3d0; font-size: 0.84rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 7px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <span>👁️ Test / Open Page ➔</span>
                        </a>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- 2. INDIVIDUAL PACKAGE DIRECT LINKS (Sirf Wahi Package)    --}}
                {{-- ========================================================= --}}
                <div style="margin-bottom: 1.4rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem; flex-wrap: wrap; gap: 8px;">
                        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 0.78rem; font-weight: 800; padding: 4px 12px; border-radius: 20px; letter-spacing: 0.5px;">
                            🎯 2. INDIVIDUAL PACKAGE DIRECT LINKS
                        </div>
                        <span style="font-size: 0.82rem; color: #7c3aed; font-weight: 700;">
                            🔒 Sirf Wahi Ek Package Khulega
                        </span>
                    </div>

                    <h4 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
                        Direct Single-Package Checkout Links (5 Separate Links)
                    </h4>
                    <p style="color: #64748b; font-size: 0.88rem; margin: 0 0 1.4rem 0;">
                        Agar aapne kisi student ko particular package (jaise Advance ya Growth) pitch kiya hai, to niche se <strong>wahi specific link</strong> copy karein. Buyer jab link open karega, to <strong>sirf wahi ek package direct checkout ke liye khulega!</strong>
                    </p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                    @foreach ($packagesList as $pkg)
                        @php
                            $pkgBuyUrl = url('/buy-now') . '?package=' . $pkg['id'] . '&ref=' . urlencode($affId);
                        @endphp
                        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 1.3rem; border-left: 5px solid {{ $pkg['color'] }}; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03); transition: all 0.2s ease;">
                            
                            <!-- Header Info -->
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem; flex-wrap: wrap; gap: 10px;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        <h5 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                                            {{ $pkg['name'] }}
                                        </h5>
                                        <span style="font-size: 1.1rem; font-weight: 900; color: {{ $pkg['color'] }};">
                                            ₹{{ number_format($pkg['price']) }}
                                        </span>
                                    </div>
                                    <p style="font-size: 0.82rem; color: #64748b; margin: 4px 0 0 0;">
                                        {{ $pkg['desc'] }}
                                    </p>
                                </div>

                                <!-- Commission Badges -->
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                    <span style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 800;">
                                        ⚡ Active: +₹{{ number_format($pkg['active']) }}
                                    </span>
                                    <span style="background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 800;">
                                        💎 Passive: +₹{{ number_format($pkg['passive']) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Link & Actions Row -->
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.6rem 0.9rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;">
                                    <span style="font-size: 0.82rem; color: #94a3b8; font-weight: 700;">LINK:</span>
                                    <input type="text" id="pkg-link-{{ $pkg['id'] }}" value="{{ $pkgBuyUrl }}" readonly style="background: transparent; border: none; font-size: 0.86rem; color: #334155; font-weight: 600; width: 100%; outline: none; text-overflow: ellipsis;">
                                </div>

                                <div style="display: flex; gap: 6px; flex-shrink: 0;">
                                    <!-- Copy Button -->
                                    <button type="button" onclick="copyTextToClipboard('pkg-link-{{ $pkg['id'] }}', '✅ {{ addslashes($pkg['name']) }} Direct Checkout Link Copied!')" class="btn" style="background: #05B396; color: #ffffff; padding: 6px 14px; font-size: 0.82rem; font-weight: 800; border-radius: 6px; border: none; cursor: pointer; white-space: nowrap;">
                                        📋 Copy Link
                                    </button>

                                    <!-- WhatsApp Button -->
                                    <a href="https://api.whatsapp.com/send?text=Enroll%20directly%20in%20{{ urlencode($pkg['name']) }}%20(₹{{ $pkg['price'] }}):%20{{ urlencode($pkgBuyUrl) }}" target="_blank" class="btn" style="background: #25d366; color: #ffffff; padding: 6px 10px; font-size: 0.82rem; font-weight: 700; border-radius: 6px; text-decoration: none;" title="Share on WhatsApp">
                                        📲
                                    </a>

                                    <!-- Test/Open in New Tab -->
                                    <a href="{{ $pkgBuyUrl }}" target="_blank" class="btn" style="background: #ffffff; color: #64748b; border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 0.82rem; font-weight: 700; border-radius: 6px; text-decoration: none;" title="Open and Test">
                                        👁️
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- ========================================================= --}}
                {{-- 3. MASTER SIGNUP URL (Free Registration / Student Signup) --}}
                {{-- ========================================================= --}}
                <div style="margin-top: 2.2rem; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 1.2rem;">
                    <div style="font-size: 0.78rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">
                        📝 FREE STUDENT REGISTRATION &amp; ACCOUNT SIGNUP URL
                    </div>
                    <p style="font-size: 0.84rem; color: #94a3b8; margin: 0 0 0.8rem 0;">
                        Agar koi student bina package select kiye seedhe apna student account register karna chahe, to ye link share karein.
                    </p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <input type="text" id="freeSignupLink" style="flex: 1; min-width: 260px; padding: 0.7rem 0.9rem; border: 1px solid #e2e8f0; border-radius: 7px; font-size: 0.88rem; background: #f8fafc; color: #334155;" value="{{ $signupUrl }}" readonly>
                        <button type="button" onclick="copyTextToClipboard('freeSignupLink', '✅ Free Registration Link Copied!')" class="btn" style="background: #334155; color: #fff; font-size: 0.84rem; font-weight: 700; padding: 0.7rem 1.2rem; border-radius: 7px; white-space: nowrap;">
                            Copy Signup Link
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function copyTextToClipboard(elementId, successMessage) {
        const input = document.getElementById(elementId);
        if (!input) return;

        input.select();
        input.setSelectionRange(0, 99999);

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(input.value).then(() => {
                showToastAlert(successMessage || '✅ Link Copied to Clipboard!');
            }).catch(() => {
                document.execCommand('copy');
                showToastAlert(successMessage || '✅ Link Copied to Clipboard!');
            });
        } else {
            document.execCommand('copy');
            showToastAlert(successMessage || '✅ Link Copied to Clipboard!');
        }
    }

    function showToastAlert(message) {
        const existingToast = document.getElementById('affiliateToastNotification');
        if (existingToast) existingToast.remove();

        const toast = document.createElement('div');
        toast.id = 'affiliateToastNotification';
        toast.innerText = message;
        toast.style.position = 'fixed';
        toast.style.bottom = '24px';
        toast.style.right = '24px';
        toast.style.background = '#0f172a';
        toast.style.color = '#ffffff';
        toast.style.padding = '12px 22px';
        toast.style.borderRadius = '10px';
        toast.style.fontWeight = '700';
        toast.style.fontSize = '0.92rem';
        toast.style.boxShadow = '0 10px 30px rgba(0,0,0,0.35)';
        toast.style.zIndex = '99999';
        toast.style.border = '1.5px solid #05B396';
        toast.style.transition = 'all 0.3s ease';

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 350);
        }, 3000);
    }
</script>
@endpush
@endsection
