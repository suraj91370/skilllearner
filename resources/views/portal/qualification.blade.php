@extends('layouts.app')

@section('title', 'Qualification Contests — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'qualification'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'qualification'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">🏖️ National &amp; Global Tour Qualifications</h3>
                    <p style="color: #64748b; font-size: 0.95rem;">Track your eligibility for fully sponsored luxury trips, trophy stages, and five-star networking retreats.</p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @foreach ($trips as $trip)
                        @php
                            $pct = min(100, round(($trip['achieved'] / $trip['target']) * 100, 1));
                        @endphp
                        <div style="border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; background: #ffffff;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.8rem;">
                                <div>
                                    <span style="font-size: 0.75rem; color: #05B396; font-weight: 800; text-transform: uppercase;">OFFICIAL CONTEST</span>
                                    <h4 style="font-size: 1.3rem; color: #0f172a; font-weight: 800; margin: 4px 0;">{{ $trip['title'] }}</h4>
                                    <p style="font-size: 0.88rem; color: #64748b; margin: 0;"><strong>Rewards:</strong> {{ $trip['rewards'] }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <span style="background: #f0fdfa; border: 1px solid #a7f3d0; color: #05B396; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 800;">
                                        {{ $trip['status'] }}
                                    </span>
                                    <div style="font-size: 0.78rem; color: #64748b; margin-top: 6px;">Deadline: {{ $trip['deadline'] }}</div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div style="margin: 1.2rem 0 0.8rem;">
                                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 6px;">
                                    <span style="color: #0f172a;">Achieved: ₹{{ number_format($trip['achieved']) }}</span>
                                    <span style="color: #05B396;">Target: ₹{{ number_format($trip['target']) }} ({{ $pct }}%)</span>
                                </div>
                                <div style="width: 100%; height: 12px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                                    <div style="width: {{ $pct }}%; height: 100%; background: linear-gradient(90deg, #05B396 0%, #048873 100%); border-radius: 10px; transition: width 0.5s ease;"></div>
                                </div>
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
