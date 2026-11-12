@extends('layouts.app')

@section('title', 'Top Selling Courses & Packages Report — SkillLearner')

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
            @include('admin.reports.tabs', ['activeReport' => 'courses'])

            <!-- Top Row: Package Popularity & Revenue Grid -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.4rem; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #0f172a;">Package Sales &amp; Revenue Performance</h3>
                        <p style="margin: 2px 0 0; font-size: 0.82rem; color: #64748b;">Distribution across the 5 SkillLearner learning tracks</p>
                    </div>
                    <div style="font-size: 0.95rem; font-weight: 800; color: #05B396;">
                        Total Package Revenue: ₹{{ number_format($totalPackageRevenue, 2) }}
                    </div>
                </div>

                @php
                    $pkgBadges = [
                        'Basic Package' => ['color' => '#A855F7', 'icon' => '🟣'],
                        'Growth Package' => ['color' => '#10B981', 'icon' => '🟢'],
                        'Advance Package' => ['color' => '#06B6D4', 'icon' => '🔵'],
                        'Premium Package' => ['color' => '#F59E0B', 'icon' => '🟡'],
                        'Infinity Package' => ['color' => '#EC4899', 'icon' => '💖'],
                    ];
                @endphp

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    @forelse($packages as $pkg)
                        @php
                            $badge = $pkgBadges[$pkg->package_name] ?? ['color' => '#05B396', 'icon' => '📦'];
                            $pct = $totalPackageRevenue > 0 ? round(($pkg->total_revenue / $totalPackageRevenue) * 100, 1) : 0;
                        @endphp
                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.4rem; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: {{ $badge['color'] }};"></div>
                            <div>
                                <div style="font-size: 1.3rem; margin-bottom: 4px;">{{ $badge['icon'] }}</div>
                                <h4 style="margin: 0 0 4px; font-size: 1rem; font-weight: 800; color: #0f172a;">{{ $pkg->package_name }}</h4>
                                <div style="font-size: 0.8rem; color: #64748b;"><strong>{{ $pkg->units_sold }}</strong> Units Sold</div>
                            </div>
                            <div style="margin-top: 1.2rem; padding-top: 0.8rem; border-top: 1px dashed #cbd5e1;">
                                <div style="font-size: 1.25rem; font-weight: 900; color: #0f172a;">₹{{ number_format((float)$pkg->total_revenue, 2) }}</div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.76rem; color: #64748b; margin-top: 4px;">
                                    <span>Share: <strong style="color: {{ $badge['color'] }};">{{ $pct }}%</strong></span>
                                    <span>Avg: ₹{{ number_format((float)$pkg->avg_price) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 2rem;">
                            No package orders found in the selected date range.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Course-by-Course Enrollment & Completion Metrics -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 2rem;">
                <div style="padding: 1.4rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Course Enrollments &amp; Completion Rates</h3>
                        <p style="margin: 2px 0 0; font-size: 0.8rem; color: #64748b;">Engagement, progress, and completion velocity across all curriculum courses</p>
                    </div>
                    <a href="{{ route('admin.reports.export.csv', ['type' => 'courses', 'range' => $range]) }}" class="btn" style="background: #f8fafc; color: #0f172a; font-size: 0.82rem; font-weight: 700; border: 1px solid #cbd5e1; padding: 6px 14px; border-radius: 6px; text-decoration: none;">
                        📄 Export Courses CSV
                    </a>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 12px 16px;">Course Name</th>
                                <th style="padding: 12px 16px;">Domain Category</th>
                                <th style="padding: 12px 16px; text-align: right;">Catalog Price</th>
                                <th style="padding: 12px 16px; text-align: center;">Enrolled Students</th>
                                <th style="padding: 12px 16px; text-align: center;">Completed (100%)</th>
                                <th style="padding: 12px 16px; text-align: center;">In Progress</th>
                                <th style="padding: 12px 16px;">Completion %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $c)
                                @php
                                    $compRate = $c->total_enrolled > 0 ? round(($c->completed_count / $c->total_enrolled) * 100, 1) : 0;
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px 16px;">
                                        <strong style="color: #0f172a; font-size: 0.92rem;">{{ $c->title }}</strong>
                                        <div style="font-size: 0.75rem; color: #94a3b8; font-family: monospace;">{{ $c->slug }}</div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <span style="display: inline-block; background: rgba(5, 179, 150, 0.1); color: #05B396; font-size: 0.76rem; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                                            {{ $c->category ?: 'General' }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #0f172a;">
                                        ₹{{ number_format((float)$c->price, 2) }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="font-weight: 900; font-size: 1rem; color: #0f172a;">{{ $c->total_enrolled }}</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #ecfdf5; color: #059669; font-weight: 800; font-size: 0.78rem; padding: 3px 8px; border-radius: 4px;">
                                            {{ $c->completed_count }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center; color: #64748b; font-weight: 600;">
                                        {{ $c->in_progress_count }}
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="flex-grow: 1; height: 7px; background: #f1f5f9; border-radius: 6px; overflow: hidden; min-width: 70px;">
                                                <div style="width: {{ $compRate }}%; height: 100%; background: #05B396; border-radius: 6px;"></div>
                                            </div>
                                            <span style="font-weight: 800; font-size: 0.82rem; color: #05B396; min-width: 36px; text-align: right;">{{ $compRate }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                                        No courses found in database.
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

