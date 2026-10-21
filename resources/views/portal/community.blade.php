@extends('layouts.app')

@section('title', 'Social Community — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'community'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'community'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; margin-bottom: 0.5rem;">🌐 Official Mentorship Communities</h3>
                <p style="color: #64748b; margin-bottom: 2rem; font-size: 0.95rem;">Join daily live Q&amp;A sessions, access proven closing scripts, and connect with over 15,000+ top creator affiliates across India.</p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    <!-- VIP WhatsApp Mastermind -->
                    <div style="padding: 1.6rem; border-radius: 14px; background: #f0fdf4; border: 1.5px solid #bbf7d0;">
                        <div style="font-size: 2rem; margin-bottom: 0.8rem;">💬</div>
                        <h4 style="color: #166534; font-weight: 800; font-size: 1.15rem;">VIP WhatsApp Mastermind</h4>
                        <p style="font-size: 0.88rem; color: #15803d; margin: 8px 0 16px;">Direct daily lead-closing scripts, audio notes, and instant support from senior trainers.</p>
                        <a href="https://chat.whatsapp.com" target="_blank" class="btn btn-primary" style="background: #16a34a; font-size: 0.88rem; padding: 0.6rem 1.2rem; font-weight: 700; width: 100%; text-align: center; display: block; border: none;">Join WhatsApp Group ➔</a>
                    </div>

                    <!-- Telegram Broadcast Channel -->
                    <div style="padding: 1.6rem; border-radius: 14px; background: #f0f9ff; border: 1.5px solid #bae6fd;">
                        <div style="font-size: 2rem; margin-bottom: 0.8rem;">📢</div>
                        <h4 style="color: #0369a1; font-weight: 800; font-size: 1.15rem;">Telegram Broadcast Channel</h4>
                        <p style="font-size: 0.88rem; color: #0284c7; margin: 8px 0 16px;">Weekly Sunday mastermind zoom links, top earner leaderboards, and system payout updates.</p>
                        <a href="https://t.me" target="_blank" class="btn btn-primary" style="background: #0284c7; font-size: 0.88rem; padding: 0.6rem 1.2rem; font-weight: 700; width: 100%; text-align: center; display: block; border: none;">Join Telegram Channel ➔</a>
                    </div>

                    <!-- YouTube Training Hub -->
                    <div style="padding: 1.6rem; border-radius: 14px; background: #fef2f2; border: 1.5px solid #fecaca;">
                        <div style="font-size: 2rem; margin-bottom: 0.8rem;">🎥</div>
                        <h4 style="color: #991b1b; font-weight: 800; font-size: 1.15rem;">YouTube Masterclass Hub</h4>
                        <p style="font-size: 0.88rem; color: #b91c1c; margin: 8px 0 16px;">Watch recorded sessions, expert interviews, and case studies of students earning ₹1L+/month.</p>
                        <a href="https://youtube.com" target="_blank" class="btn btn-primary" style="background: #dc2626; font-size: 0.88rem; padding: 0.6rem 1.2rem; font-weight: 700; width: 100%; text-align: center; display: block; border: none;">Subscribe on YouTube ➔</a>
                    </div>

                    <!-- Instagram Creators Network -->
                    <div style="padding: 1.6rem; border-radius: 14px; background: #fdf2f8; border: 1.5px solid #fbcfe8;">
                        <div style="font-size: 2rem; margin-bottom: 0.8rem;">📸</div>
                        <h4 style="color: #9d174d; font-weight: 800; font-size: 1.15rem;">Instagram Creator Network</h4>
                        <p style="font-size: 0.88rem; color: #be185d; margin: 8px 0 16px;">Tag @skilllearner_official in your success stories and get featured to our 100K+ audience.</p>
                        <a href="https://instagram.com" target="_blank" class="btn btn-primary" style="background: #db2777; font-size: 0.88rem; padding: 0.6rem 1.2rem; font-weight: 700; width: 100%; text-align: center; display: block; border: none;">Follow on Instagram ➔</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
