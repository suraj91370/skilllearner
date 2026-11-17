@extends('layouts.app')

@section('title', 'Exclusive Live Offers & Contests — SkillLearner')

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
            <div class="portal-box-card" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 2.2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <!-- Header -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
                    <div>
                        <h3 style="font-size: 1.6rem; color: #0f172a; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 10px;">
                            <span>🎯 Exclusive Live Offers &amp; Special Contests</span>
                        </h3>
                        <p style="color: #64748b; font-size: 0.95rem; margin: 0.35rem 0 0 0;">
                            Time-sensitive milestone bonuses, national trip contests, and cash rewards. Download promotional posters to share with your audience!
                        </p>
                    </div>

                    @if(auth()->check() && (auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin'))
                        <a href="{{ route('admin.live-offers') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; color: #166534; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 8px; text-decoration: none; border: 1.5px solid #bbf7d0; transition: background 0.15s ease;">
                            ⚙️ Manage Live Offers (Admin)
                        </a>
                    @endif
                </div>

                @if($offers->isEmpty())
                    <!-- Empty State: No live offer found! -->
                    <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 2px dashed #cbd5e1; margin-top: 1rem;">
                        <div style="width: 76px; height: 76px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2.2rem;">
                            🎯
                        </div>
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                            No live offer found!
                        </h3>
                        <p style="color: #64748b; font-size: 0.95rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Currently, there are no active promotional offers or cash reward contests running. New exclusive bonus offers will be announced soon!
                        </p>
                        <a href="{{ url('/dashboard') }}" style="background: #05B396; color: #ffffff; font-weight: 800; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Go to Dashboard</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <!-- Offers Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.8rem;">
                        @foreach($offers as $offer)
                            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 14px rgba(0,0,0,0.04);" 
                                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)';" 
                                 onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(0,0,0,0.04)';">
                                
                                <!-- Poster Container -->
                                <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #0f172a; overflow: hidden;">
                                    <img src="{{ $offer->poster_image }}" alt="{{ $offer->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                                    
                                    <!-- Badge -->
                                    @if($offer->badge)
                                        <div style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); color: #38bdf8; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px; border: 1px solid rgba(56, 189, 248, 0.4); text-transform: uppercase;">
                                            {{ $offer->badge }}
                                        </div>
                                    @endif

                                    <!-- Validity / Remaining Time Tag -->
                                    @if($offer->days_remaining !== null)
                                        <div style="position: absolute; top: 12px; right: 12px; background: rgba(220, 38, 38, 0.9); backdrop-filter: blur(8px); color: #ffffff; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px;">
                                            ⏳ {{ $offer->days_remaining > 0 ? $offer->days_remaining . ' Days Left' : 'Ending Today' }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Body -->
                                <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                                    <h4 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem 0; line-height: 1.35;">
                                        {{ $offer->title }}
                                    </h4>

                                    @if($offer->subtitle)
                                        <p style="color: #64748b; font-size: 0.88rem; margin: 0 0 1rem 0; line-height: 1.45;">
                                            {{ $offer->subtitle }}
                                        </p>
                                    @endif

                                    <!-- Prize Box -->
                                    @if($offer->prize)
                                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 0.75rem 0.9rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
                                            <span style="font-size: 1.1rem;">🎁</span>
                                            <div style="font-size: 0.84rem; color: #166534; font-weight: 700;">
                                                <span style="color: #15803d; font-weight: 800;">Reward:</span> {{ $offer->prize }}
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Target Criteria Box -->
                                    @if($offer->target_criteria)
                                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 0.75rem 0.9rem; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px;">
                                            <span style="font-size: 1.1rem;">🎯</span>
                                            <div style="font-size: 0.84rem; color: #1e40af; font-weight: 700;">
                                                <span style="color: #1d4ed8; font-weight: 800;">Target:</span> {{ $offer->target_criteria }}
                                            </div>
                                        </div>
                                    @endif

                                    @if($offer->description)
                                        <p style="color: #475569; font-size: 0.84rem; line-height: 1.55; margin: 0 0 1.2rem 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $offer->description }}
                                        </p>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; gap: 10px;">
                                        <a href="{{ route('portal.live-offers.download', $offer) }}" style="flex: 1; background: #05B396; color: #ffffff; font-size: 0.88rem; font-weight: 800; padding: 0.75rem 1rem; border-radius: 10px; text-decoration: none; text-align: center; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.25); transition: background 0.15s ease;" onmouseover="this.style.background='#04967d'" onmouseout="this.style.background='#05B396'">
                                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                            <span>Download Poster</span>
                                        </a>

                                        <a href="{{ $offer->poster_image }}" target="_blank" rel="noopener noreferrer" style="background: #f1f5f9; color: #334155; font-size: 0.88rem; font-weight: 700; padding: 0.75rem 1rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #cbd5e1;" title="View Full Poster">
                                            <span>👁️</span>
                                        </a>
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
