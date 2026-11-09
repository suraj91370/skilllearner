@extends('layouts.app')

@section('title', 'Live Webinars & Workshops — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'webinars'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'webinars'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <!-- Header -->
                <div style="margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                                <span>📹 Live Webinars &amp; Masterclasses</span>
                            </h3>
                            <p style="color: #64748b; font-size: 0.95rem; margin-top: 4px;">Join live interactive training sessions with top industry experts and 6-figure mentors.</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 6px 14px; border-radius: 20px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block; box-shadow: 0 0 8px #10b981;"></span>
                            <span style="font-size: 0.8rem; font-weight: 700; color: #047857;">Live Weekly Schedule</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Next Live Webinar Card -->
                <div style="background: linear-gradient(135deg, #070d1e 0%, #0f172a 55%, #064e3b 100%); border-radius: 18px; padding: 2rem; color: #ffffff; margin-bottom: 2.2rem; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                    <div style="position: absolute; right: -20px; bottom: -20px; width: 180px; height: 180px; background: radial-gradient(circle, rgba(5, 179, 150, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                        <span style="background: #ef4444; color: #ffffff; font-size: 0.72rem; font-weight: 800; padding: 3px 10px; border-radius: 6px; letter-spacing: 0.5px; text-transform: uppercase;">● UPCOMING TODAY</span>
                        <span style="color: #94a3b8; font-size: 0.84rem; font-weight: 600;">8:00 PM IST • Zoom Live</span>
                    </div>

                    <h2 style="font-size: 1.55rem; font-weight: 800; color: #ffffff; margin-bottom: 0.8rem; line-height: 1.35;">
                        ₹1 Lakh/Month Fast-Track: WhatsApp DM Closing &amp; Objection Handling
                    </h2>
                    
                    <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; max-width: 680px; margin-bottom: 1.5rem;">
                        Live interactive workshop breakdown: How to convert warm and cold leads on WhatsApp without begging, top audio-note scripts, and psychological closing frameworks.
                    </p>

                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.2rem;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Host" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #05B396;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.92rem; color: #ffffff;">Suraj Pal &amp; Senior Mentors</div>
                                <div style="font-size: 0.78rem; color: #05B396; font-weight: 600;">Founders &amp; Elite Growth Team</div>
                            </div>
                        </div>
                        <a href="https://zoom.us" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="background: #05B396; font-size: 0.92rem; font-weight: 700; padding: 0.75rem 1.8rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                            <span>Join Zoom Webinar</span>
                        </a>
                    </div>
                </div>

                <!-- Upcoming Webinars List -->
                <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.2rem;">Upcoming Live Sessions This Week</h4>

                @php
                    $webinars = [
                        [
                            'date' => 'Wednesday • 11 Nov',
                            'time' => '7:30 PM IST',
                            'title' => 'Instagram Organic Reach: 3-Second Hook Video Mastery',
                            'desc' => 'Generate 50,000+ views on Instagram Reels organically without paid ads or prior video editing experience.',
                            'speaker' => 'Digital Content Specialist',
                            'status' => 'REGISTERED ✅',
                            'status_bg' => '#ecfdf5',
                            'status_color' => '#059669',
                            'btn' => 'Link Active at 7:00 PM'
                        ],
                        [
                            'date' => 'Friday • 13 Nov',
                            'time' => '8:00 PM IST',
                            'title' => 'Paid Meta Ads Bootcamp: ₹10/Lead Setup Step-by-Step',
                            'desc' => 'Complete walkthrough of setting up lead-generation campaigns on Facebook & Instagram Ads with zero wastage.',
                            'speaker' => 'Performance Marketing Coach',
                            'status' => 'OPEN FOR ALL 🎟️',
                            'status_bg' => '#f0fdfa',
                            'status_color' => '#05B396',
                            'btn' => 'Reserve Seat'
                        ],
                        [
                            'date' => 'Sunday • 15 Nov',
                            'time' => '11:00 AM IST',
                            'title' => 'Weekly Leaderboard Recognition & Doubts Clinic',
                            'desc' => 'Live Q&A session with top earners answering questions directly on voice and screen share.',
                            'speaker' => 'SkillLearner Advisory Board',
                            'status' => 'WEEKLY SPECIAL ⭐',
                            'status_bg' => '#faf5ff',
                            'status_color' => '#7c3aed',
                            'btn' => 'Set Reminder'
                        ]
                    ];
                @endphp

                <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                    @foreach ($webinars as $w)
                        <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.2rem; transition: border-color 0.2s ease;">
                            <div style="flex: 1; min-width: 280px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
                                    <span style="font-size: 0.8rem; font-weight: 800; color: #05B396;">{{ $w['date'] }}</span>
                                    <span style="color: #94a3b8; font-size: 0.78rem;">•</span>
                                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">{{ $w['time'] }}</span>
                                    <span style="background: {{ $w['status_bg'] }}; color: {{ $w['status_color'] }}; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">{{ $w['status'] }}</span>
                                </div>
                                <h4 style="font-size: 1.12rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $w['title'] }}</h4>
                                <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 8px;">{{ $w['desc'] }}</p>
                                <span style="font-size: 0.78rem; color: #94a3b8; font-weight: 600;">Hosted by: <strong style="color: #334155;">{{ $w['speaker'] }}</strong></span>
                            </div>
                            <div>
                                <button type="button" onclick="alert('You will receive Zoom invite notification 30 minutes before live time!')" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.65rem 1.4rem; font-weight: 700; white-space: nowrap; border-color: #cbd5e1; color: #1e293b;">
                                    {{ $w['btn'] }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection

