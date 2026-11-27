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
            <div class="portal-greeting-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(24, 119, 242, 0.1); color: #1877f2; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        🎓 STUDENT LEARNING CENTER
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); margin: 0;">
                        Welcome <span class="highlight-user-name">{{ session('user.name', 'Vansh Tandon') }}</span> 👐
                    </h2>
                </div>
                <button type="button" onclick="window.openLoginVideoModal()" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1.5px solid #05B396; color: #05B396; padding: 0.55rem 1.15rem; border-radius: 10px; font-weight: 700; font-size: 0.88rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(5, 179, 150, 0.15);" onmouseover="this.style.background='#05B396'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(5, 179, 150, 0.12)'; this.style.color='#05B396';">
                    <span style="font-size: 1.1rem;">🎬</span>
                    <span>Watch Welcome Video</span>
                </button>
            </div>

            <!-- Super Admin Live Course Visibility Notice -->
            @if(!empty($isSuperAdmin))
                <div style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(79, 70, 229, 0.08) 100%); border: 1.5px solid rgba(124, 58, 237, 0.25); border-radius: 14px; padding: 1rem 1.4rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.4rem;">👑</span>
                        <div>
                            <div style="font-size: 0.92rem; font-weight: 800; color: #4338ca;">Super Admin Course Control</div>
                            <div style="font-size: 0.78rem; color: #64748b;">You can manage visibility of courses and see live student views.</div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/courses') }}" style="background: #7c3aed; color: #ffffff; font-size: 0.82rem; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);">
                        Manage Courses Hub ➔
                    </a>
                </div>
            @endif

            <!-- Toolbar: Filter Pills & Search Input -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="course-filter-pills" style="margin: 0; display: flex; gap: 8px;">
                    <button type="button" class="filter-pill active" onclick="filterCourseCards('all', this)">
                        All Courses <span class="pill-badge-num">({{ count($courses) }})</span>
                    </button>
                    <button type="button" class="filter-pill" onclick="filterCourseCards('enrolled', this)">
                        Enrolled Courses
                    </button>
                    <button type="button" class="filter-pill" onclick="filterCourseCards('active', this)">
                        Active
                    </button>
                </div>

                <div style="position: relative; max-width: 280px; width: 100%;">
                    <input type="text" id="courseSearchInput" onkeyup="searchCourses()" placeholder="Search course by name..." style="width: 100%; padding: 0.55rem 0.9rem 0.55rem 2.2rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#1877f2'" onblur="this.style.borderColor='#cbd5e1'">
                    <span style="position: absolute; left: 9px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem;">🔍</span>
                </div>
            </div>

            @if(empty($courses))
                <!-- Empty State -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 3.5rem 2rem; text-align: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); margin-top: 1.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 0.8rem;">📚</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem;">
                        No Courses Currently Available
                    </h3>
                    <p style="font-size: 0.92rem; color: #64748b; max-width: 480px; margin: 0 auto; line-height: 1.5;">
                        Courses are currently being updated by platform administration. Please check back shortly or explore our video masterclasses.
                    </p>
                    <a href="{{ url('/videos') }}" class="btn btn-primary" style="background: #1877f2; font-weight: 700; padding: 0.65rem 1.4rem; border-radius: 8px; text-decoration: none; font-size: 0.88rem; display: inline-block; margin-top: 1rem;">
                        Watch Video Masterclasses ➔
                    </a>
                </div>
            @else
                <!-- 4-Column Responsive Grid (Matches Image 1 Exactly) -->
                <div class="my-courses-custom-grid" id="coursesGridContainer">
                    @foreach ($courses as $c)
                        <div class="my-course-card-item" data-title="{{ strtolower($c['title']) }}" id="course-card-{{ $c['id'] }}">
                            <!-- Top Banner Image / Graphic -->
                            <div class="course-banner-wrapper">
                                @include('portal.partials.course-banner-graphic', ['course' => $c])
                            </div>

                            <!-- Course Title (Centered) -->
                            <h3 class="course-card-name">
                                {{ $c['title'] }}
                            </h3>

                            <!-- START NOW Full-Width Action Button (Matches Image 1) -->
                            <a href="{{ url('/my-courses/' . $c['slug']) }}" class="btn-start-now">
                                START NOW
                            </a>

                            @if(!empty($isSuperAdmin))
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.6rem; padding-top: 0.5rem; border-top: 1px dashed #e2e8f0; font-size: 0.72rem; color: #64748b;">
                                    <span>Status: <strong style="color: {{ ($c['is_visible'] ?? true) ? '#059669' : '#b45309' }};">{{ ($c['is_visible'] ?? true) ? 'Visible' : 'Hidden' }}</strong></span>
                                    <span style="background: #f1f5f9; padding: 1px 6px; border-radius: 4px;">{{ $c['lessons'] ?? 4 }} Lessons</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

@push('styles')
<style>
    /* 4 Cards Per Row Grid on Desktop (Matching Image 1) */
    .my-courses-custom-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }

    .my-course-card-item {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 0.9rem;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .my-course-card-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }

    .course-banner-wrapper {
        width: 100%;
        aspect-ratio: 16 / 9;
        border-radius: 10px;
        overflow: hidden;
        background: #0a1128;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        position: relative;
    }

    .course-card-name {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        text-align: center;
        margin: 0.85rem 0 0.95rem;
        line-height: 1.35;
        min-height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Vibrant Blue START NOW Button (Matches Image 1) */
    .btn-start-now {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #1877f2;
        color: #ffffff !important;
        font-weight: 800;
        font-size: 0.86rem;
        padding: 0.65rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
        transition: background-color 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
        box-sizing: border-box;
    }

    .btn-start-now:hover {
        background: #1464cc;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(24, 119, 242, 0.4);
    }

    @media (max-width: 1180px) {
        .my-courses-custom-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }

    @media (max-width: 860px) {
        .my-courses-custom-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 1rem !important;
        }
    }

    @media (max-width: 560px) {
        .my-courses-custom-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function filterCourseCards(filter, btn) {
        document.querySelectorAll('.course-filter-pills .filter-pill').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        
        const cards = document.querySelectorAll('.my-course-card-item');
        cards.forEach(card => {
            card.style.display = 'flex';
        });
    }

    function searchCourses() {
        const val = document.getElementById('courseSearchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.my-course-card-item');
        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            if (!val || title.includes(val)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
