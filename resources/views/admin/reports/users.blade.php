@extends('layouts.app')

@section('title', 'Users Growth & Completion Report — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Navigation -->
    @include('portal.mobile-nav', ['active' => 'admin-reports'])

    <div class="portal-main-grid">
        <!-- Sidebar Navigation -->
        @include('portal.sidebar', ['active' => 'admin-reports'])

        <!-- Main Content Area -->
        <main class="portal-content-area">
            
            <!-- Shared Report Tabs & Filter Controls -->
            @include('admin.reports.tabs', ['activeReport' => 'users'])

            <!-- Top Row: User Growth & Completion Rate KPIs -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Registered Users</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin-top: 4px;">{{ $totalUsers }}</div>
                    <div style="font-size: 0.76rem; color: #05B396; font-weight: 700; margin-top: 2px;">+{{ $newUsersInRange }} in selected period</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Active vs Blocked</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #059669; margin-top: 4px;">{{ $activeUsers }} Active</div>
                    <div style="font-size: 0.76rem; color: {{ $blockedUsers > 0 ? '#ef4444' : '#64748b' }}; margin-top: 2px;">{{ $blockedUsers }} Blocked Accounts</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Course Completion Rate</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #7c3aed; margin-top: 4px;">{{ $overallCompletionRate }}%</div>
                    <div style="font-size: 0.76rem; color: #7c3aed; font-weight: 700; margin-top: 2px;">{{ $completedCount }} Courses Finished</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Average Student Progress</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #0284c7; margin-top: 4px;">{{ $avgProgress }}%</div>
                    <div style="font-size: 0.76rem; color: #64748b; margin-top: 2px;">Across all enrolled courses</div>
                </div>
            </div>

            <!-- Two-Column Section: Completion Funnel & Monthly User Growth -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                
                <!-- Card 1: Course Completion Funnel -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <h3 style="margin: 0 0 4px; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Course Completion Funnel</h3>
                    <p style="margin: 0 0 1.4rem; font-size: 0.8rem; color: #64748b;">Distribution of {{ $totalEnrollments }} total course enrollments</p>

                    @php
                        $completedPct = $totalEnrollments > 0 ? round(($completedCount / $totalEnrollments) * 100, 1) : 0;
                        $inProgressPct = $totalEnrollments > 0 ? round(($inProgressCount / $totalEnrollments) * 100, 1) : 0;
                        $notStartedPct = $totalEnrollments > 0 ? round(($notStartedCount / $totalEnrollments) * 100, 1) : 0;
                    @endphp

                    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                        <!-- Completed -->
                        <div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.86rem; margin-bottom: 5px;">
                                <strong style="color: #059669;">🏆 Completed (100% Progress)</strong>
                                <span style="font-weight: 800;">{{ $completedCount }} enrollments ({{ $completedPct }}%)</span>
                            </div>
                            <div style="width: 100%; height: 9px; background: #f1f5f9; border-radius: 6px; overflow: hidden;">
                                <div style="width: {{ $completedPct }}%; height: 100%; background: #10b981; border-radius: 6px;"></div>
                            </div>
                        </div>

                        <!-- In Progress -->
                        <div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.86rem; margin-bottom: 5px;">
                                <strong style="color: #0284c7;">📖 In Progress (1% — 99%)</strong>
                                <span style="font-weight: 800;">{{ $inProgressCount }} enrollments ({{ $inProgressPct }}%)</span>
                            </div>
                            <div style="width: 100%; height: 9px; background: #f1f5f9; border-radius: 6px; overflow: hidden;">
                                <div style="width: {{ $inProgressPct }}%; height: 100%; background: #0284c7; border-radius: 6px;"></div>
                            </div>
                        </div>

                        <!-- Not Started -->
                        <div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.86rem; margin-bottom: 5px;">
                                <strong style="color: #64748b;">⏳ Enrolled / Not Started (0%)</strong>
                                <span style="font-weight: 800;">{{ $notStartedCount }} enrollments ({{ $notStartedPct }}%)</span>
                            </div>
                            <div style="width: 100%; height: 9px; background: #f1f5f9; border-radius: 6px; overflow: hidden;">
                                <div style="width: {{ $notStartedPct }}%; height: 100%; background: #cbd5e1; border-radius: 6px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: User Growth by Month -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <h3 style="margin: 0 0 4px; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Monthly User Signups</h3>
                    <p style="margin: 0 0 1.4rem; font-size: 0.8rem; color: #64748b;">New student registration rate across recent calendar months</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 10px;">
                        @foreach($userGrowthMonthly as $ug)
                            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 1rem 0.8rem; text-align: center;">
                                <div style="font-size: 0.74rem; font-weight: 700; color: #64748b; text-transform: uppercase;">
                                    {{ $ug['month'] }}
                                </div>
                                <div style="font-size: 1.4rem; font-weight: 900; color: #05B396; margin-top: 4px;">
                                    +{{ $ug['count'] }}
                                </div>
                                <div style="font-size: 0.7rem; color: #94a3b8;">Students</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Student Progress Table -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 2rem;">
                <div style="padding: 1.4rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Student Progress &amp; Certificates</h3>
                        <p style="margin: 2px 0 0; font-size: 0.8rem; color: #64748b;">Individual student enrollments, completion status, and active qualifications</p>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.users') }}" class="btn" style="background: #f8fafc; color: #0f172a; font-size: 0.82rem; font-weight: 700; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 6px; text-decoration: none;">
                            👤 All Users
                        </a>
                        <a href="{{ route('admin.reports.export.csv', ['type' => 'users']) }}" class="btn" style="background: #05B396; color: #fff; font-size: 0.82rem; font-weight: 700; border: none; padding: 6px 14px; border-radius: 6px; text-decoration: none;">
                            📄 Export CSV
                        </a>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 12px 16px;">Student Name</th>
                                <th style="padding: 12px 16px;">Role</th>
                                <th style="padding: 12px 16px; text-align: center;">Enrolled Courses</th>
                                <th style="padding: 12px 16px;">Average Completion</th>
                                <th style="padding: 12px 16px;">Status</th>
                                <th style="padding: 12px 16px; text-align: right;">Joined Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $s)
                                @php
                                    $studentAvg = $s->userCourses->count() > 0 ? round($s->userCourses->avg('progress_percent')) : 0;
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px 16px;">
                                        <div style="font-weight: 800; color: #0f172a;">{{ $s->name }}</div>
                                        <div style="font-size: 0.76rem; color: #64748b;">{{ $s->email }}</div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <span style="background: #f1f5f9; color: #334155; font-size: 0.74rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
                                            {{ str_replace('_', ' ', $s->role) }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center; font-weight: 800; color: #0f172a;">
                                        {{ $s->user_courses_count }} Courses
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="flex-grow: 1; height: 7px; background: #f1f5f9; border-radius: 6px; overflow: hidden; min-width: 80px;">
                                                <div style="width: {{ $studentAvg }}%; height: 100%; background: {{ $studentAvg >= 100 ? '#10b981' : '#05B396' }}; border-radius: 6px;"></div>
                                            </div>
                                            <span style="font-weight: 800; font-size: 0.82rem; color: #0f172a; min-width: 36px; text-align: right;">
                                                {{ $studentAvg }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        @if($s->is_blocked)
                                            <span style="background: #fee2e2; color: #991b1b; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">BLOCKED</span>
                                        @else
                                            <span style="background: #ecfdf5; color: #059669; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">ACTIVE</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; color: #64748b; font-size: 0.8rem;">
                                        {{ $s->created_at ? $s->created_at->format('d M, Y') : 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                                        No registered students found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

@include('portal.styles')
@endsection

