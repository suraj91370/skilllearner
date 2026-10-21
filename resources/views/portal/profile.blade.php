@extends('layouts.app')

@section('title', 'My Profile — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'profile'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'profile'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card" style="max-width: 820px;">
                <div style="display: flex; gap: 1.5rem; align-items: center; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 1.5rem; flex-wrap: wrap;">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80" alt="{{ session('user.name', 'Vansh Tandon') }}" style="width: 84px; height: 84px; border-radius: 50%; border: 3px solid #05B396; object-fit: cover;">
                    <div>
                        <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">{{ session('user.name', 'Vansh Tandon') }}</h3>
                        <p style="color: #64748b; font-size: 0.92rem;">Student Affiliate ID: <strong>{{ session('user.affiliate_id', 'SL-8821') }}</strong></p>
                        <span style="display: inline-block; background: #ecfdf5; color: #059669; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; margin-top: 6px;">KYC Verified Member ✅</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.4rem;">
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Full Name</label>
                        <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px; border: 1px solid #e2e8f0;">{{ session('user.name', 'Vansh Tandon') }}</div>
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Email Address</label>
                        <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px; border: 1px solid #e2e8f0;">{{ session('user.email', 'vansh@skillearner.com') }}</div>
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Mobile Number</label>
                        <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px; border: 1px solid #e2e8f0;">{{ session('user.phone', '+91 98765 43210') }}</div>
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Active Package</label>
                        <div style="padding: 0.75rem 1rem; background: #f0fdfa; border-radius: 8px; font-weight: 700; color: #05B396; margin-top: 4px; border: 1px solid #a7f3d0;">{{ session('user.active_package', 'Advance Package') }}</div>
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Sponsor / Mentor</label>
                        <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #0f172a; margin-top: 4px; border: 1px solid #e2e8f0;">{{ session('user.sponsor_id', 'SL-ADMIN') }} (Official SkillLearner Mentor)</div>
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Account Security</label>
                        <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; font-weight: 600; color: #10b981; margin-top: 4px; border: 1px solid #e2e8f0;">2-Factor OTP &amp; Password Active 🔒</div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="{{ url('/plans') }}" class="btn btn-primary" style="background: #05B396; font-weight: 700;">🚀 Upgrade Your Package</a>
                    <a href="{{ url('/my-payout') }}" class="btn btn-secondary" style="border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700;">View Payout Accounts</a>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
