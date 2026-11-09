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
                <div style="margin-bottom: 1.8rem;">
                    {{-- <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 10px; margin: 0;">
                                <span>📹 Live Webinars &amp; Masterclasses</span>
                            </h3>
                            <p style="color: #64748b; font-size: 0.95rem; margin-top: 4px;">Join live interactive training sessions with top industry experts and 6-figure mentors.</p>
                        </div>
                    </div> --}}
                </div>

                @php
                    $webinars = $webinars ?? [];
                @endphp

                @if(empty($webinars))
                    <!-- Empty State: No webinar found! -->
                    <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02); margin-top: 1rem;">
                        <div style="width: 72px; height: 72px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            📹
                        </div>
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                            No webinar found!
                        </h3>
                        <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Currently, there are no live webinars scheduled. Stay tuned to our community announcements for upcoming masterclasses and live Q&amp;A sessions.
                        </p>
                        <a href="{{ url('/dashboard') }}" style="background: #05B396; color: #ffffff; font-weight: 700; padding: 9px 20px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Go to Dashboard</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <!-- Featured Next Live Webinar Card -->
                    <div style="background: linear-gradient(135deg, #070d1e 0%, #0f172a 55%, #064e3b 100%); border-radius: 18px; padding: 2rem; color: #ffffff; margin-bottom: 2.2rem; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                        <div style="position: absolute; right: -20px; bottom: -20px; width: 180px; height: 180px; background: radial-gradient(circle, rgba(5, 179, 150, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                        
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                            <span style="background: #ef4444; color: #ffffff; font-size: 0.72rem; font-weight: 800; padding: 3px 10px; border-radius: 6px; letter-spacing: 0.5px; text-transform: uppercase;">● UPCOMING TODAY</span>
                            <span style="color: #94a3b8; font-size: 0.84rem; font-weight: 600;">8:00 PM IST • Zoom Live</span>
                        </div>

                        <h2 style="font-size: 1.55rem; font-weight: 800; color: #ffffff; margin-bottom: 0.8rem; line-height: 1.35;">
                            {{ $webinars[0]['title'] ?? 'Live Masterclass' }}
                        </h2>
                        
                        <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; max-width: 680px; margin-bottom: 1.5rem;">
                            {{ $webinars[0]['desc'] ?? '' }}
                        </p>

                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.2rem;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div>
                                    <div style="font-weight: 700; font-size: 0.92rem; color: #ffffff;">{{ $webinars[0]['speaker'] ?? 'Senior Mentors' }}</div>
                                    <div style="font-size: 0.78rem; color: #05B396; font-weight: 600;">SkillLearner Elite Growth Team</div>
                                </div>
                            </div>
                            <a href="https://zoom.us" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="background: #05B396; font-size: 0.92rem; font-weight: 700; padding: 0.75rem 1.8rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                <span>Join Zoom Webinar</span>
                            </a>
                        </div>
                    </div>

                    <!-- Upcoming Webinars List -->
                    <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.2rem;">Upcoming Live Sessions</h4>

                    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                        @foreach ($webinars as $w)
                            <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.2rem;">
                                <div style="flex: 1; min-width: 280px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
                                        <span style="font-size: 0.8rem; font-weight: 800; color: #05B396;">{{ $w['date'] }}</span>
                                        <span style="color: #94a3b8; font-size: 0.78rem;">•</span>
                                        <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">{{ $w['time'] }}</span>
                                    </div>
                                    <h4 style="font-size: 1.12rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $w['title'] }}</h4>
                                    <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 8px;">{{ $w['desc'] }}</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.65rem 1.4rem; font-weight: 700; white-space: nowrap; border-color: #cbd5e1; color: #1e293b;">
                                        Reserve Seat
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection

