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

            <!-- Enrolled / Active Filter Pills -->
            <div class="course-filter-pills">
                <button type="button" class="filter-pill active" onclick="filterCourses('enrolled')">
                    Enrolled Courses <span class="pill-badge-num">({{ count($courses) }})</span>
                </button>
                <button type="button" class="filter-pill" onclick="filterCourses('active')">
                    Active Courses <span class="pill-badge-num">({{ count($courses) }})</span>
                </button>
            </div>

            <!-- 12 Enrolled Courses Grid (4 Columns Desktop, Responsive Tablet & Mobile) -->
            <div class="courses-cards-grid">
                @foreach ($courses as $c)
                    <div class="portal-course-card">
                        <a href="{{ url('/classroom') }}?course={{ $c['slug'] }}" class="card-thumb-link">
                            <div class="course-thumb-container" style="background: {{ $c['gradient'] }};">
                                
                                <!-- Neon Graphic & Banner Text -->
                                <div class="thumb-neon-glow" style="background: radial-gradient(circle, {{ $c['accent'] }}44 0%, transparent 70%);"></div>
                                
                                <div class="thumb-header-badge">
                                    <span>SKILLLEARNER • PRO COURSE</span>
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

                            <div class="course-instructor-row">
                                <img src="{{ $c['instructor_avatar'] }}" alt="{{ $c['instructor'] }}" class="instructor-avatar">
                                <span class="instructor-name">By {{ $c['instructor'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function filterCourses(type) {
        document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
        if (event && event.target) {
            event.target.closest('.filter-pill').classList.add('active');
        }
    }
</script>
@endpush
@endsection
