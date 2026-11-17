@extends('layouts.app')

@section('title', 'Live Webinars & Masterclasses — SkillLearner')

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
            <div class="portal-box-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 2.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <!-- Header -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
                    <div>
                        <h3 style="font-size: 1.6rem; color: #0f172a; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <span>📹 Live Webinars &amp; Masterclasses</span>
                        </h3>
                        <p style="color: #64748b; font-size: 0.95rem; margin: 0.35rem 0 0 0;">
                            Interactive live training sessions with industry mentors and top coaches. Join meetings directly and download posters to invite your leads!
                        </p>
                    </div>

                    @if(auth()->check() && (auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin'))
                        <a href="{{ route('admin.webinars') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; color: #1d4ed8; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 8px; text-decoration: none; border: 1.5px solid #bfdbfe; transition: background 0.15s ease;">
                            ⚙️ Manage Webinars (Admin)
                        </a>
                    @endif
                </div>

                @if($webinars->isEmpty())
                    <!-- Empty State: No webinar found! -->
                    <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 2px dashed #cbd5e1; margin-top: 1rem;">
                        <div style="width: 76px; height: 76px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2.2rem;">
                            📹
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                            No webinar scheduled right now!
                        </h3>
                        <p style="color: #64748b; font-size: 0.95rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Currently, there are no live webinars scheduled. Stay tuned to our community announcements for upcoming masterclasses and live Q&amp;A sessions.
                        </p>
                        <a href="{{ url('/dashboard') }}" style="background: #05B396; color: #ffffff; font-weight: 800; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Go to Dashboard</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <!-- Webinars Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(330px, 1fr)); gap: 1.8rem;">
                        @foreach($webinars as $webinar)
                            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 14px rgba(0,0,0,0.04);" 
                                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)';" 
                                 onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(0,0,0,0.04)';">
                                
                                <!-- Poster Container -->
                                <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #0f172a; overflow: hidden;">
                                    <img src="{{ $webinar->poster_image }}" alt="{{ $webinar->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                                    
                                    <!-- Badge -->
                                    @if($webinar->badge)
                                        <div style="position: absolute; top: 12px; left: 12px; background: rgba(220, 38, 38, 0.9); backdrop-filter: blur(8px); color: #ffffff; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px; text-transform: uppercase;">
                                            {{ $webinar->badge }}
                                        </div>
                                    @endif

                                    <!-- Platform Tag -->
                                    <div style="position: absolute; top: 12px; right: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); color: #ffffff; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2);">
                                        {{ $webinar->platform_name }}
                                    </div>
                                </div>

                                <!-- Body -->
                                <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                                    <!-- Date & Time Row -->
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.6rem; color: #0284c7; font-size: 0.82rem; font-weight: 800;">
                                        <span>📅 {{ $webinar->formatted_date }}</span>
                                        @if($webinar->webinar_time)
                                            <span>•</span>
                                            <span>⏰ {{ $webinar->webinar_time }}</span>
                                        @endif
                                    </div>

                                    <h4 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem 0; line-height: 1.35;">
                                        {{ $webinar->title }}
                                    </h4>

                                    <!-- Speaker Box -->
                                    @if($webinar->speaker)
                                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.65rem 0.9rem; margin-bottom: 0.9rem; display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 34px; height: 34px; border-radius: 50%; background: #0284c7; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800; flex-shrink: 0;">
                                                🎤
                                            </div>
                                            <div>
                                                <div style="font-size: 0.88rem; font-weight: 800; color: #0f172a;">{{ $webinar->speaker }}</div>
                                                @if($webinar->speaker_role)
                                                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">{{ $webinar->speaker_role }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($webinar->description)
                                        <p style="color: #475569; font-size: 0.84rem; line-height: 1.55; margin: 0 0 1.2rem 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $webinar->description }}
                                        </p>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px;">
                                        <!-- Meeting Link Button -->
                                        <a href="{{ $webinar->meeting_link }}" target="_blank" rel="noopener noreferrer" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; font-size: 0.92rem; font-weight: 800; padding: 0.8rem 1rem; border-radius: 10px; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(2, 132, 199, 0.3); transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                            <span>🚀</span>
                                            <span>Join Live Meeting</span>
                                            <span>➔</span>
                                        </a>

                                        <!-- Download Poster Button -->
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('portal.webinars.download', $webinar) }}" style="flex: 1; background: #f1f5f9; color: #334155; font-size: 0.84rem; font-weight: 700; padding: 0.65rem 0.8rem; border-radius: 8px; text-decoration: none; text-align: center; display: inline-flex; align-items: center; justify-content: center; gap: 6px; border: 1px solid #cbd5e1; transition: background 0.15s ease;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                <span>Download Poster</span>
                                            </a>

                                            <a href="{{ $webinar->poster_image }}" target="_blank" rel="noopener noreferrer" style="background: #f8fafc; color: #475569; font-size: 0.84rem; font-weight: 700; padding: 0.65rem 0.9rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0;" title="View Full Poster">
                                                <span>👁️</span>
                                            </a>
                                        </div>
                                    </div>
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
