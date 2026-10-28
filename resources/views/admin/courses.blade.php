@extends('layouts.app')

@section('title', 'Course Management & Show/Hide Control — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-courses'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-courses'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Action Row -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        👑 SUPER ADMIN EXCLUSIVE ACCESS
                    </div>
                    <h2 class="welcome-heading" style="font-size: clamp(1.2rem, 4.5vw, 1.6rem); word-break: break-word; overflow-wrap: anywhere; margin-bottom: 0.25rem;">
                        📚 Course Management &amp; Show/Hide Control
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Control course availability for enrolled users. Hidden courses are immediately removed from student <strong>My Course</strong> views.
                    </p>
                </div>
                <a href="{{ url('/my-courses') }}" target="_blank" style="background: linear-gradient(135deg, #05B396 0%, #047857 100%); color: #ffffff; border: none; padding: 0.75rem 1.4rem; border-radius: 10px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(5, 179, 150, 0.35); font-size: 0.92rem; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <span>Preview Student "My Course" ↗</span>
                </a>
            </div>

            <!-- Flash Notifications -->
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Live Status Toast for AJAX -->
            <div id="courseLiveToast" style="display: none; position: fixed; top: 24px; right: 24px; z-index: 9999; background: #0f172a; color: #ffffff; padding: 1rem 1.4rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); font-weight: 700; font-size: 0.9rem; align-items: center; gap: 10px; border-left: 4px solid #05B396; transition: opacity 0.3s ease;">
                <span id="courseToastIcon">✅</span>
                <span id="courseToastMsg">Course visibility updated successfully.</span>
            </div>

            <!-- Stat Cards Grid -->
            <div class="admin-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Courses -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL PLATFORM COURSES</div>
                    <div class="admin-stat-val">{{ $counts['total'] }}</div>
                    <div class="admin-stat-sub">Across all bundles &amp; packages</div>
                </div>

                <!-- Visible Courses -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">👁️ SHOWN IN MY COURSE</div>
                    <div class="admin-stat-val" style="color: #05B396;">{{ $counts['visible'] }}</div>
                    <div class="admin-stat-sub">Visible to regular students</div>
                </div>

                <!-- Hidden Courses -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #d97706;">🙈 HIDDEN FROM USERS</div>
                    <div class="admin-stat-val" style="color: #d97706;">{{ $counts['hidden'] }}</div>
                    <div class="admin-stat-sub">Excluded from student course grids</div>
                </div>
            </div>

            <!-- Filters & Search Toolbar -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ url('/admin/courses') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <!-- Filter Pills -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ url('/admin/courses') }}" class="admin-filter-pill {{ $currentFilter === 'all' ? 'active' : '' }}">
                            All Courses ({{ $counts['total'] }})
                        </a>
                        <a href="{{ url('/admin/courses?filter=visible') }}" class="admin-filter-pill {{ $currentFilter === 'visible' ? 'active' : '' }}" style="{{ $currentFilter === 'visible' ? 'background: #05B396; border-color: #05B396;' : '' }}">
                            👁️ Shown Only ({{ $counts['visible'] }})
                        </a>
                        <a href="{{ url('/admin/courses?filter=hidden') }}" class="admin-filter-pill {{ $currentFilter === 'hidden' ? 'active' : '' }}" style="{{ $currentFilter === 'hidden' ? 'background: #f59e0b; border-color: #f59e0b;' : '' }}">
                            🙈 Hidden Only ({{ $counts['hidden'] }})
                        </a>
                    </div>

                    <!-- Search Input -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 340px;">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search course title, instructor, tag..." style="width: 100%; padding: 0.55rem 0.9rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #7c3aed; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">Search</button>
                    </div>
                </form>
            </div>

            <!-- Course Management Table Card -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.8rem;">
                    <div>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Courses Control List ({{ count($courses) }})
                        </h3>
                        <span style="font-size: 0.8rem; color: #64748b;">
                            Toggle a course to <strong>Hide</strong> to instantly remove it from the user's "My Course" list.
                        </span>
                    </div>
                </div>

                @if($courses->isEmpty())
                    <div style="padding: 3.5rem 1.5rem; text-align: center;">
                        <div style="font-size: 2.8rem; margin-bottom: 0.6rem;">📚</div>
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.3rem;">No Courses Found</h4>
                        <p style="font-size: 0.88rem; color: #64748b;">Try adjusting your filter or search criteria.</p>
                    </div>
                @else
                    <!-- Desktop Table View (Hidden on mobile < 768px) -->
                    <div class="admin-courses-desktop-table" style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <th style="padding: 0.85rem 1.4rem;">Course Title &amp; Banner</th>
                                    <th style="padding: 0.85rem 1rem;">Instructor</th>
                                    <th style="padding: 0.85rem 1rem;">Lessons &amp; Duration</th>
                                    <th style="padding: 0.85rem 1rem;">My Course Status (Show / Hide)</th>
                                    <th style="padding: 0.85rem 1.4rem; text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $c)
                                    <tr id="course-row-{{ $c->id }}" style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#fbfcfe'" onmouseout="this.style.background='transparent'">
                                        <!-- Course Banner & Title -->
                                        <td style="padding: 1rem 1.4rem;">
                                            <div style="display: flex; gap: 12px; align-items: center;">
                                                <div style="width: 64px; height: 42px; border-radius: 6px; background: {{ $c->gradient ?: 'linear-gradient(135deg, #09090b, #1e1b4b)' }}; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.68rem; font-weight: 800; text-align: center; padding: 4px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                                                    {{ strtoupper(substr($c->banner_title ?: $c->title, 0, 10)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-bottom: 2px;">
                                                        {{ $c->title }}
                                                    </div>
                                                    <div style="font-size: 0.75rem; color: #64748b;">
                                                        Slug: <code>{{ $c->slug }}</code> • {{ $c->package_name ?: 'All Packages' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Instructor -->
                                        <td style="padding: 1rem 1rem;">
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                @if($c->instructor_avatar)
                                                    <img src="{{ $c->instructor_avatar }}" alt="{{ $c->instructor }}" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                                                @endif
                                                <span style="font-weight: 700; color: #334155;">{{ $c->instructor ?: 'SkillLearner Expert' }}</span>
                                            </div>
                                        </td>

                                        <!-- Lessons & Duration -->
                                        <td style="padding: 1rem 1rem;">
                                            <div style="font-weight: 700; color: #0f172a;">{{ $c->lessons }} Lessons</div>
                                            <div style="font-size: 0.75rem; color: #64748b;">⏱️ {{ $c->duration ?: 'Self-Paced' }}</div>
                                        </td>

                                        <!-- Show / Hide Toggle Control -->
                                        <td style="padding: 1rem 1rem;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <!-- The Toggle Button -->
                                                <button type="button" 
                                                        onclick="toggleCourseVisibility({{ $c->id }})" 
                                                        id="course-toggle-btn-{{ $c->id }}"
                                                        style="position: relative; width: 48px; height: 26px; border-radius: 20px; border: none; cursor: pointer; transition: background-color 0.25s ease; background-color: {{ $c->is_visible ? '#05B396' : '#cbd5e1' }}; padding: 2px;"
                                                        title="Click to toggle Show/Hide in My Course">
                                                    <span id="course-toggle-knob-{{ $c->id }}" style="position: absolute; top: 3px; left: {{ $c->is_visible ? '25px' : '3px' }}; width: 20px; height: 20px; border-radius: 50%; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.3); transition: left 0.25s ease;"></span>
                                                </button>

                                                <!-- Status Badge Text -->
                                                <div id="course-status-badge-{{ $c->id }}">
                                                    @if($c->is_visible)
                                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span>
                                                            👁️ Shown
                                                        </span>
                                                    @else
                                                        <span style="display: inline-flex; align-items: center; gap: 4px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #b45309;"></span>
                                                            🙈 Hidden
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Action / Direct View Link -->
                                        <td style="padding: 1rem 1.4rem; text-align: right;">
                                            <a href="{{ url('/classroom?course='.$c->slug) }}" target="_blank" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 5px 10px; border-radius: 6px; text-decoration: none; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                                Classroom ➔
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards View (Visible on mobile <= 768px, No Horizontal Scroll Needed) -->
                    <div class="admin-courses-mobile-list">
                        @foreach($courses as $c)
                            <div id="course-mcard-{{ $c->id }}" style="background: #ffffff; border: 1.5px solid {{ $c->is_visible ? '#e2e8f0' : '#fde68a' }}; border-radius: 14px; padding: 1.1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; flex-direction: column; gap: 0.85rem;">
                                <!-- Top Row: Banner + Title -->
                                <div style="display: flex; gap: 12px; align-items: flex-start;">
                                    <div style="width: 58px; height: 42px; border-radius: 8px; background: {{ $c->gradient ?: 'linear-gradient(135deg, #09090b, #1e1b4b)' }}; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.65rem; font-weight: 800; text-align: center; padding: 4px; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                                        {{ strtoupper(substr($c->banner_title ?: $c->title, 0, 8)) }}
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <h4 style="margin: 0 0 3px; font-size: 0.95rem; font-weight: 800; color: #0f172a; line-height: 1.3;">
                                            {{ $c->title }}
                                        </h4>
                                        <div style="font-size: 0.74rem; color: #64748b; display: flex; flex-wrap: wrap; gap: 6px;">
                                            <span>{{ $c->package_name ?: 'All Packages' }}</span>
                                            <span>•</span>
                                            <span>{{ $c->lessons }} Lessons</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Instructor & Duration Row -->
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: #475569; background: #f8fafc; padding: 6px 10px; border-radius: 8px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        @if($c->instructor_avatar)
                                            <img src="{{ $c->instructor_avatar }}" alt="{{ $c->instructor }}" style="width: 22px; height: 22px; border-radius: 50%; object-fit: cover;">
                                        @endif
                                        <span style="font-weight: 700;">{{ $c->instructor ?: 'SkillLearner Expert' }}</span>
                                    </div>
                                    <span style="color: #64748b;">⏱️ {{ $c->duration ?: 'Self-Paced' }}</span>
                                </div>

                                <!-- Show/Hide Mobile Control Strip -->
                                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.7rem; border-top: 1px solid #f1f5f9;">
                                    <div id="course-m-status-badge-{{ $c->id }}">
                                        @if($c->is_visible)
                                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span>
                                                👁️ Shown to Users
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #b45309;"></span>
                                                🙈 Hidden from Users
                                            </span>
                                        @endif
                                    </div>

                                    <!-- 1-Tap Toggle Button for Mobile -->
                                    <button type="button" 
                                            onclick="toggleCourseVisibility({{ $c->id }})" 
                                            id="course-m-toggle-btn-{{ $c->id }}"
                                            style="background: {{ $c->is_visible ? '#ecfdf5' : '#fef3c7' }}; color: {{ $c->is_visible ? '#059669' : '#b45309' }}; border: 1.5px solid {{ $c->is_visible ? '#a7f3d0' : '#fde68a' }}; padding: 7px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; min-height: 38px;">
                                        <span id="course-m-btn-text-{{ $c->id }}">{{ $c->is_visible ? 'Switch to Hide' : 'Switch to Show' }}</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

@push('styles')
<style>
    .admin-mobile-cards-wrap, .admin-courses-mobile-list { display: none; }
    @media (max-width: 768px) {
        .admin-courses-desktop-table { display: none !important; }
        .admin-courses-mobile-list { display: flex !important; flex-direction: column; gap: 0.9rem; padding: 0.85rem; }
    }
    @media (max-width: 600px) {
        .admin-stats-grid {
            grid-template-columns: 1fr !important;
        }
    }
    @media (min-width: 769px) {
        .admin-courses-desktop-table { display: block !important; }
        .admin-courses-mobile-list { display: none !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleCourseVisibility(courseId) {
        const btn = document.getElementById('course-toggle-btn-' + courseId);
        const knob = document.getElementById('course-toggle-knob-' + courseId);
        const badgeContainer = document.getElementById('course-status-badge-' + courseId);

        const mBtn = document.getElementById('course-m-toggle-btn-' + courseId);
        const mBtnText = document.getElementById('course-m-btn-text-' + courseId);
        const mBadge = document.getElementById('course-m-status-badge-' + courseId);
        const mCard = document.getElementById('course-mcard-' + courseId);

        if (btn) { btn.style.opacity = '0.6'; btn.disabled = true; }
        if (mBtn) { mBtn.style.opacity = '0.6'; mBtn.disabled = true; }

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
            if (btn) { btn.style.opacity = '1'; btn.disabled = false; }
            if (mBtn) { mBtn.style.opacity = '1'; mBtn.disabled = false; }

            if (data.success) {
                if (data.is_visible) {
                    if (btn && knob) {
                        btn.style.backgroundColor = '#05B396';
                        knob.style.left = '25px';
                    }
                    if (badgeContainer) {
                        badgeContainer.innerHTML = `
                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span>
                                👁️ Shown
                            </span>`;
                    }
                    if (mBtn && mBtnText) {
                        mBtn.style.background = '#ecfdf5';
                        mBtn.style.color = '#059669';
                        mBtn.style.borderColor = '#a7f3d0';
                        mBtnText.innerText = 'Switch to Hide';
                    }
                    if (mBadge) {
                        mBadge.innerHTML = `
                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span>
                                👁️ Shown to Users
                            </span>`;
                    }
                    if (mCard) {
                        mCard.style.borderColor = '#e2e8f0';
                    }
                } else {
                    if (btn && knob) {
                        btn.style.backgroundColor = '#cbd5e1';
                        knob.style.left = '3px';
                    }
                    if (badgeContainer) {
                        badgeContainer.innerHTML = `
                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 3px 9px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #b45309;"></span>
                                🙈 Hidden
                            </span>`;
                    }
                    if (mBtn && mBtnText) {
                        mBtn.style.background = '#fef3c7';
                        mBtn.style.color = '#b45309';
                        mBtn.style.borderColor = '#fde68a';
                        mBtnText.innerText = 'Switch to Show';
                    }
                    if (mBadge) {
                        mBadge.innerHTML = `
                            <span style="display: inline-flex; align-items: center; gap: 4px; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #b45309;"></span>
                                🙈 Hidden from Users
                            </span>`;
                    }
                    if (mCard) {
                        mCard.style.borderColor = '#fde68a';
                    }
                }
                showCourseLiveToast(data.message, '✅');
            } else {
                showCourseLiveToast('Could not toggle course visibility.', '⚠️');
            }
        })
        .catch(err => {
            if (btn) { btn.style.opacity = '1'; btn.disabled = false; }
            if (mBtn) { mBtn.style.opacity = '1'; mBtn.disabled = false; }
            showCourseLiveToast('Network error while toggling course.', '❌');
            console.error(err);
        });
    }

    function showCourseLiveToast(msg, icon) {
        const toast = document.getElementById('courseLiveToast');
        document.getElementById('courseToastMsg').innerText = msg;
        document.getElementById('courseToastIcon').innerText = icon || '✅';
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
