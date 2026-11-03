@extends('layouts.app')

@section('title', 'Payment Status — SkillLearner')

@section('content')
<section class="container" style="max-width: 760px; padding: 4rem 1.5rem 6rem;">
    @php
        $isSuccess = ($order['status'] ?? 'Pending') === 'Credited' || request('status') === 'success';
        $packageName = $order['package_name'] ?? 'Advance Package';
        $amount = $order['amount'] ?? 2499;
        $orderId = $order['order_id'] ?? ('ORD-' . rand(100000, 999999));
        $transactionId = $order['transaction_id'] ?? ('UTR' . rand(100000000000, 999999999999));
        $buyerName = $order['user_name'] ?? (session('user.name', 'Student'));
        $buyerEmail = $order['user_email'] ?? (session('user.email', ''));
    @endphp

    <div class="glass" style="padding: 2.8rem 2.2rem; border-radius: var(--radius-lg); text-align: center; border: 2px solid {{ $isSuccess ? '#10b981' : '#f59e0b' }}; background: {{ $isSuccess ? 'linear-gradient(180deg, rgba(16, 185, 129, 0.08) 0%, rgba(7, 10, 18, 0.95) 100%)' : 'linear-gradient(180deg, rgba(245, 158, 11, 0.08) 0%, rgba(7, 10, 18, 0.95) 100%)' }}; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.45); position: relative; overflow: hidden;">
        
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
                <a href="{{ url('/classroom') }}" class="btn btn-primary" style="background: #05B396; color: #fff; font-size: 1.05rem; font-weight: 800; padding: 0.9rem 2rem; border-radius: 10px; box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35); text-decoration: none;">
                    🚀 Enter Classroom &amp; Start Learning ➔
                </a>
                <a href="{{ url('/my-courses') }}" class="btn" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 0.95rem; font-weight: 700; padding: 0.9rem 1.6rem; border-radius: 10px; text-decoration: none;">
                    📚 My Courses
                </a>
            </div>

        @else
            {{-- ========================================================= --}}
            {{-- STATE A: PAYMENT PENDING VERIFICATION                     --}}
            {{-- ========================================================= --}}
            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(245, 158, 11, 0.15); border: 2px solid #f59e0b; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.2rem; font-size: 2.5rem; animation: pulse 2s infinite ease-in-out;">
                ⏳
            </div>

            <div style="display: inline-block; background: #fffbeb; color: #b45309; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; padding: 4px 14px; border-radius: 20px; letter-spacing: 0.8px; margin-bottom: 0.8rem; border: 1px solid #fde68a;">
                ⏳ PAYMENT VERIFICATION IN PROGRESS
            </div>

            <h2 style="font-size: clamp(1.8rem, 4vw, 2.3rem); font-weight: 900; color: #ffffff; margin-bottom: 0.5rem; letter-spacing: -0.5px;">
                Payment Submitted Successfully!
            </h2>
            <p style="color: #cbd5e1; font-size: 1rem; max-width: 580px; margin: 0 auto 2rem; line-height: 1.6;">
                Thank you, <strong>{{ $buyerName }}</strong>. We have received your payment submission for <strong>{{ $packageName }} (₹{{ number_format($amount) }})</strong>.
            </p>

            <!-- Order Pending Details Card -->
            <div style="background: rgba(15, 23, 42, 0.9); border: 1.5px solid rgba(245, 158, 11, 0.4); border-radius: 14px; padding: 1.6rem; text-align: left; margin-bottom: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; font-size: 0.92rem;">
                    <div>
                        <div style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700;">Order Reference</div>
                        <div style="color: #ffffff; font-weight: 800; font-size: 1.05rem;">#{{ $orderId }}</div>
                    </div>
                    <div>
                        <div style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700;">Selected Package</div>
                        <div style="color: #05B396; font-weight: 800; font-size: 1.05rem;">{{ $packageName }}</div>
                    </div>
                    <div>
                        <div style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700;">Payable Amount</div>
                        <div style="color: #ffffff; font-weight: 900; font-size: 1.15rem;">₹{{ number_format($amount) }}</div>
                    </div>
                    <div>
                        <div style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700;">Submitted UTR / Transaction ID</div>
                        <div style="color: #f59e0b; font-weight: 800; font-family: monospace; font-size: 1rem; word-break: break-all;">{{ $transactionId }}</div>
                    </div>
                    <div style="grid-column: span 2; border-top: 1px dashed rgba(255, 255, 255, 0.1); padding-top: 0.8rem;">
                        <div style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; margin-bottom: 2px;">Verification Status</div>
                        <div style="display: inline-flex; align-items: center; gap: 6px; color: #fbbf24; font-weight: 800;">
                            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #fbbf24;"></span>
                            Awaiting Super Admin Confirmation
                        </div>
                    </div>
                </div>
            </div>

            <!-- Helpful Verification Note -->
            <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 10px; padding: 1.1rem; text-align: left; font-size: 0.86rem; color: #fde68a; line-height: 1.6; margin-bottom: 2rem;">
                💡 <strong>Important Note:</strong> Our verification team matches your submitted UTR reference with bank payment logs. As soon as the payment is confirmed by administration (usually within a few minutes), your package will become <strong>Verified</strong> and your courses will activate automatically.
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <!-- Fast Track WhatsApp Verification -->
                <a href="https://api.whatsapp.com/send?phone=918318373108&text=Hello%20SkillLearner%20Admin,%20I%20have%20completed%20payment%20for%20{{ urlencode($packageName) }}%20(₹{{ $amount }}).%20My%20Order%20ID%20is%20{{ $orderId }}%20and%20UTR%20is%20{{ $transactionId }}.%20Please%20verify%20my%20account." target="_blank" class="btn" style="background: #25d366; color: #fff; font-size: 0.95rem; font-weight: 800; padding: 0.85rem 1.6rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <span>📲 Send UTR on WhatsApp: 8318373108</span>
                </a>

                <!-- Check/Refresh Status -->
                <a href="{{ url('/payment-status') }}" class="btn" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 0.92rem; font-weight: 700; padding: 0.85rem 1.4rem; border-radius: 10px; text-decoration: none;">
                    🔄 Refresh Status
                </a>

                <!-- Go to Dashboard -->
                <a href="{{ url('/dashboard') }}" class="btn" style="background: #0f172a; border: 1px solid #334155; color: #94a3b8; font-size: 0.92rem; font-weight: 700; padding: 0.85rem 1.4rem; border-radius: 10px; text-decoration: none;">
                    📊 Go to Dashboard
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
</style>
@endpush
@endsection

