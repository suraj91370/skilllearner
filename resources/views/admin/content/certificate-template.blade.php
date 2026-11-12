@extends('layouts.app')

@section('title', 'Certificate Template Designer — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-content-certificate'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-content-certificate'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        🎖️ Official Certificate Template Designer
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Design the verifiable course completion certificate issued to students upon 100% video milestone completion.
                    </p>
                </div>
            </div>

            <!-- Content Management Tabs Navigation -->
            @include('admin.content.tabs', ['tab' => 'certificate'])

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.content.certificate.update') }}">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="admin-two-col-grid">
                    
                    <!-- Left Column: Template Form -->
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9;">
                            <span style="font-size: 1.3rem;">🎨</span>
                            <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Certificate Design Parameters</h3>
                        </div>

                        <!-- Certificate Title & Subtitle -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Certificate Title *
                            </label>
                            <input type="text" name="cert_title" id="inpCertTitle" value="{{ old('cert_title', $template['cert_title']) }}" required oninput="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 800; outline: none;">
                        </div>

                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Subtitle / Accreditation Tag *
                            </label>
                            <input type="text" name="cert_subtitle" id="inpCertSubtitle" value="{{ old('cert_subtitle', $template['cert_subtitle']) }}" required oninput="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                        </div>

                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Issuing Organization Legal Name *
                            </label>
                            <input type="text" name="cert_organization" id="inpCertOrg" value="{{ old('cert_organization', $template['cert_organization']) }}" required oninput="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none;">
                        </div>

                        <!-- Signatory Details -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1.2rem;">
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Signatory Name *</label>
                                <input type="text" name="cert_signatory_name" id="inpSignatoryName" value="{{ old('cert_signatory_name', $template['cert_signatory_name']) }}" required oninput="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; font-weight: 700; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Signatory Title *</label>
                                <input type="text" name="cert_signatory_title" id="inpSignatoryTitle" value="{{ old('cert_signatory_title', $template['cert_signatory_title']) }}" required oninput="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none;">
                            </div>
                        </div>

                        <!-- Border & Theme Colors -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1.2rem;">
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Accent Theme Color</label>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <input type="color" name="cert_theme_color" id="inpThemeColor" value="{{ old('cert_theme_color', $template['cert_theme_color']) }}" onchange="updateLiveCertPreview()" style="width: 44px; height: 38px; padding: 2px; border: 1.5px solid #cbd5e1; border-radius: 6px; cursor: pointer;">
                                    <span style="font-size: 0.82rem; color: #64748b; font-family: monospace;">Pick brand color</span>
                                </div>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Border Style</label>
                                <select name="cert_border_style" id="inpBorderStyle" onchange="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none; background: #fff;">
                                    <option value="gold_double" {{ $template['cert_border_style'] === 'gold_double' ? 'selected' : '' }}>🏆 Luxury Gold Double</option>
                                    <option value="emerald_modern" {{ $template['cert_border_style'] === 'emerald_modern' ? 'selected' : '' }}>🌿 Emerald Modern Tech</option>
                                    <option value="royal_purple" {{ $template['cert_border_style'] === 'royal_purple' ? 'selected' : '' }}>👑 Royal Purple &amp; Silver</option>
                                </select>
                            </div>
                        </div>

                        <!-- Certificate Body Statement -->
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Completion Evaluation Statement *
                            </label>
                            <textarea name="cert_statement" id="inpCertStatement" rows="3" required oninput="updateLiveCertPreview()" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; line-height: 1.5; outline: none;">{{ old('cert_statement', $template['cert_statement']) }}</textarea>
                        </div>

                        <button type="submit" style="width: 100%; background: #05B396; color: #ffffff; border: none; padding: 0.85rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; cursor: pointer; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                            💾 Save Certificate Template Settings
                        </button>
                    </div>

                    <!-- Right Column: Live Interactive Preview -->
                    <div>
                        <div style="background: #0f172a; border-radius: 14px; padding: 0.8rem 1.2rem; color: #fff; margin-bottom: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.85rem; font-weight: 800; display: flex; align-items: center; gap: 6px;">
                                <span>👁️</span> Real-time Student Certificate Preview
                            </span>
                            <span style="font-size: 0.72rem; color: #05B396; font-weight: 700;">Live WYSIWYG</span>
                        </div>

                        <!-- The Preview Card Container -->
                        <div id="previewCertCard" style="background: radial-gradient(circle, #f0fdf9 0%, #ffffff 80%); border: 4px double #d97706; border-radius: 16px; padding: 2.2rem 2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.08); text-align: center; position: relative; overflow: hidden;">
                            
                            <!-- Seal / Stamp Watermark -->
                            <div style="position: absolute; right: 24px; bottom: 24px; width: 68px; height: 68px; border-radius: 50%; border: 2.5px dashed #05B396; color: #05B396; display: flex; flex-direction: column; align-items: center; justify-content: center; transform: rotate(-15deg); opacity: 0.85; font-size: 0.6rem; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase;">
                                <span>★ VERIFIED ★</span>
                                <span style="font-size: 0.75rem;">SEAL</span>
                            </div>

                            <img src="{{ asset('assets/logo.png') }}" onerror="this.src='/images/logo.png';" alt="SkillLearner Logo" style="max-height: 44px; margin-bottom: 1rem; object-fit: contain;">

                            <div id="prevCertSubtitle" style="font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 0.4rem;">
                                {{ $template['cert_subtitle'] }}
                            </div>

                            <h2 id="prevCertTitle" style="font-size: 1.45rem; font-weight: 900; color: {{ $template['cert_theme_color'] }}; letter-spacing: 1.5px; text-transform: uppercase; margin: 0 0 0.8rem;">
                                {{ $template['cert_title'] }}
                            </h2>

                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.6rem;">This is proudly presented to</p>

                            <h3 style="font-size: 1.6rem; font-weight: 900; color: #0f172a; margin-bottom: 0.6rem; letter-spacing: -0.5px; text-decoration: underline; text-decoration-color: #cbd5e1;">
                                Suraj Phoolchand Pal
                            </h3>

                            <p id="prevCertStatement" style="font-size: 0.82rem; color: #475569; max-width: 440px; margin: 0 auto 0.8rem; line-height: 1.5;">
                                {{ $template['cert_statement'] }}
                            </p>

                            <div style="font-size: 1.1rem; font-weight: 800; color: {{ $template['cert_theme_color'] }}; margin-bottom: 1.5rem;" id="prevCertProgramTitle">
                                Performance Meta Ads Mastery
                            </div>

                            <!-- Footer Signature & Verification Bar -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; border-top: 1px dashed #cbd5e1; padding-top: 1.1rem; font-size: 0.76rem; color: #64748b; text-align: center;">
                                <div>
                                    <div style="font-family: 'Brush Script MT', cursive, sans-serif; font-size: 1.2rem; color: #0f172a; font-weight: bold;" id="prevSigDisplay">
                                        {{ $template['cert_signatory_name'] }}
                                    </div>
                                    <strong style="color: #0f172a; font-size: 0.8rem;" id="prevSignatoryName">{{ $template['cert_signatory_name'] }}</strong>
                                    <div style="font-size: 0.68rem; color: #64748b;" id="prevSignatoryTitle">{{ $template['cert_signatory_title'] }}</div>
                                </div>
                                <div>
                                    <div>Issue Date</div>
                                    <strong style="color: #0f172a; font-size: 0.8rem;">{{ date('d M, Y') }}</strong>
                                    <div style="font-size: 0.68rem; color: #05B396; font-weight: 700;">QR Verified</div>
                                </div>
                                <div>
                                    <div>Certificate ID</div>
                                    <strong style="font-family: monospace; color: #0f172a; font-size: 0.8rem;">SL-CERT-2026-9721</strong>
                                    <div style="font-size: 0.68rem; color: #64748b;" id="prevOrgName">{{ $template['cert_organization'] }}</div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </form>

        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function updateLiveCertPreview() {
        var title = document.getElementById('inpCertTitle').value;
        var subtitle = document.getElementById('inpCertSubtitle').value;
        var org = document.getElementById('inpCertOrg').value;
        var sigName = document.getElementById('inpSignatoryName').value;
        var sigTitle = document.getElementById('inpSignatoryTitle').value;
        var themeColor = document.getElementById('inpThemeColor').value;
        var borderStyle = document.getElementById('inpBorderStyle').value;
        var statement = document.getElementById('inpCertStatement').value;

        document.getElementById('prevCertTitle').textContent = title;
        document.getElementById('prevCertTitle').style.color = themeColor;
        document.getElementById('prevCertSubtitle').textContent = subtitle;
        document.getElementById('prevCertStatement').textContent = statement;
        document.getElementById('prevSignatoryName').textContent = sigName;
        document.getElementById('prevSigDisplay').textContent = sigName;
        document.getElementById('prevSignatoryTitle').textContent = sigTitle;
        document.getElementById('prevOrgName').textContent = org;
        document.getElementById('prevCertProgramTitle').style.color = themeColor;

        var card = document.getElementById('previewCertCard');
        if (borderStyle === 'gold_double') {
            card.style.border = '4px double #d97706';
        } else if (borderStyle === 'emerald_modern') {
            card.style.border = '3px solid #05B396';
        } else if (borderStyle === 'royal_purple') {
            card.style.border = '4px double #7c3aed';
        }
    }
</script>
@endpush
@endsection

