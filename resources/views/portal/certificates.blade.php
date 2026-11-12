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
                            <div style="display: flex; gap: 8px; margin-top: 1.4rem;">
                                <button type="button" onclick="previewUserCert('{{ addslashes($cert['title']) }}', 'SL-CERT-{{ 1000 + $cert['id'] }}')" class="btn" style="flex: 1; font-size: 0.85rem; background: #05B396; color: #fff; font-weight: 700; border-radius: 8px; padding: 8px 12px; border: none; cursor: pointer; text-align: center;">
                                    👁️ View
                                </button>
                                <button type="button" onclick="alert('Downloading official Certificate PDF for {{ addslashes($cert['title']) }}...')" class="btn btn-secondary" style="flex: 1; font-size: 0.85rem; border: 1.5px solid #a7f3d0; color: #05B396; font-weight: 700; text-align: center; background: #f0fdfa; border-radius: 8px; padding: 8px 12px; cursor: pointer;">
                                    📥 PDF
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Certificate Preview Modal -->
<div id="userCertPreviewModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); z-index: 9999; backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 680px; width: 100%; box-shadow: 0 25px 60px rgba(0,0,0,0.35); border: 2px solid {{ \App\Models\Setting::get('cert_theme_color', '#05B396') }}; overflow: hidden; position: relative;">
        <!-- Header -->
        <div style="background: #0f172a; padding: 1.2rem 1.5rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 1.4rem;">🎖️</span>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #ffffff;">{{ \App\Models\Setting::get('cert_title', 'CERTIFICATE OF COMPLETION') }}</h3>
                    <div style="font-size: 0.76rem; color: #05B396; font-weight: 700;">{{ \App\Models\Setting::get('cert_subtitle', 'SkillLearner ISO 9001:2015 Accredited') }}</div>
                </div>
            </div>
            <button type="button" onclick="closeUserCertModal()" style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">&times;</button>
        </div>

        <!-- Certificate Body -->
        <div style="padding: 2.5rem 2rem; text-align: center; background: radial-gradient(circle, #f0fdf9 0%, #ffffff 80%);">
            <img src="{{ asset('images/logo.png') }}" alt="SkillLearner" style="max-height: 48px; margin-bottom: 1.2rem;" onerror="this.src='/images/logo.png';">
            
            <div style="font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: {{ \App\Models\Setting::get('cert_theme_color', '#05B396') }}; margin-bottom: 0.6rem;">
                {{ \App\Models\Setting::get('cert_title', 'CERTIFICATE OF COMPLETION') }}
            </div>

            <p style="font-size: 0.95rem; color: #64748b; margin-bottom: 0.8rem;">This is proudly presented to</p>

            <h2 style="font-size: 1.9rem; font-weight: 900; color: #0f172a; margin-bottom: 0.8rem; letter-spacing: -0.5px;">
                {{ session('user.name', 'Student Name') }}
            </h2>

            <p style="font-size: 0.9rem; color: #475569; max-width: 500px; margin: 0 auto 1.5rem; line-height: 1.6;">
                For successfully completing all modules, practical masterclass evaluations, and capstone submissions under
                <strong>{{ \App\Models\Setting::get('cert_organization', 'SkillLearner Edutech Private Limited') }}</strong> in
            </p>

            <div id="userModalCourseTitle" style="font-size: 1.3rem; font-weight: 800; color: {{ \App\Models\Setting::get('cert_theme_color', '#05B396') }}; margin-bottom: 1.8rem;"></div>

            <div style="display: flex; justify-content: space-around; border-top: 1px dashed #cbd5e1; padding-top: 1.2rem; font-size: 0.82rem; color: #64748b;">
                <div>
                    <div>Issue Date</div>
                    <strong style="color: #0f172a;">{{ now()->format('d M, Y') }}</strong>
                </div>
                <div>
                    <div>Credential ID</div>
                    <strong id="userModalCertId" style="font-family: monospace; color: #0f172a;"></strong>
                </div>
                <div>
                    <div>Signatory</div>
                    <strong style="color: #0f172a;">{{ \App\Models\Setting::get('cert_signatory_name', 'Adarsh Pandey') }}</strong>
                </div>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0;">
            <span style="font-size: 0.78rem; color: #64748b;">Verified by SkillLearner Security Registry</span>
            <button type="button" onclick="window.print()" class="btn" style="background: #05B396; color: #fff; font-weight: 800; font-size: 0.85rem; padding: 6px 16px; border-radius: 8px;">
                🖨️ Print Certificate
            </button>
        </div>
    </div>
</div>

<script>
    function previewUserCert(courseTitle, certId) {
        document.getElementById('userModalCourseTitle').innerText = courseTitle;
        document.getElementById('userModalCertId').innerText = certId;
        document.getElementById('userCertPreviewModal').style.display = 'flex';
    }
    function closeUserCertModal() {
        document.getElementById('userCertPreviewModal').style.display = 'none';
    }
</script>

@include('portal.styles')
@endsection
