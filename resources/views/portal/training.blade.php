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
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">🎓 Elite Affiliate Training Center</h3>
                    <p style="color: #64748b; font-size: 0.95rem;">Step-by-step masterclasses designed to take your affiliate revenue from zero to ₹50,000+ per month.</p>
                </div>

                @php
                    $modules = [
                        [
                            'step' => 'MODULE 01',
                            'title' => 'The 7-Day Fast-Track Affiliate Blueprint',
                            'lessons' => '6 Lessons • 1h 45m',
                            'desc' => 'How to set up your profile, create a high-converting Instagram bio, and make your first ₹10,000 within your first week.',
                            'badge' => 'COMPLETED ✅',
                            'badge_bg' => '#ecfdf5',
                            'badge_color' => '#059669',
                            'action' => 'Rewatch Module'
                        ],
                        [
                            'step' => 'MODULE 02',
                            'title' => 'Viral Short Reels & Hook Creation Formula',
                            'lessons' => '8 Lessons • 2h 15m',
                            'desc' => 'Copy-paste 3-second hook scripts that generate 50,000+ views organically without revealing your face or spending money.',
                            'badge' => 'IN PROGRESS ⏳',
                            'badge_bg' => '#f0fdfa',
                            'badge_color' => '#05B396',
                            'action' => 'Continue Learning'
                        ],
                        [
                            'step' => 'MODULE 03',
                            'title' => 'WhatsApp DM Closing Masterclass (1-in-3 Conversions)',
                            'lessons' => '7 Lessons • 2h 00m',
                            'desc' => 'Exactly what to say when a lead asks "What is the work?" — closing scripts, audio notes, and psychological trust building.',
                            'badge' => 'UP NEXT 🔒',
                            'badge_bg' => '#f1f5f9',
                            'badge_color' => '#64748b',
                            'action' => 'Start Module'
                        ],
                        [
                            'step' => 'MODULE 04',
                            'title' => 'Overcoming Top Indian Objections ("Paisa Nahi Hai")',
                            'lessons' => '5 Lessons • 1h 30m',
                            'desc' => 'Master the framework to handle common hesitations: "I don\'t have money", "I need to ask my parents", "Is this real?".',
                            'badge' => 'UP NEXT 🔒',
                            'badge_bg' => '#f1f5f9',
                            'badge_color' => '#64748b',
                            'action' => 'Start Module'
                        ]
                    ];
                @endphp

                <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                    @foreach ($modules as $m)
                        <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; background: #ffffff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.2rem;">
                            <div style="flex: 1; min-width: 280px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                    <span style="font-size: 0.75rem; font-weight: 800; color: #05B396; letter-spacing: 0.5px;">{{ $m['step'] }}</span>
                                    <span style="background: {{ $m['badge_bg'] }}; color: {{ $m['badge_color'] }}; padding: 2px 8px; border-radius: 4px; font-size: 0.72rem; font-weight: 700;">{{ $m['badge'] }}</span>
                                </div>
                                <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $m['title'] }}</h4>
                                <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 8px;">{{ $m['desc'] }}</p>
                                <span style="font-size: 0.78rem; color: #94a3b8; font-weight: 600;">{{ $m['lessons'] }}</span>
                            </div>
                            <div>
                                <a href="{{ url('/classroom') }}" class="btn btn-primary" style="background: #05B396; font-size: 0.85rem; padding: 0.6rem 1.4rem; font-weight: 700; white-space: nowrap;">{{ $m['action'] }} ➔</a>
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
