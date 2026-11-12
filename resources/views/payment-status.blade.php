@extends('layouts.app')

@section('title', 'Payment Status — SkillLearner')

@section('content')
<section class="container payment-status-container" style="max-width: 760px; padding: 4rem 1.5rem 6rem;">
    @php
        $isSuccess = ($order['status'] ?? 'Pending') === 'Credited' || request('status') === 'success';
        $packageName = $order['package_name'] ?? 'Advance Package';
        $amount = $order['amount'] ?? 2499;
        $orderId = $order['order_id'] ?? ('ORD-' . rand(100000, 999999));
        $transactionId = $order['transaction_id'] ?? ('UTR' . rand(100000000000, 999999999999));
        $buyerName = $order['user_name'] ?? (session('user.name', 'Student'));
        $buyerEmail = $order['user_email'] ?? (session('user.email', ''));
    @endphp

    <div class="glass payment-status-card" style="padding: 2.8rem 2.2rem; border-radius: var(--radius-lg); text-align: center; border: 2px solid {{ $isSuccess ? '#10b981' : '#f59e0b' }}; background: {{ $isSuccess ? 'linear-gradient(180deg, rgba(16, 185, 129, 0.08) 0%, rgba(7, 10, 18, 0.95) 100%)' : 'linear-gradient(180deg, rgba(245, 158, 11, 0.08) 0%, rgba(7, 10, 18, 0.95) 100%)' }}; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.45); position: relative; overflow: hidden;">
        
        <!-- Ambient Radial Glow -->
        <div style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); width: 280px; height: 280px; background: radial-gradient(circle, {{ $isSuccess ? 'rgba(16, 185, 129, 0.25)' : 'rgba(245, 158, 11, 0.25)' }} 0%, transparent 70%); filter: blur(35px); pointer-events: none;"></div>

        @if($isSuccess)
            {{-- ========================================================= --}}
            {{-- STATE B: PAYMENT SUCCESS & APPROVED                       --}}
            {{-- ========================================================= --}}
            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); border: 2px solid #10b981; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.2rem; font-size: 2.5rem;">
                ✅
            </div>

            <div style="display: inline-block; background: #ecfdf5; color: #047857; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; letter-spacing: 0.8px; margin-bottom: 0.8rem; border: 1px solid #a7f3d0;">
                ● PAYMENT VERIFIED &amp; ENROLLMENT ACTIVE
            </div>

            <h2 style="font-size: clamp(1.8rem, 4vw, 2.3rem); font-weight: 900; color: #ffffff; margin-bottom: 0.5rem; letter-spacing: -0.5px;">
                Congratulations, {{ $buyerName }}! 🎉
            </h2>
            <p style="color: #cbd5e1; font-size: 1rem; max-width: 580px; margin: 0 auto 2rem; line-height: 1.6;">
                Your payment for <strong>{{ $packageName }}</strong> has been verified by the administration. Your classroom, masterclass videos, and affiliate portal are now fully unlocked!
            </p>

            <!-- Order Confirmation Card -->
            <div style="background: rgba(15, 23, 42, 0.9); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 12px; padding: 1.4rem; text-align: left; margin-bottom: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.9rem;">
                    <div>
                        <div style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700;">Order ID</div>
                        <div style="color: #ffffff; font-weight: 800;">#{{ $orderId }}</div>
                    </div>
                    <div>
                        <div style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700;">Package Activated</div>
                        <div style="color: #10b981; font-weight: 800;">{{ $packageName }}</div>
                    </div>
                    <div>
                        <div style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700;">Amount Verified</div>
                        <div style="color: #ffffff; font-weight: 800;">₹{{ number_format($amount) }}</div>
                    </div>
                    <div>
                        <div style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700;">Transaction UTR</div>
                        <div style="color: #ffffff; font-weight: 700; font-family: monospace;">{{ $transactionId }}</div>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ url('/login') }}" class="btn btn-primary" style="background: #05B396; color: #fff; font-size: 1.05rem; font-weight: 800; padding: 0.9rem 2rem; border-radius: 10px; box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35); text-decoration: none;">
                    🔑 Log In to Your Account ➔
                </a>
                <a href="{{ url('/classroom') }}" class="btn" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 0.95rem; font-weight: 700; padding: 0.9rem 1.6rem; border-radius: 10px; text-decoration: none;">
                    🚀 Enter Classroom
                </a>
            </div>

        @else
            {{-- ========================================================= --}}
            {{-- STATE A: PAYMENT PENDING VERIFICATION OR FAILED RETRY    --}}
            {{-- ========================================================= --}}
            @if(($order['status'] ?? '') === 'Failed' || session('error'))
                <div style="background: rgba(239, 68, 68, 0.15); border: 1.5px solid #ef4444; border-radius: 12px; padding: 1.1rem 1.3rem; margin-bottom: 1.6rem; text-align: center;">
                    <div style="font-weight: 800; color: #f87171; font-size: 1.05rem; margin-bottom: 4px;">
                        ⚠️ {{ session('error') ?: 'Payment could not be completed.' }}
                    </div>
                    <div style="color: #fca5a5; font-size: 0.88rem; margin-bottom: 12px;">
                        Aap dobara online payment try kar sakte hain ya neeche diye gaye QR code se manual transfer kar sakte hain.
                    </div>
                    <a href="{{ url('/buy-now') }}" style="display: inline-block; background: #ef4444; color: #fff; font-weight: 800; font-size: 0.88rem; padding: 9px 20px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);">
                        🔄 Retry Payment Now
                    </a>
                </div>
            @endif

            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(245, 158, 11, 0.15); border: 2px solid #f59e0b; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.2rem; font-size: 2.5rem; animation: pulse 2s infinite ease-in-out;">
                ⏳
            </div>

            <div style="display: inline-block; background: #fffbeb; color: #b45309; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; letter-spacing: 0.8px; margin-bottom: 0.8rem; border: 1px solid #fde68a;">
                ⏳ PAYMENT VERIFICATION PENDING WITH ADMIN
            </div>

            <h2 style="font-size: clamp(1.8rem, 4vw, 2.3rem); font-weight: 900; color: #ffffff; margin-bottom: 0.5rem; letter-spacing: -0.5px;">
                Order Created Successfully!
            </h2>
            <p style="color: #cbd5e1; font-size: 1rem; max-width: 580px; margin: 0 auto 1.5rem; line-height: 1.6;">
                Thank you, <strong>{{ $buyerName }}</strong>. Aapki registration request <strong>{{ $packageName }} (₹{{ number_format($amount) }})</strong> ke liye darj ho gayi hai.
            </p>

            <!-- Important Admin Verification Callout -->
            <div style="background: rgba(245, 158, 11, 0.12); border: 1.5px solid #f59e0b; border-radius: 12px; padding: 1.1rem 1.3rem; margin-bottom: 1.8rem; text-align: left;">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 800; color: #fbbf24; font-size: 0.96rem; margin-bottom: 4px;">
                    <span>🔒</span> Important: Account Access Notice
                </div>
                <div style="font-size: 0.88rem; color: #fde68a; line-height: 1.5;">
                    Jab tak payment complete aur verify nahi hogi, tab tak aapki ID Admin ke pass hi rahegi aur aap <strong>login nahi kar sakte</strong>. Payment karke 12-digit UTR submit karein, Admin verify karke aapka account activate kar dega.
                </div>
            </div>

            <!-- UPI Payment Details & QR Box -->
            <div style="background: rgba(15, 23, 42, 0.95); border: 1.5px solid rgba(5, 179, 150, 0.4); border-radius: 14px; padding: 1.6rem; margin-bottom: 1.8rem; text-align: center;">
                <div style="font-size: 0.82rem; font-weight: 800; text-transform: uppercase; color: #05B396; letter-spacing: 0.6px; margin-bottom: 0.8rem;">
                    📲 Complete Your Payment (Scan QR or Pay via UPI)
                </div>

                <div style="display: flex; justify-content: center; margin-bottom: 0.8rem;">
                    <div style="background: #ffffff; padding: 12px; border-radius: 12px; display: inline-block;">
                        <svg width="140" height="140" viewBox="0 0 100 100">
                            <rect width="100" height="100" fill="#ffffff"/>
                            <rect x="5" y="5" width="28" height="28" fill="#0f172a" rx="2"/>
                            <rect x="9" y="9" width="20" height="20" fill="#ffffff" rx="1"/>
                            <rect x="13" y="13" width="12" height="12" fill="#05B396" rx="1"/>
                            <rect x="67" y="5" width="28" height="28" fill="#0f172a" rx="2"/>
                            <rect x="71" y="9" width="20" height="20" fill="#ffffff" rx="1"/>
                            <rect x="75" y="13" width="12" height="12" fill="#05B396" rx="1"/>
                            <rect x="5" y="67" width="28" height="28" fill="#0f172a" rx="2"/>
                            <rect x="9" y="71" width="20" height="20" fill="#ffffff" rx="1"/>
                            <rect x="13" y="75" width="12" height="12" fill="#05B396" rx="1"/>
                            <rect x="40" y="8" width="6" height="6" fill="#0f172a"/>
                            <rect x="52" y="8" width="6" height="6" fill="#0f172a"/>
                            <rect x="40" y="20" width="6" height="6" fill="#0f172a"/>
                            <rect x="50" y="24" width="8" height="8" fill="#0f172a"/>
                            <rect x="12" y="42" width="6" height="6" fill="#0f172a"/>
                            <rect x="24" y="46" width="8" height="8" fill="#0f172a"/>
                            <rect x="42" y="42" width="16" height="16" fill="#05B396" rx="2"/>
                            <rect x="68" y="42" width="6" height="6" fill="#0f172a"/>
                            <rect x="80" y="46" width="8" height="8" fill="#0f172a"/>
                            <rect x="42" y="68" width="8" height="8" fill="#0f172a"/>
                            <rect x="56" y="72" width="6" height="6" fill="#0f172a"/>
                            <rect x="72" y="72" width="16" height="16" fill="#0f172a"/>
                            <rect x="44" y="86" width="10" height="6" fill="#05B396"/>
                        </svg>
                    </div>
                </div>

                <div style="font-size: 0.95rem; font-weight: 700; color: #ffffff; margin-bottom: 0.4rem;">
                    Pay Amount: <span style="color: #05B396; font-size: 1.3rem;">₹{{ number_format($amount) }}</span>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1px solid rgba(5, 179, 150, 0.35); padding: 6px 14px; border-radius: 8px; font-size: 0.88rem; color: #05B396; font-weight: 700; margin-bottom: 0.6rem;">
                    <span>UPI: support.skilllearner@oksbi</span>
                    <button type="button" onclick="navigator.clipboard.writeText('support.skilllearner@oksbi'); alert('Official UPI ID copied: support.skilllearner@oksbi')" style="background: none; border: none; color: #38bdf8; cursor: pointer; text-decoration: underline; font-weight: 800; font-size: 0.85rem;">
                        Copy
                    </button>
                </div>
                <div style="font-size: 0.78rem; color: #94a3b8;">
                    Supported: GPay, PhonePe, Paytm, CRED, BHIM &amp; All Banking Apps
                </div>
            </div>

            <!-- UTR Submission Form -->
            <div style="background: rgba(15, 23, 42, 0.9); border: 1.5px solid rgba(245, 158, 11, 0.4); border-radius: 14px; padding: 1.6rem; text-align: left; margin-bottom: 2rem;">
                <h3 style="color: #ffffff; font-size: 1.15rem; font-weight: 800; margin-top: 0; margin-bottom: 0.8rem; display: flex; align-items: center; gap: 8px;">
                    <span>📝</span> Step 2: Submit 12-Digit UTR Number
                </h3>

                @if($transactionId !== 'PENDING' && !empty($transactionId))
                    <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid #10b981; padding: 0.85rem 1rem; border-radius: 8px; color: #34d399; font-size: 0.88rem; margin-bottom: 1.2rem;">
                        ✓ Submitted UTR: <strong style="font-family: monospace; font-size: 1rem; color: #fff;">{{ $transactionId }}</strong> (Awaiting Admin Verification)
                    </div>
                @endif

                <form method="POST" action="{{ route('payment.submit-utr') }}">
                    @csrf
                    <div style="margin-bottom: 1.2rem;">
                        <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Enter 12-Digit UTR / Transaction Reference Number <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="transaction_id" required value="{{ $transactionId !== 'PENDING' ? $transactionId : '' }}" placeholder="e.g. 439281928471" maxlength="35" style="width: 100%; padding: 0.85rem 1rem; background: #1e293b; border: 1.5px solid #05B396; border-radius: 8px; font-size: 1rem; color: #fff; font-family: monospace; font-weight: 700; outline: none; box-sizing: border-box;">
                        <span style="font-size: 0.76rem; color: #94a3b8; display: block; margin-top: 0.35rem;">
                            💡 UTR number aapke UPI app (PhonePe/GPay/Paytm) ke payment confirmation screen par milta hai.
                        </span>
                    </div>

                    <button type="submit" style="width: 100%; padding: 0.95rem; background: #05B396; color: #ffffff; font-size: 1.05rem; font-weight: 800; border: none; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 16px rgba(5, 179, 150, 0.35);">
                        Submit UTR for Admin Verification ➔
                    </button>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="payment-actions-wrapper" style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <!-- Fast Track WhatsApp Verification -->
                <a href="https://api.whatsapp.com/send?phone=918318373108&text=Hello%20SkillLearner%20Admin,%20I%20have%20completed%20payment%20for%20{{ urlencode($packageName) }}%20(₹{{ $amount }}).%20My%20Order%20ID%20is%20{{ $orderId }}%20and%20UTR%20is%20{{ $transactionId }}.%20Please%20verify%20my%20account." target="_blank" class="btn" style="background: #25d366; color: #fff; font-size: 0.95rem; font-weight: 800; padding: 0.85rem 1.6rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <span>📲 Send UTR on WhatsApp: 8318373108</span>
                </a>

                <!-- Check/Refresh Status -->
                <a href="{{ url('/payment-status') }}" class="btn" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 0.92rem; font-weight: 700; padding: 0.85rem 1.4rem; border-radius: 10px; text-decoration: none;">
                    🔄 Refresh Status
                </a>

                <!-- Back to Login -->
                <a href="{{ url('/login') }}" class="btn" style="background: #0f172a; border: 1px solid #334155; color: #94a3b8; font-size: 0.92rem; font-weight: 700; padding: 0.85rem 1.4rem; border-radius: 10px; text-decoration: none;">
                    🔑 Login Page
                </a>
            </div>

        @endif

    </div>
</section>

@push('styles')
<style>
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.06); opacity: 0.85; }
    }

    @media (max-width: 600px) {
        .payment-status-container {
            padding: 1.5rem 0.75rem 4rem !important;
        }

        .payment-status-card {
            padding: 1.8rem 1rem !important;
            border-radius: 14px !important;
        }

        .payment-status-card h2 {
            font-size: 1.45rem !important;
        }

        .payment-actions-wrapper {
            flex-direction: column !important;
            width: 100% !important;
        }

        .payment-actions-wrapper .btn {
            width: 100% !important;
            box-sizing: border-box !important;
            justify-content: center !important;
            text-align: center !important;
        }
    }
</style>
@endpush
@endsection

