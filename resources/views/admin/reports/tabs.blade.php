<div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.4rem 1.6rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
    <!-- Top Row: Title + Filter Controls + Export Dropdown -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.2rem;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(5, 179, 150, 0.1); color: #05B396; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                📈 Analytics &amp; Intelligence Hub
            </div>
            <h2 style="margin: 0; font-size: 1.6rem; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">
                Reports &amp; Analytics
            </h2>
            <div style="font-size: 0.85rem; color: #64748b; margin-top: 2px;">
                Filter Period: <strong style="color: #05B396;">{{ $rangeLabel }}</strong> ({{ $start->format('d M, Y') }} — {{ $end->format('d M, Y') }})
            </div>
        </div>

        <!-- Export Dropdown & Quick Actions -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Custom Date Filter Trigger -->
            <button type="button" onclick="document.getElementById('customDateModal').style.display='flex'" class="btn" style="background: #f1f5f9; color: #334155; font-weight: 700; font-size: 0.85rem; padding: 8px 14px; border-radius: 8px; border: 1px solid #cbd5e1; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                📅 Custom Date
            </button>

            <!-- Export Buttons -->
            @php
                $currentExportType = match($activeReport ?? 'index') {
                    'revenue' => 'revenue',
                    'courses' => 'courses',
                    'mentors' => 'mentors',
                    'users' => 'users',
                    default => 'revenue',
                };
            @endphp

            <div style="position: relative; display: inline-block;">
                <button type="button" onclick="toggleExportMenu()" class="btn" style="background: #05B396; color: #fff; font-weight: 800; font-size: 0.88rem; padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.25);">
                    <span>📥 Export Report</span>
                    <span style="font-size: 0.7rem;">▼</span>
                </button>
                <div id="exportMenuDropdown" style="display: none; position: absolute; right: 0; top: 110%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.12); width: 220px; z-index: 999; overflow: hidden;">
                    <a href="{{ route('admin.reports.export.excel', ['type' => $currentExportType, 'range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; color: #0f172a; text-decoration: none; font-size: 0.86rem; font-weight: 600; border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <span style="color: #10b981; font-weight: 800;">📗 Excel (.xls)</span>
                    </a>
                    <a href="{{ route('admin.reports.export.csv', ['type' => $currentExportType, 'range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; color: #0f172a; text-decoration: none; font-size: 0.86rem; font-weight: 600; border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <span style="color: #0284c7; font-weight: 800;">📄 CSV Format</span>
                    </a>
                    <a href="{{ route('admin.reports.export.pdf', ['type' => $currentExportType, 'range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" target="_blank" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; color: #0f172a; text-decoration: none; font-size: 0.86rem; font-weight: 600;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <span style="color: #ef4444; font-weight: 800;">🖨️ Print / PDF Report</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Date Filter Pills -->
    <div style="display: flex; gap: 6px; overflow-x: auto; padding-bottom: 8px; margin-bottom: 1.2rem; border-bottom: 1px dashed #e2e8f0;">
        @php
            $currentRoute = request()->route()->getName();
            $dateFilters = [
                'today' => 'Today',
                'yesterday' => 'Yesterday',
                '7days' => 'Last 7 Days',
                '30days' => 'Last 30 Days',
                'this_month' => 'This Month',
                'last_month' => 'Last Month',
                'this_year' => 'This Year',
                'all_time' => 'All Time',
            ];
        @endphp
        @foreach($dateFilters as $dKey => $dTitle)
            <a href="{{ route($currentRoute, array_merge(request()->query(), ['range' => $dKey])) }}" 
               style="padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; text-decoration: none; white-space: nowrap; transition: all 0.2s; {{ $range === $dKey ? 'background: #0f172a; color: #ffffff;' : 'background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;' }}">
                {{ $dTitle }}
            </a>
        @endforeach
    </div>

    <!-- Sub-navigation Tabs -->
    <div style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px;">
        <a href="{{ route('admin.reports.index', ['range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
           style="padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ ($activeReport ?? 'index') === 'index' ? 'background: #05B396; color: #fff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
            📊 Executive Overview
        </a>
        <a href="{{ route('admin.reports.revenue', ['range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
           style="padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ ($activeReport ?? '') === 'revenue' ? 'background: #05B396; color: #fff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
            💰 Sales &amp; Revenue
        </a>
        <a href="{{ route('admin.reports.courses', ['range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
           style="padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ ($activeReport ?? '') === 'courses' ? 'background: #05B396; color: #fff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
            🎓 Top Selling Courses
        </a>
        <a href="{{ route('admin.reports.mentors', ['range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
           style="padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ ($activeReport ?? '') === 'mentors' ? 'background: #05B396; color: #fff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
            👥 Mentor-wise Earnings
        </a>
        <a href="{{ route('admin.reports.users', ['range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
           style="padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; {{ ($activeReport ?? '') === 'users' ? 'background: #05B396; color: #fff;' : 'background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;' }}">
            📈 User Growth &amp; Completion
        </a>
    </div>
</div>

<!-- Custom Date Range Modal -->
<div id="customDateModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 9999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 440px; width: 100%; box-shadow: 0 25px 60px rgba(0,0,0,0.3); border: 1.5px solid #05B396; overflow: hidden;">
        <div style="background: #0f172a; padding: 1rem 1.4rem; color: #ffffff; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span>📅</span>
                <strong style="font-size: 1rem;">Filter by Custom Date Range</strong>
            </div>
            <button type="button" onclick="document.getElementById('customDateModal').style.display='none'" style="background: transparent; border: none; color: #fff; font-size: 1.2rem; cursor: pointer;">&times;</button>
        </div>
        <form method="GET" action="{{ route($currentRoute) }}" style="padding: 1.5rem;">
            <input type="hidden" name="range" value="custom">
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">From Date (Start)</label>
                <input type="date" name="start_date" value="{{ request('start_date', $start->format('Y-m-d')) }}" required style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">To Date (End)</label>
                <input type="date" name="end_date" value="{{ request('end_date', $end->format('Y-m-d')) }}" required style="width: 100%; padding: 9px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem;">
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('customDateModal').style.display='none'" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 700; font-size: 0.85rem; padding: 8px 14px; border-radius: 8px; border: 1px solid #cbd5e1; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn" style="background: #05B396; color: #fff; font-weight: 800; font-size: 0.85rem; padding: 8px 18px; border-radius: 8px; border: none; cursor: pointer;">
                    Apply Range ➔
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleExportMenu() {
        const menu = document.getElementById('exportMenuDropdown');
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('exportMenuDropdown');
        if (dropdown && !e.target.closest('#exportMenuDropdown') && !e.target.closest('button[onclick="toggleExportMenu()"]')) {
            dropdown.style.display = 'none';
        }
    });
</script>

