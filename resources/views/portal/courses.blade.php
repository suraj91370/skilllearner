@extends('layouts.app')

@section('title', 'My Courses — SkillLearner')

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
            <div class="portal-greeting-row">
                <h2 class="welcome-heading">Welcome <span class="highlight-user-name">{{ session('user.name', 'Vansh Tandon') }}</span> 👐</h2>
            </div>

            <!-- Super Admin Live Course Visibility Notice -->
            @if(!empty($isSuperAdmin))
                <div style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(79, 70, 229, 0.08) 100%); border: 1.5px solid rgba(124, 58, 237, 0.25); border-radius: 14px; padding: 1rem 1.4rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.4rem;">👑</span>
                        <div>
                            <div style="font-size: 0.92rem; font-weight: 800; color: #4338ca;">Super Admin Course Visibility Control</div>
                            <div style="font-size: 0.78rem; color: #64748b;">You can toggle Show / Hide on any course card below in real-time. Hidden courses are removed from student views.</div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/courses') }}" style="background: #7c3aed; color: #ffffff; font-size: 0.82rem; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);">
                        Manage Courses Hub ➔
                    </a>
                </div>
            @endif

            <!-- Live Status Toast for AJAX -->
            <div id="coursePortalToast" style="display: none; position: fixed; top: 24px; right: 24px; z-index: 9999; background: #0f172a; color: #ffffff; padding: 1rem 1.4rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); font-weight: 700; font-size: 0.9rem; align-items: center; gap: 10px; border-left: 4px solid #05B396; transition: opacity 0.3s ease;">
                <span id="coursePortalToastIcon">✅</span>
                <span id="coursePortalToastMsg">Course visibility updated.</span>
            </div>

            <!-- Enrolled / Active Filter Pills -->
            <div class="course-filter-pills">
                <button type="button" class="filter-pill active" onclick="filterCourses('enrolled')">
                    Enrolled Courses <span class="pill-badge-num">({{ count($courses) }})</span>
                </button>
                <button type="button" class="filter-pill" onclick="filterCourses('active')">
                    Active Courses <span class="pill-badge-num">({{ count($courses) }})</span>
                </button>
            </div>

            @if(empty($courses))
                <!-- Empty State (When courses are hidden) -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 3.5rem 2rem; text-align: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); margin-top: 1.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 0.8rem;">📚</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;">
                        No Courses Currently Available
                    </h3>
                    <p style="font-size: 0.92rem; color: #64748b; max-width: 480px; margin: 0 auto; line-height: 1.5;">
                        Courses are currently being updated by platform administration. Please check back shortly or explore our video masterclasses.
                    </p>
                    <a href="{{ url('/videos') }}" class="btn btn-primary" style="background: #05B396; font-weight: 700; padding: 0.65rem 1.4rem; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-block; margin-top: 1rem;">
                        Watch Video Masterclasses ➔
                    </a>
                </div>
            @else
                <!-- Enrolled Courses Grid -->
                <div class="courses-cards-grid">
                    @foreach ($courses as $c)
                        <div class="portal-course-card" id="course-card-{{ $c['id'] }}" style="{{ (!empty($isSuperAdmin) && !($c['is_visible'] ?? true)) ? 'opacity: 0.75; border: 1.5px dashed #f59e0b;' : '' }}">
                            <a href="{{ url('/classroom') }}?course={{ $c['slug'] }}" class="card-thumb-link">
                                <div class="course-thumb-container" style="background: {{ $c['gradient'] }}; position: relative;">
                                    
                                    <!-- Neon Graphic & Banner Text -->
                                    <div class="thumb-neon-glow" style="background: radial-gradient(circle, {{ $c['accent'] }}44 0%, transparent 70%);"></div>
                                    
                                    <div class="thumb-header-badge" style="display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
                                        <span>SKILLLEARNER • PRO COURSE</span>
                                        @if(!empty($isSuperAdmin))
                                            <span id="card-badge-{{ $c['id'] }}" style="background: {{ ($c['is_visible'] ?? true) ? '#05B396' : '#b45309' }}; color: #ffffff; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 800;">
                                                {{ ($c['is_visible'] ?? true) ? 'SHOWN' : 'HIDDEN' }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="thumb-center-content">
                                        <h4 class="thumb-banner-title">{{ $c['banner_title'] }}</h4>
                                        <p class="thumb-banner-tag">{{ $c['banner_tag'] }}</p>
                                    </div>

                                    <!-- Centered Play Button (White Circle with Play Triangle) -->
                                    <div class="center-play-button">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#0f172a">
                                            <polygon points="6,3 20,12 6,21"></polygon>
                                        </svg>
                                    </div>

                                    <div class="thumb-footer-meta">
                                        <span>{{ $c['lessons'] }} Lessons</span>
                                        <span>•</span>
                                        <span>Certificate</span>
                                        <span>•</span>
                                        <span>Self-Paced</span>
                                    </div>
                                </div>
                            </a>

                            <!-- Course Details Body -->
                            <div class="course-card-body">
                                <h3 class="course-card-title">
                                    <a href="{{ url('/classroom') }}?course={{ $c['slug'] }}">{{ $c['title'] }}</a>
                                </h3>

                                <div class="course-instructor-row" style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <img src="{{ $c['instructor_avatar'] }}" alt="{{ $c['instructor'] }}" class="instructor-avatar">
                                        <span class="instructor-name">By {{ $c['instructor'] }}</span>
                                    </div>
                                </div>

                                <!-- Super Admin Instant Show / Hide Toggle Button -->
                                @if(!empty($isSuperAdmin))
                                    <div class="portal-admin-visibility-box" style="margin-top: 0.9rem; padding-top: 0.75rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <span style="font-size: 0.62rem; background: #7c3aed; color: #fff; padding: 2px 6px; border-radius: 4px; font-weight: 800; letter-spacing: 0.5px;">ADMIN</span>
                                            <span style="font-size: 0.76rem; font-weight: 700; color: #64748b;">
                                                User Visibility:
                                            </span>
                                        </div>
                                        <button type="button" 
                                                onclick="togglePortalCourseVisibility({{ $c['id'] }})"
                                                id="portal-btn-{{ $c['id'] }}"
                                                style="background: {{ ($c['is_visible'] ?? true) ? '#ecfdf5' : '#fef3c7' }}; color: {{ ($c['is_visible'] ?? true) ? '#059669' : '#b45309' }}; border: 1.5px solid {{ ($c['is_visible'] ?? true) ? '#a7f3d0' : '#fde68a' }}; padding: 6px 13px; border-radius: 8px; font-size: 0.78rem; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; min-height: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); touch-action: manipulation;">
                                            <span id="portal-btn-icon-{{ $c['id'] }}">{{ ($c['is_visible'] ?? true) ? '👁️ Shown to Users' : '🙈 Hidden from Users' }}</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

@push('scripts')
<script>
    function filterCourses(type) {
        document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
        if (event && event.target) {
            event.target.closest('.filter-pill').classList.add('active');
        }
    }

    // Super Admin Instant Show / Hide from My Course page
    function togglePortalCourseVisibility(courseId) {
        const btn = document.getElementById('portal-btn-' + courseId);
        const btnIcon = document.getElementById('portal-btn-icon-' + courseId);
        const cardBadge = document.getElementById('card-badge-' + courseId);
        const card = document.getElementById('course-card-' + courseId);

        btn.style.opacity = '0.6';
        btn.disabled = true;

        fetch('{{ url("/admin/courses") }}/' + courseId + '/toggle-visibility', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.style.opacity = '1';
            btn.disabled = false;

            if (data.success) {
                if (data.is_visible) {
                    btn.style.background = '#ecfdf5';
                    btn.style.color = '#059669';
                    btn.style.borderColor = '#a7f3d0';
                    btnIcon.innerText = '👁️ Shown';

                    if (cardBadge) {
                        cardBadge.style.background = '#05B396';
                        cardBadge.innerText = 'SHOWN';
                    }
                    if (card) {
                        card.style.opacity = '1';
                        card.style.border = '';
                    }
                } else {
                    btn.style.background = '#fef3c7';
                    btn.style.color = '#b45309';
                    btn.style.borderColor = '#fde68a';
                    btnIcon.innerText = '🙈 Hidden';

                    if (cardBadge) {
                        cardBadge.style.background = '#b45309';
                        cardBadge.innerText = 'HIDDEN';
                    }
                    if (card) {
                        card.style.opacity = '0.75';
                        card.style.border = '1.5px dashed #f59e0b';
                    }
                }
                showPortalToast(data.message, '✅');
            } else {
                showPortalToast('Could not toggle course visibility.', '⚠️');
            }
        })
        .catch(err => {
            btn.style.opacity = '1';
            btn.disabled = false;
            showPortalToast('Network error while updating course.', '❌');
            console.error(err);
        });
    }

    function showPortalToast(msg, icon) {
        const toast = document.getElementById('coursePortalToast');
        if (!toast) return;
        document.getElementById('coursePortalToastMsg').innerText = msg;
        document.getElementById('coursePortalToastIcon').innerText = icon || '✅';
        toast.style.display = 'flex';
        toast.style.opacity = '1';
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => { toast.style.display = 'none'; }, 300);
        }, 3200);
    }
</script>
@endpush
@endsection
