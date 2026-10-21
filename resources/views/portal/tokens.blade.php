@extends('layouts.app')

@section('title', 'Token Purchases — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'tokens'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'tokens'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">🪙 SkillLearner Token Store</h3>
                        <p style="color: #64748b; font-size: 0.95rem;">Tokens allow you to sponsor student enrollments, purchase ad credits, and unlock VIP training certificates.</p>
                    </div>
                    <div style="background: #f0fdfa; border: 1.5px solid #a7f3d0; border-radius: 12px; padding: 0.8rem 1.4rem; text-align: right;">
                        <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">YOUR TOKEN BALANCE</span>
                        <div style="font-size: 1.6rem; font-weight: 900; color: #05B396;">450 TOKENS</div>
                    </div>
                </div>

                <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 1.2rem;">Available Token Packs</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.4rem; margin-bottom: 2rem;">
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                        <span style="background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">STARTER</span>
                        <h4 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 8px 0 4px;">500 Tokens</h4>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #05B396; margin-bottom: 1rem;">₹499</div>
                        <ul style="color: #64748b; font-size: 0.85rem; line-height: 1.8; margin-bottom: 1.2rem; padding-left: 1.2rem;">
                            <li>5 Student Enrollment Vouchers</li>
                            <li>Instant activation</li>
                        </ul>
                        <button type="button" onclick="alert('Proceeding to buy 500 Tokens (₹499)...')" class="btn btn-secondary" style="width: 100%; border: 1px solid #a7f3d0; color: #05B396; font-weight: 700;">Purchase Pack</button>
                    </div>

                    <div style="border: 2px solid #05B396; border-radius: 14px; padding: 1.4rem; background: #f0fdfa; position: relative;">
                        <span style="background: #05B396; color: #ffffff; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 800;">MOST POPULAR</span>
                        <h4 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 8px 0 4px;">2,000 Tokens</h4>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #05B396; margin-bottom: 1rem;">₹1,799</div>
                        <ul style="color: #475569; font-size: 0.85rem; line-height: 1.8; margin-bottom: 1.2rem; padding-left: 1.2rem;">
                            <li>20 Student Enrollment Vouchers</li>
                            <li>Bonus 200 Ad Credits included</li>
                            <li>Dedicated Account Manager</li>
                        </ul>
                        <button type="button" onclick="alert('Proceeding to buy 2,000 Tokens (₹1,799)...')" class="btn btn-primary" style="width: 100%; background: #05B396; font-weight: 800;">Purchase Pack</button>
                    </div>

                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                        <span style="background: #fef3c7; color: #b45309; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 800;">AGENCY BUNDLE</span>
                        <h4 style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 8px 0 4px;">5,000 Tokens</h4>
                        <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">₹3,999</div>
                        <ul style="color: #64748b; font-size: 0.85rem; line-height: 1.8; margin-bottom: 1.2rem; padding-left: 1.2rem;">
                            <li>50 Student Enrollment Vouchers</li>
                            <li>Zero Platform Surcharge</li>
                            <li>Custom Team Branded Badges</li>
                        </ul>
                        <button type="button" onclick="alert('Proceeding to buy 5,000 Tokens (₹3,999)...')" class="btn btn-secondary" style="width: 100%; border: 1px solid #cbd5e1; color: #0f172a; font-weight: 700;">Purchase Pack</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
