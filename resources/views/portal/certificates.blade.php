@extends('layouts.app')

@section('title', 'Certificates — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'certificates'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'certificates'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-box-card">
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">🎖️ Course Completion Certificates</h3>
                    <p style="color: #64748b; font-size: 0.95rem;">Verified ISO-certified credentials issued under your name: <strong>{{ session('user.name', 'Vansh Tandon') }}</strong></p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    @foreach (array_slice($courses, 0, 6) as $cert)
                        <div style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.5rem; background: #fafafa; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <span style="font-size: 0.72rem; color: #05B396; font-weight: 800; text-transform: uppercase;">VERIFIED CERTIFICATE</span>
                                    <span style="background: #ecfdf5; color: #059669; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">ISSUED ✅</span>
                                </div>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin: 4px 0 8px; font-weight: 800;">{{ $cert['title'] }}</h4>
                                <p style="font-size: 0.82rem; color: #64748b;">Issued on completion of all video lessons, quizzes, and practical projects.</p>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 6px;">Credential ID: SL-CERT-{{ 1000 + $cert['id'] }}</div>
                            </div>
                            <button type="button" onclick="alert('Downloading official Certificate PDF for {{ $cert['title'] }}...')" class="btn btn-secondary" style="margin-top: 1.4rem; font-size: 0.85rem; border: 1.5px solid #a7f3d0; color: #05B396; font-weight: 700; width: 100%; text-align: center; background: #f0fdfa;">
                                📥 Download Certificate (PDF)
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
