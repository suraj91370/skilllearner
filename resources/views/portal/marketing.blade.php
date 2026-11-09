@extends('layouts.app')

@section('title', 'Marketing Tool — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'marketing'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'marketing'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                {{-- <div style="margin-bottom: 1.8rem;">
                    <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800; margin: 0 0 4px;">🎨 Official Affiliate Marketing Kit</h3>
                    <p style="color: #64748b; font-size: 0.95rem; margin: 0;">Download ready-made high-converting graphics, reels templates, WhatsApp status swipes, and sales flyers.</p>
                </div> --}}

                @php
                    $tools = $tools ?? [];
                @endphp

                @if(empty($tools))
                    <!-- Empty State: No marketing tools found! -->
                    <div style="text-align: center; padding: 4.5rem 1.5rem; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.02); margin-top: 1rem;">
                        <div style="width: 72px; height: 72px; margin: 0 auto 1.2rem; border-radius: 50%; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            🎨
                        </div>
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem;">
                            No marketing tools found!
                        </h3>
                        <p style="color: #64748b; font-size: 0.92rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Currently, there are no promotional marketing tools or design assets available for download. Promotional assets will be added here soon.
                        </p>
                        <a href="{{ url('/dashboard') }}" style="background: #05B396; color: #ffffff; font-weight: 700; padding: 9px 20px; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Go to Dashboard</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                        @foreach ($tools as $tool)
                            <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff;">
                                <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">{{ $tool['category'] ?? 'ASSET' }}</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin: 6px 0 8px; font-weight: 800;">{{ $tool['title'] ?? '' }}</h4>
                                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.2rem;">{{ $tool['desc'] ?? '' }}</p>
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
