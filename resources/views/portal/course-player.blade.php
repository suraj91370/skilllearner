@extends('layouts.app')

@section('title', ($course['title'] ?? 'Course Video') . ' — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'courses'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'courses'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Navigation & Breadcrumb Top Bar -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ url('/my-courses') }}" style="display: inline-flex; align-items: center; gap: 6px; background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.84rem; text-decoration: none; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#1877f2'; this.style.color='#1877f2';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.color='#334155';">
                        <span>⬅</span>
                        <span>Back to My Courses</span>
                    </a>
                    <span style="color: #94a3b8; font-size: 0.85rem;">•</span>
                    <span style="background: rgba(24, 119, 242, 0.1); color: #1877f2; font-size: 0.8rem; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                        🎓 {{ $course['title'] }}
                    </span>
                </div>

                <div style="font-size: 0.82rem; color: #64748b; font-weight: 700;">
                    <span id="lessonCounterText">Lesson {{ ($activeLessonIndex ?? 0) + 1 }} of {{ count($lessons) }}</span>
                </div>
            </div>

            <!-- Two-Card Layout: COURSE VIDEO (Left) + COURSE LESSONS (Right) (Matches Image 2 Exactly) -->
            <div class="course-player-stage-grid">
                
                <!-- ========================================================= -->
                <!-- LEFT CARD: COURSE VIDEO (Matches Image 2)                 -->
                <!-- ========================================================= -->
                <div class="course-player-box">
                    <h3 class="course-card-header-title">COURSE VIDEO</h3>

                    <!-- Video Screen Container -->
                    <div class="video-screen-container">
                        <iframe id="activeCourseIframe" 
                                src="{{ $activeLesson['embed_url'] ?? $course['embed_url'] }}" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>

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
                <!-- RIGHT CARD: COURSE LESSONS SUBMENU (Matches Image 2)       -->
                <!-- ========================================================= -->
                <div class="course-lessons-box">
                    <h3 class="course-card-header-title">COURSE LESSONS</h3>

                    <!-- Lessons List: Outlined Rounded Rectangles (Matches Image 2) -->
                    <div class="lessons-vertical-menu" id="lessonsMenuContainer">
                        @foreach($lessons as $idx => $l)
                            @php
                                $isActive = ($idx === ($activeLessonIndex ?? 0));
                            @endphp
                            <button type="button" 
                                    class="lesson-item-btn {{ $isActive ? 'active' : '' }}" 
                                    id="lesson-btn-{{ $idx }}"
                                    onclick="switchLesson({{ $idx }})">
                                <span class="lesson-name-text">{{ $l['title'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Prev & Next Bottom Navigation (Matches Image 2) -->
                    <div class="lessons-bottom-nav">
                        <button type="button" onclick="navigatePrevLesson()" id="btnPrevLesson" class="btn-nav-pagination">
                            Prev
                        </button>
                        <button type="button" onclick="navigateNextLesson()" id="btnNextLesson" class="btn-nav-pagination">
                            Next
                        </button>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- ================================================================= -->
<!-- OFFICIAL VERIFIED COURSE CERTIFICATE MODAL                        -->
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

        <!-- Printable Certificate Canvas Area -->
        <div id="printableCertificateCard" style="background: #ffffff; border: 8px solid #0f172a; padding: 2.5rem 2rem; border-radius: 12px; position: relative; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 1.5rem; overflow: hidden;">
            <!-- Golden Inner Border -->
            <div style="position: absolute; inset: 6px; border: 2px solid #ffd700; border-radius: 6px; pointer-events: none;"></div>

            <!-- Header Badge -->
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
                For successfully completing all video masterclass modules, practical assignments, and coursework in:
            </p>

            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 0.85rem 1.4rem; display: inline-block; margin-bottom: 1.8rem;">
                <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                    {{ $course['title'] }}
                </h4>
            </div>

            <!-- Signature & Seal Row -->
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
                    <div style="font-size: 0.72rem; color: #64748b;">ID: SL-{{ strtoupper(substr(md5($course['slug'] . session('user.name')), 0, 8)) }}</div>
                </div>
            </div>
        </div>

        <!-- Modal Actions -->
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

    /* Lessons Submenu: Outlined Rounded Pill Boxes (Matches Image 2) */
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
    }

    .lesson-item-btn:hover {
        border-color: #94a3b8;
        background: #f8fafc;
    }

    .lesson-item-btn.active {
        border-color: #1877f2;
        background: #eff6ff;
        color: #1877f2;
        box-shadow: 0 0 0 1px #1877f2;
    }

    .lesson-active-indicator {
        font-size: 0.72rem;
        color: #1877f2;
        font-weight: 900;
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
    // Lessons JSON Array from PHP
    const courseLessons = @json($lessons);
    let currentLessonIdx = {{ $activeLessonIndex ?? 0 }};

    function switchLesson(idx) {
        if (idx < 0 || idx >= courseLessons.length) return;
        currentLessonIdx = idx;
        const lesson = courseLessons[idx];

        // Update Video Iframe
        const iframe = document.getElementById('activeCourseIframe');
        if (iframe && lesson.embed_url) {
            iframe.src = lesson.embed_url;
        }

        // Update Title & Duration
        const titleEl = document.getElementById('currentLessonDisplayTitle');
        if (titleEl) titleEl.innerText = lesson.title;

        const durEl = document.getElementById('currentLessonDisplayDuration');
        if (durEl) durEl.innerText = '⏱️ ' + (lesson.duration || '15m');

        const counterEl = document.getElementById('lessonCounterText');
        if (counterEl) counterEl.innerText = 'Lesson ' + (idx + 1) + ' of ' + courseLessons.length;

        // Update Active Button styling
        courseLessons.forEach((_, i) => {
            const btn = document.getElementById('lesson-btn-' + i);
            const ind = document.getElementById('indicator-' + i);
            if (btn) {
                if (i === idx) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
            if (ind) {
                ind.style.display = (i === idx) ? 'inline-block' : 'none';
            }
        });

        // Update Prev / Next state
        updateNavState();
    }

    function navigatePrevLesson() {
        if (currentLessonIdx > 0) {
            switchLesson(currentLessonIdx - 1);
        }
    }

    function navigateNextLesson() {
        if (currentLessonIdx < courseLessons.length - 1) {
            switchLesson(currentLessonIdx + 1);
        }
    }

    function updateNavState() {
        const prevBtn = document.getElementById('btnPrevLesson');
        const nextBtn = document.getElementById('btnNextLesson');
        if (prevBtn) prevBtn.disabled = (currentLessonIdx <= 0);
        if (nextBtn) nextBtn.disabled = (currentLessonIdx >= courseLessons.length - 1);
    }

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

    // Initial check
    updateNavState();
</script>
@endpush
@endsection
