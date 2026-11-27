@extends('layouts.app')

@section('title', ($activeVideo->title ?? 'Course Video') . ' — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'videos'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'videos'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Top Breadcrumb & Navigation Bar -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ url('/my-courses') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.84rem; text-decoration: none; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#1877f2'; this.style.color='#1877f2';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#334155';">
                        <span>⬅</span>
                        <span>Back to My Courses</span>
                    </a>
                    <span style="color: #94a3b8; font-size: 0.85rem;">•</span>
                    <span style="background: rgba(24, 119, 242, 0.1); color: #1877f2; font-size: 0.8rem; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                        🎓 {{ $activeVideo->title ?? 'Video Masterclass' }}
                    </span>
                </div>

                <div style="font-size: 0.82rem; color: #64748b; font-weight: 700;">
                    <span id="lessonCounterText">Lesson {{ $videos->search(fn($v) => $v->id === optional($activeVideo)->id) !== false ? ($videos->search(fn($v) => $v->id === optional($activeVideo)->id) + 1) : 1 }} of {{ count($videos) }}</span>
                </div>
            </div>

            @if($videos->isEmpty())
                <!-- Empty State -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 3.5rem 2rem; text-align: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <div style="font-size: 3rem; margin-bottom: 0.8rem;">🔒</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;">
                        No Videos Currently Available
                    </h3>
                    <p style="font-size: 0.92rem; color: #64748b; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.5;">
                        Video masterclasses are currently being updated. Please check back shortly or explore our courses.
                    </p>
                    <a href="{{ url('/my-courses') }}" class="btn btn-primary" style="background: #1877f2; font-weight: 700; padding: 0.65rem 1.4rem; border-radius: 8px; text-decoration: none; font-size: 0.88rem;">
                        Go to My Courses ➔
                    </a>
                </div>
            @else
                <!-- Two-Card Side-by-Side Layout: COURSE VIDEO + COURSE LESSONS (Matches Image 2 Exactly) -->
                <div class="course-player-stage-grid">
                    
                    <!-- ========================================================= -->
                    <!-- LEFT CARD: COURSE VIDEO (Matches Image 2)                 -->
                    <!-- ========================================================= -->
                    <div class="course-player-box">
                        <h3 class="course-card-header-title">COURSE VIDEO</h3>

                        <!-- Video Screen Container -->
                        <div class="video-screen-container">
                            @if($activeVideo && $activeVideo->is_iframe)
                                <iframe id="activeCourseIframe" 
                                        src="{{ $activeVideo->embed_url }}" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            @elseif($activeVideo)
                                <video id="mainVideoPlayer" controls poster="{{ $activeVideo->thumbnail_url ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <source src="{{ $activeVideo->video_url }}" type="video/mp4">
                                    Your browser does not support HTML5 video.
                                </video>
                            @endif

                            <!-- Anti-Piracy Watermark -->
                            <div id="coursePlayerDrmWatermark" class="player-floating-drm">
                                SKILLLEARNER • {{ session('user.name', 'Student') }} • {{ session('user.affiliate_id', 'SL-STUDENT') }}
                            </div>
                        </div>

                        <!-- Full-Width DOWNLOAD CERTIFICATE Button (Matches Image 2) -->
                        <button type="button" onclick="openCertificateModal()" class="btn-download-certificate">
                            DOWNLOAD CERTIFICATE
                        </button>
                    </div>

                    <!-- ========================================================= -->
                    <!-- RIGHT CARD: COURSE LESSONS (Matches Image 2)              -->
                    <!-- ========================================================= -->
                    <div class="course-lessons-box">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <h3 class="course-card-header-title" style="margin: 0;">COURSE LESSONS</h3>
                            <span style="font-size: 0.72rem; color: #64748b; font-weight: 700;">
                                Course Modules • {{ count($videos) }} Lessons
                            </span>
                        </div>

                        <!-- Lessons List: Outlined Rounded Rectangular Pill Boxes (Matches Image 2) -->
                        <div class="lessons-vertical-menu" id="lessonsMenuContainer">
                            @php
                                $currentVidIndex = 0;
                            @endphp
                            @foreach($videos as $idx => $v)
                                @php
                                    $isActive = ($activeVideo && $activeVideo->id === $v->id);
                                    if ($isActive) {
                                        $currentVidIndex = $idx;
                                    }
                                    $modLabel = $v->module_name ? ($v->module_name . ($v->sub_module_name ? ' • ' . $v->sub_module_name : '')) : null;
                                @endphp
                                <a href="{{ url('/videos?v=' . $v->id . ($currentCategory !== 'all' ? '&category=' . urlencode($currentCategory) : '')) }}" 
                                   class="lesson-item-btn {{ $isActive ? 'active' : '' }}" 
                                   id="lesson-item-{{ $idx }}">
                                    <div style="display: flex; flex-direction: column; gap: 2px; min-width: 0;">
                                        <span class="lesson-name-text">{{ $v->title }}</span>
                                        @if($modLabel)
                                            <span style="font-size: 0.7rem; color: #64748b; font-weight: 500;">
                                                {{ $modLabel }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($isActive)
                                        <span style="color: #1877f2; font-size: 0.8rem; font-weight: 900;">▶</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>

                        <!-- Prev & Next Bottom Navigation (Matches Image 2) -->
                        <div class="lessons-bottom-nav">
                            @php
                                $prevVideo = $currentVidIndex > 0 ? $videos[$currentVidIndex - 1] : null;
                                $nextVideo = $currentVidIndex < (count($videos) - 1) ? $videos[$currentVidIndex + 1] : null;
                            @endphp
                            @if($prevVideo)
                                <a href="{{ url('/videos?v=' . $prevVideo->id . ($currentCategory !== 'all' ? '&category=' . urlencode($currentCategory) : '')) }}" class="btn-nav-pagination" style="text-decoration: none;">
                                    Prev
                                </a>
                            @else
                                <button type="button" class="btn-nav-pagination" disabled>
                                    Prev
                                </button>
                            @endif

                            @if($nextVideo)
                                <a href="{{ url('/videos?v=' . $nextVideo->id . ($currentCategory !== 'all' ? '&category=' . urlencode($currentCategory) : '')) }}" class="btn-nav-pagination" style="text-decoration: none;">
                                    Next
                                </a>
                            @else
                                <button type="button" class="btn-nav-pagination" disabled>
                                    Next
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
        </main>
    </div>
</div>

<!-- ================================================================= -->
<!-- OFFICIAL COURSE CERTIFICATE MODAL                                 -->
<!-- ================================================================= -->
<div id="certificateModal" class="certificate-modal-overlay" style="display: none;">
    <div class="certificate-modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.8rem;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.4rem;">🎖️</span>
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Course Completion Certificate</h3>
            </div>
            <button type="button" onclick="closeCertificateModal()" style="background: none; border: none; font-size: 1.6rem; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <div id="printableCertificateCard" style="background: #ffffff; border: 8px solid #0f172a; padding: 2.5rem 2rem; border-radius: 12px; position: relative; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 1.5rem; overflow: hidden;">
            <div style="position: absolute; inset: 6px; border: 2px solid #ffd700; border-radius: 6px; pointer-events: none;"></div>

            <div style="margin-bottom: 0.6rem;">
                <span style="font-size: 0.82rem; font-weight: 900; letter-spacing: 2px; color: #1877f2; text-transform: uppercase;">
                    SKILLLEARNER OFFICIAL RECOGNITION
                </span>
            </div>

            <h2 style="font-family: Georgia, serif; font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 0 0 0.8rem;">
                Certificate of Completion
            </h2>

            <p style="font-size: 0.9rem; color: #64748b; margin: 0 0 1.2rem;">
                This verifiable certificate is proudly presented to
            </p>

            <h3 style="font-size: 1.6rem; font-weight: 900; color: #1877f2; text-decoration: underline; margin: 0 0 1.2rem;">
                {{ session('user.name', 'Student') }}
            </h3>

            <p style="font-size: 0.9rem; color: #475569; max-width: 540px; margin: 0 auto 1.5rem; line-height: 1.5;">
                For successfully completing all video masterclass modules and practical coursework in:
            </p>

            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 0.85rem 1.4rem; display: inline-block; margin-bottom: 1.8rem;">
                <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                    {{ $activeVideo->title ?? 'Masterclass Training' }}
                </h4>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: flex-end; padding-top: 1rem; border-top: 1px dashed #cbd5e1; max-width: 520px; margin: 0 auto;">
                <div style="text-align: left;">
                    <div style="font-weight: 800; color: #0f172a; font-size: 0.88rem;">Alex Rivera</div>
                    <div style="font-size: 0.72rem; color: #64748b;">Academic Director, SkillLearner</div>
                </div>

                <div style="width: 56px; height: 56px; border-radius: 50%; border: 2px solid #ffd700; background: radial-gradient(circle, #fef08a 0%, #ca8a04 100%); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.62rem; color: #000; box-shadow: 0 2px 8px rgba(202, 138, 4, 0.4);">
                    ★ ISO ★
                </div>

                <div style="text-align: right;">
                    <div style="font-weight: 800; color: #0f172a; font-size: 0.88rem;">{{ date('d M Y') }}</div>
                    <div style="font-size: 0.72rem; color: #64748b;">ID: SL-{{ strtoupper(substr(md5(($activeVideo->id ?? 1) . session('user.name')), 0, 8)) }}</div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeCertificateModal()" style="background: #f1f5f9; border: none; padding: 0.65rem 1.3rem; border-radius: 8px; font-weight: 700; color: #475569; cursor: pointer;">
                Close
            </button>
            <button type="button" onclick="window.print()" style="background: #1877f2; color: #ffffff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <span>🖨️ Print / Save as PDF</span>
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Two-Card Side-by-Side Layout (Matches Image 2) */
    .course-player-stage-grid {
        display: grid;
        grid-template-columns: 1.65fr 1.35fr;
        gap: 1.5rem;
        align-items: flex-start;
    }

    /* Left Card: Course Video */
    .course-player-box {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.4rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
    }

    /* Right Card: Course Lessons */
    .course-lessons-box {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.4rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
    }

    .course-card-header-title {
        font-size: 0.96rem;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin: 0 0 1rem;
    }

    /* Video Player Screen */
    .video-screen-container {
        position: relative;
        background: #000000;
        border-radius: 10px;
        overflow: hidden;
        aspect-ratio: 16 / 9;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .video-screen-container iframe,
    .video-screen-container video {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    /* Anti-Piracy Watermark */
    .player-floating-drm {
        position: absolute;
        top: 14px;
        left: 14px;
        color: rgba(255, 255, 255, 0.35);
        font-weight: 800;
        font-size: 0.78rem;
        pointer-events: none;
        text-shadow: 0 0 4px rgba(0, 0, 0, 0.9);
        z-index: 40;
        transition: all 2.5s ease-in-out;
    }

    /* Download Certificate Button (Matches Image 2) */
    .btn-download-certificate {
        width: 100%;
        margin-top: 1.25rem;
        background: #1877f2;
        color: #ffffff;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.88rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.35);
        transition: background-color 0.15s ease, transform 0.15s ease;
    }

    .btn-download-certificate:hover {
        background: #1464cc;
        transform: translateY(-1px);
    }

    /* Lessons Submenu: Outlined Rounded Rectangular Pill Boxes (Matches Image 2) */
    .lessons-vertical-menu {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
        max-height: 480px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .lesson-item-btn {
        width: 100%;
        text-align: left;
        padding: 0.72rem 1rem;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        outline: none;
        font-family: inherit;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
        text-decoration: none;
    }

    .lesson-item-btn:hover {
        border-color: #94a3b8;
        background: #f8fafc;
        color: #0f172a;
    }

    .lesson-item-btn.active {
        border-color: #1877f2;
        background: #eff6ff;
        color: #1877f2;
        box-shadow: 0 0 0 1px #1877f2;
    }

    /* Prev & Next Navigation (Matches Image 2) */
    .lessons-bottom-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.4rem;
        padding-top: 0.9rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn-nav-pagination {
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        padding: 6px 18px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-block;
    }

    .btn-nav-pagination:hover:not(:disabled) {
        border-color: #1877f2;
        color: #1877f2;
        background: #eff6ff;
    }

    .btn-nav-pagination:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Certificate Modal */
    .certificate-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(4px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .certificate-modal-content {
        background: #ffffff;
        border-radius: 16px;
        max-width: 680px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 1.8rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 900px) {
        .course-player-stage-grid {
            grid-template-columns: 1fr !important;
            gap: 1.25rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Modal Control
    function openCertificateModal() {
        document.getElementById('certificateModal').style.display = 'flex';
    }

    function closeCertificateModal() {
        document.getElementById('certificateModal').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('certificateModal');
        if (e.target === modal) {
            closeCertificateModal();
        }
    });

    // Dynamic Moving DRM Watermark
    const wm = document.getElementById('coursePlayerDrmWatermark');
    const container = document.querySelector('.video-screen-container');
    if (wm && container) {
        setInterval(() => {
            const maxX = container.clientWidth - wm.clientWidth - 30;
            const maxY = container.clientHeight - wm.clientHeight - 30;
            const randX = Math.max(10, Math.floor(Math.random() * maxX));
            const randY = Math.max(10, Math.floor(Math.random() * maxY));
            wm.style.left = randX + 'px';
            wm.style.top = randY + 'px';
        }, 4000);
    }
</script>
@endpush
@endsection
