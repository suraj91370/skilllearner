@extends('layouts.app')

@section('title', 'Affiliate Training — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'training'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'training'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                {{-- <div style="margin-bottom: 1.8rem;">
                    <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; margin: 0 0 4px;">🎓 Elite Affiliate Training Center</h3>
                    <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Step-by-step masterclasses designed to take your affiliate revenue from zero to ₹50,000+ per month.</p>
                </div> --}}

                @php
                    $modules = $modules ?? [];
                @endphp

                @if(empty($modules))
                    <!-- Empty State: No training found! -->
                    <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02); margin-top: 1rem;">
                        <div style="width: 72px; height: 72px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            🎓
                        </div>
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                            No training found!
                        </h3>
                        <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Currently, there are no affiliate training modules or video masterclasses uploaded. Training sessions will be unlocked here soon.
                        </p>
                        <a href="{{ url('/dashboard') }}" style="background: #05B396; color: #ffffff; font-weight: 700; padding: 9px 20px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Go to Dashboard</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                        @foreach ($modules as $m)
                            <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.2rem;">
                                <div style="flex: 1; min-width: 280px;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                        <span style="font-size: 0.75rem; font-weight: 800; color: #05B396; letter-spacing: 0.5px;">{{ $m['step'] ?? '' }}</span>
                                        <span style="background: {{ $m['badge_bg'] ?? '#f1f5f9' }}; color: {{ $m['badge_color'] ?? '#64748b' }}; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">{{ $m['badge'] ?? '' }}</span>
                                    </div>
                                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $m['title'] ?? '' }}</h4>
                                    <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 8px;">{{ $m['desc'] ?? '' }}</p>
                                    <span style="font-size: 0.78rem; color: #94a3b8; font-weight: 600;">{{ $m['lessons'] ?? '' }}</span>
                                </div>
                                <div>
                                    <a href="{{ url('/classroom') }}" class="btn btn-primary" style="background: #05B396; font-size: 0.85rem; padding: 0.6rem 1.4rem; font-weight: 700; white-space: nowrap;">{{ $m['action'] ?? 'Start' }} ➔</a>
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
