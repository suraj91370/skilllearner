@extends('layouts.app')

@section('title', 'Exclusive Live Offers — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'live-offers'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'live-offers'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <!-- Header -->
                <div style="margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                                <span>🎯 Live Offers &amp; Special Contests</span>
                            </h3>
                            <p style="color: #64748b; font-size: 0.95rem; margin-top: 4px;">Exclusive time-sensitive platform bonuses, sponsor cash rewards, and national trip contests.</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; background: #eff6ff; border: 1px solid #bfdbfe; padding: 6px 14px; border-radius: 20px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #2563eb; display: inline-block; box-shadow: 0 0 8px #2563eb;"></span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: #1d4ed8;">3 Offers Active Right Now</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Banner: Goa Trip / Mega Contest -->
                <div style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 60%, #05B396 100%); border-radius: 18px; padding: 2.2rem; color: #ffffff; margin-bottom: 2.2rem; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(2, 132, 199, 0.25);">
                    <div style="position: absolute; right: -25px; bottom: -25px; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%); pointer-events: none;"></div>

                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                        <span style="background: #fbbf24; color: #78350f; font-size: 0.74rem; font-weight: 900; padding: 3px 10px; border-radius: 6px; letter-spacing: 0.5px;">🏆 NATIONAL TRIP CONTEST</span>
                        <span style="background: rgba(255,255,255,0.2); color: #ffffff; font-size: 0.74rem; font-weight: 700; padding: 3px 10px; border-radius: 6px;">VALID THIS MONTH</span>
                    </div>

                    <h2 style="font-size: 1.65rem; font-weight: 900; color: #ffffff; margin-bottom: 0.8rem; line-height: 1.3;">
                        🌴 3 Nights &amp; 4 Days All-Expenses-Paid Goa Conclave 2026
                    </h2>

                    <p style="color: #e0f2fe; font-size: 0.98rem; line-height: 1.65; max-width: 680px; margin-bottom: 1.6rem;">
                        Qualify for 5-Star luxury resort stay, flight tickets covered, private yacht party, and live awards night alongside India’s top digital creators &amp; community founders!
                    </p>

                    <div style="background: rgba(0, 0, 0, 0.22); border-radius: 14px; padding: 1.2rem; max-width: 580px; margin-bottom: 1.6rem; border: 1px solid rgba(255,255,255,0.15);">
                        <div style="display: flex; justify-content: space-between; font-size: 0.86rem; font-weight: 700; margin-bottom: 6px;">
                            <span>Contest Qualification Target</span>
                            <span style="color: #fde047;">25 Active Referrals or ₹50,000 Earnings</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.25); height: 8px; border-radius: 10px; overflow: hidden;">
                            <div style="background: #fde047; height: 100%; width: 0%; border-radius: 10px; transition: width 0.4s ease;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; opacity: 0.85; margin-top: 6px;">
                            <span>Current Progress: 0 Referrals</span>
                            <span>Ends 30 Nov 2026</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ url('/qualification') }}" class="btn" style="background: #ffffff; color: #0284c7; font-weight: 800; font-size: 0.92rem; padding: 0.75rem 1.8rem; border-radius: 10px; text-decoration: none;">
                            View Leaderboard &amp; Rules ➔
                        </a>
                        <a href="{{ url('/plans') }}" class="btn" style="background: rgba(255,255,255,0.15); color: #ffffff; border: 1px solid rgba(255,255,255,0.4); font-weight: 700; font-size: 0.92rem; padding: 0.75rem 1.6rem; border-radius: 10px; text-decoration: none;">
                            Upgrade To Boost Earnings
                        </a>
                    </div>
                </div>

                <!-- 2. More Live Offers Grid -->
                <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.2rem;">Limited-Time Platform Offers</h4>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.4rem;">
                    <!-- Offer Card 1 -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.5rem; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                        <span style="position: absolute; top: 1.2rem; right: 1.2rem; background: #fef3c7; color: #92400e; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 6px;">48 HOURS LEFT</span>
                        <div>
                            <div style="font-size: 1.8rem; margin-bottom: 8px;">💎</div>
                            <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Infinity Package Upgrade Bonanza</h4>
                            <p style="font-size: 0.88rem; color: #64748b; line-height: 1.55; margin-bottom: 1rem;">
                                Upgrade to Infinity Package today and pay only the difference amount! Instantly unlock maximum Tier-1 (₹8,000) and Tier-2 (₹2,000) commissions.
                            </p>
                        </div>
                        <a href="{{ url('/plans') }}" class="btn btn-primary" style="background: #05B396; text-align: center; justify-content: center; font-size: 0.88rem; font-weight: 700; padding: 0.7rem;">
                            Claim Upgrade Offer
                        </a>
                    </div>

                    <!-- Offer Card 2 -->
                    <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.5rem; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                        <span style="position: absolute; top: 1.2rem; right: 1.2rem; background: #ecfdf5; color: #065f46; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 6px;">WEEKEND SPECIAL</span>
                        <div>
                            <div style="font-size: 1.8rem; margin-bottom: 8px;">⚡</div>
                            <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">2-Sale Cash Booster: Extra ₹1,000</h4>
                            <p style="font-size: 0.88rem; color: #64748b; line-height: 1.55; margin-bottom: 1rem;">
                                Close 2 direct admissions for Advance Package or above before Sunday midnight and get an instant ₹1,000 extra cash booster added to your wallet!
                            </p>
                        </div>
                        <a href="{{ url('/affiliate-link') }}" class="btn btn-secondary" style="border-color: #cbd5e1; color: #1e293b; text-align: center; justify-content: center; font-size: 0.88rem; font-weight: 700; padding: 0.7rem;">
                            Copy Affiliate Link &amp; Share
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection

