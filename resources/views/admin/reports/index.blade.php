@extends('layouts.app')

@section('title', 'Reports & Analytics — SkillLearner')

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
            @include('admin.reports.tabs', ['activeReport' => 'index'])

            <!-- Top Row: 4 Primary KPI Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
                <!-- Gross Revenue -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 14px;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(5, 179, 150, 0.12); color: #05B396; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        💰
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Gross Revenue</div>
                        <div style="font-size: 1.7rem; font-weight: 900; color: #0f172a; line-height: 1.2;">₹{{ number_format($grossRevenue, 2) }}</div>
                        <div style="font-size: 0.76rem; color: #05B396; font-weight: 700; margin-top: 2px;">{{ $paidOrdersCount }} Paid Orders</div>
                    </div>
                </div>

                <!-- Net Revenue -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 14px;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(11, 79, 74, 0.12); color: #0B4F4A; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        💳
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Net Revenue</div>
                        <div style="font-size: 1.7rem; font-weight: 900; color: #0B4F4A; line-height: 1.2;">₹{{ number_format($netRevenue, 2) }}</div>
                        <div style="font-size: 0.76rem; color: #64748b; font-weight: 600; margin-top: 2px;">After ₹{{ number_format($refundedAmount, 2) }} refunds</div>
                    </div>
                </div>

                <!-- Average Order Value (AOV) -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 14px;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(2, 132, 199, 0.12); color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        📊
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Avg Order Value</div>
                        <div style="font-size: 1.7rem; font-weight: 900; color: #0f172a; line-height: 1.2;">₹{{ number_format($avgOrderValue, 2) }}</div>
                        <div style="font-size: 0.76rem; color: #0284c7; font-weight: 700; margin-top: 2px;">Per Checkout</div>
                    </div>
                </div>

                <!-- Platform Completion Rate -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 14px;">
                    <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        🎖️
                    </div>
                    <div>
                        <div style="font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Completion Rate</div>
                        <div style="font-size: 1.7rem; font-weight: 900; color: #7c3aed; line-height: 1.2;">{{ $overallCompletionRate }}%</div>
                        <div style="font-size: 0.76rem; color: #64748b; font-weight: 600; margin-top: 2px;">Avg Progress: {{ $avgPlatformProgress }}%</div>
                    </div>
                </div>
            </div>

            <!-- Middle Section: Interactive Daily Sales Trend Chart -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">Daily Sales &amp; Revenue Trend</h3>
                        <p style="margin: 2px 0 0; font-size: 0.82rem; color: #64748b;">Daily transaction volume and revenue curve across the selected timeframe</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 14px; font-size: 0.82rem; font-weight: 700;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; color: #05B396;">
                            <span style="width: 12px; height: 12px; background: #05B396; border-radius: 3px;"></span> Revenue (₹)
                        </span>
                        <span style="display: inline-flex; align-items: center; gap: 6px; color: #0284c7;">
                            <span style="width: 12px; height: 12px; background: #0284c7; border-radius: 3px;"></span> Orders
                        </span>
                    </div>
                </div>

                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            <!-- Two-Column Grid: Packages Share & Top Performing Courses -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                
                <!-- Card 1: Package Sales Distribution -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Package Sales Share</h3>
                        <a href="{{ route('admin.reports.courses') }}" style="color: #05B396; font-size: 0.82rem; font-weight: 700; text-decoration: none;">View Detailed →</a>
                    </div>

                    @php
                        $pkgColors = [
                            'Basic Package' => '#A855F7',
                            'Growth Package' => '#10B981',
                            'Advance Package' => '#06B6D4',
                            'Premium Package' => '#F59E0B',
                            'Infinity Package' => '#EC4899',
                        ];
                    @endphp

                    <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                        @forelse($packageBreakdown as $pkg)
                            @php
                                $pkgColor = $pkgColors[$pkg->package_name] ?? '#05B396';
                                $pct = $grossRevenue > 0 ? round(($pkg->revenue / $grossRevenue) * 100, 1) : 0;
                            @endphp
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: 0.88rem;">
                                    <span style="font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                                        <span style="width: 10px; height: 10px; border-radius: 50%; background: {{ $pkgColor }};"></span>
                                        {{ $pkg->package_name }}
                                    </span>
                                    <span style="color: #64748b; font-size: 0.82rem;">
                                        <strong>{{ $pkg->count }} sold</strong> · ₹{{ number_format((float)$pkg->revenue, 2) }} ({{ $pct }}%)
                                    </span>
                                </div>
                                <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 6px; overflow: hidden;">
                                    <div style="width: {{ $pct }}%; height: 100%; background: {{ $pkgColor }}; border-radius: 6px;"></div>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; color: #94a3b8; padding: 2.5rem 0;">
                                📦 No package sales in this period.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Card 2: Top Selling Courses -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Top Selling Courses</h3>
                        <a href="{{ route('admin.reports.courses') }}" style="color: #05B396; font-size: 0.82rem; font-weight: 700; text-decoration: none;">All Courses →</a>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @forelse($topCourses as $tc)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #f1f5f9;">
                                <div>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">{{ $tc->title }}</div>
                                    <div style="font-size: 0.78rem; color: #64748b;">
                                        {{ $tc->category ?: 'General' }} · <strong>{{ $tc->total_enrolled }} Enrolled</strong>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: inline-block; background: rgba(5, 179, 150, 0.12); color: #05B396; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">
                                        {{ round((float)$tc->avg_progress) }}% Avg Progress
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; color: #94a3b8; padding: 2.5rem 0;">
                                🎓 No course enrollments recorded.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Bottom Row: Mentors Overview & User Growth Summary -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                
                <!-- Mentors Earnings Leaderboard -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Top Earning Mentors</h3>
                        <a href="{{ route('admin.reports.mentors') }}" style="color: #05B396; font-size: 0.82rem; font-weight: 700; text-decoration: none;">View All Mentors →</a>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($topMentors as $m)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: #fafafa; border-radius: 10px; border: 1px solid #f1f5f9;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #0B4F4A; color: #fff; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                        {{ strtoupper(substr($m->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.92rem;">{{ $m->name }}</div>
                                        <div style="font-size: 0.78rem; color: #64748b;">{{ $m->commission_percentage }}% Commission</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.95rem; font-weight: 900; color: #05B396;">₹{{ number_format((float)$m->total_earned, 2) }}</div>
                                    <div style="font-size: 0.74rem; color: #64748b;">Wallet: ₹{{ number_format((float)$m->wallet_balance, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- User Growth & Platform Cohort -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">User Base &amp; Growth</h3>
                            <a href="{{ route('admin.reports.users') }}" style="color: #05B396; font-size: 0.82rem; font-weight: 700; text-decoration: none;">Users Report →</a>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center; margin-bottom: 1.5rem;">
                            <div style="background: #f8fafc; padding: 1rem; border-radius: 10px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Total Students</div>
                                <div style="font-size: 1.5rem; font-weight: 900; color: #0f172a; margin-top: 2px;">{{ $totalUsers }}</div>
                            </div>
                            <div style="background: #f0fdf9; padding: 1rem; border-radius: 10px; border: 1px solid #a7f3d0;">
                                <div style="font-size: 0.75rem; color: #05B396; font-weight: 700; text-transform: uppercase;">New in Period</div>
                                <div style="font-size: 1.5rem; font-weight: 900; color: #05B396; margin-top: 2px;">+{{ $newUsersInRange }}</div>
                            </div>
                            <div style="background: #f8fafc; padding: 1rem; border-radius: 10px; border: 1px solid #e2e8f0;">
                                <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Active Ratio</div>
                                <div style="font-size: 1.5rem; font-weight: 900; color: #0284c7; margin-top: 2px;">
                                    {{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0 }}%
                                </div>
                            </div>
                        </div>

                        <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin: 0;">
                            New student signups are tracked automatically during checkout and affiliate link registrations. Active status reflects students with unblocked credentials.
                        </p>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.8rem; color: #64748b;">Need raw user rows?</span>
                        <a href="{{ route('admin.reports.export.csv', ['type' => 'users']) }}" class="btn" style="background: #f1f5f9; color: #0f172a; font-size: 0.8rem; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-decoration: none; border: 1px solid #cbd5e1;">
                            Download User CSV ➔
                        </a>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

<!-- Chart.js Script for Smooth Sales Curve -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trendData = @json($dailyTrend);
        const labels = trendData.map(d => d.label);
        const revenues = trendData.map(d => d.revenue);
        const orders = trendData.map(d => d.orders);

        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Gross Revenue (₹)',
                        data: revenues,
                        borderColor: '#05B396',
                        backgroundColor: 'rgba(5, 179, 150, 0.1)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Orders Count',
                        data: orders,
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.08)',
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: false,
                        tension: 0.2,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#64748b' }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { size: 11 },
                            color: '#64748b',
                            callback: function(value) { return '₹' + value; }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: {
                            font: { size: 11 },
                            color: '#0284c7',
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>

@include('portal.styles')
@endsection

