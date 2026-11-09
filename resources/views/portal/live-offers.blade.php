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
                <div style="margin-bottom: 1.8rem;">
                    {{-- <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; display: flex; align-items: center; gap: 10px; margin: 0;">
                                <span>🎯 Live Offers &amp; Special Contests</span>
                            </h3>
                            <p style="color: #64748b; font-size: 0.95rem; margin-top: 4px;">Exclusive time-sensitive platform bonuses, sponsor cash rewards, and national trip contests.</p>
                        </div>
                    </div> --}}
                </div>

                @php
                    $offers = $offers ?? [];
                @endphp

                @if(empty($offers))
                    <!-- Empty State: No live offer found! -->
                    <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02); margin-top: 1rem;">
                        <div style="width: 72px; height: 72px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            🎯
                        </div>
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                            No live offer found!
                        </h3>
                        <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Currently, there are no active promotional offers or cash reward contests running. New exclusive bonus offers will be announced soon!
                        </p>
                        <a href="{{ url('/dashboard') }}" style="background: #05B396; color: #ffffff; font-weight: 700; padding: 9px 20px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Go to Dashboard</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <!-- Featured Banner -->
                    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 60%, #05B396 100%); border-radius: 18px; padding: 2.2rem; color: #ffffff; margin-bottom: 2.2rem; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(2, 132, 199, 0.25);">
                        <h2 style="font-size: 1.65rem; font-weight: 900; color: #ffffff; margin-bottom: 0.8rem;">
                            {{ $offers[0]['title'] ?? 'Special Offer' }}
                        </h2>
                        <p style="color: #e0f2fe; font-size: 0.98rem; line-height: 1.65; max-width: 680px; margin-bottom: 1.6rem;">
                            {{ $offers[0]['desc'] ?? '' }}
                        </p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection

