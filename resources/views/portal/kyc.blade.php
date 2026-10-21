@extends('layouts.app')

@section('title', 'KYC Compliance — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'kyc'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'kyc'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card" style="max-width: 820px;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 1.5rem; flex-wrap: wrap;">
                    <div style="width: 52px; height: 52px; border-radius: 50%; background: #ecfdf5; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; border: 2px solid #a7f3d0;">
                        🛡️
                    </div>
                    <div>
                        <h3 style="font-size: 1.45rem; color: #0f172a; font-weight: 800;">KYC Compliance Status: <span style="color: #10b981;">VERIFIED ✅</span></h3>
                        <p style="color: #64748b; font-size: 0.92rem;">Your government identity is fully approved for automated same-day UPI &amp; Bank direct deposits.</p>
                    </div>
                </div>

                <div style="background: #f8fafc; border-radius: 12px; padding: 1.5rem; border: 1px solid #e2e8f0; font-size: 0.95rem; line-height: 2; margin-bottom: 1.8rem;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-weight: 600;">Government Aadhaar UID:</span>
                        <strong style="color: #0f172a;">XXXXXXXX4819 (Verified via OTP ✅)</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-weight: 600;">Income Tax PAN Card:</span>
                        <strong style="color: #0f172a;">ABCDE1234F (Verified with NSDL ✅)</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 8px;">
                        <span style="color: #64748b; font-weight: 600;">Primary Deposit Account:</span>
                        <strong style="color: #0f172a;">HDFC Bank (A/C ...4819)</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748b; font-weight: 600;">Instant UPI VPA:</span>
                        <strong style="color: #0f172a;">suraj@okhdfcbank (Direct IMPS Enabled)</strong>
                    </div>
                </div>

                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <h5 style="color: #1e40af; font-weight: 700; margin-bottom: 4px;">Need to update your bank or payout information?</h5>
                    <p style="color: #3b82f6; font-size: 0.88rem; margin: 0;">For fraud prevention and security, bank detail modifications require 24h approval by the compliance team.</p>
                </div>

                <a href="{{ url('/my-payout') }}" class="btn btn-primary" style="background: #05B396; font-weight: 700; border: none;">Proceed to Withdrawal Portal ➔</a>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
