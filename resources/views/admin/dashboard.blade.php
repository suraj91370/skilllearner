@extends('layouts.app')

@section('title', 'Super Admin Revenue & Operations Dashboard — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-dashboard'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-dashboard'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header & Welcome Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.65rem; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 10px;">
                        <span>🏢 Super Admin Revenue &amp; Operations</span>
                    </h2>
                    <p style="font-size: 0.92rem; color: #64748b; margin: 0;">
                        Monitor total platform sales revenue, active &amp; passive income distribution, and verify referral order payments.
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ url('/admin/users') }}" class="btn" style="background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1rem; border-radius: 8px; text-decoration: none;">
                        👥 Manage Users
                    </a>
                    <a href="{{ url('/admin/settings') }}" class="btn" style="background: #05B396; color: #fff; font-size: 0.85rem; font-weight: 700; padding: 0.55rem 1.1rem; border-radius: 8px; text-decoration: none;">
                        ⚙️ Platform Settings
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.94rem; font-weight: 600; box-shadow: 0 2px 6px rgba(5, 179, 150, 0.1);">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.94rem; font-weight: 600;">
                    ℹ️ {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.94rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- 1. Executive Financial Summary Cards (6 KPIs) -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1.1rem; margin-bottom: 1.8rem;">
                
                <!-- KPI 1: Gross Platform Revenue -->
                <div class="admin-stat-card" style="border-top: 4px solid #05B396; background: #ffffff; border-radius: 12px; padding: 1.4rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #05B396; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 6px;">
                        📈 TOTAL PLATFORM REVENUE
                    </div>
                    <div style="font-size: 1.85rem; font-weight: 900; color: #0f172a; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['total_revenue']) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Gross sales from all package enrollments
                    </div>
                </div>

                <!-- KPI 2: Total Active Income -->
                <div class="admin-stat-card" style="border-top: 4px solid #10b981; background: #ffffff; border-radius: 12px; padding: 1.4rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #10b981; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 6px;">
                        ⚡ TOTAL ACTIVE INCOME
                    </div>
                    <div style="font-size: 1.85rem; font-weight: 900; color: #10b981; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['total_active_income']) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Paid to Tier-1 direct referral sponsors
                    </div>
                </div>

                <!-- KPI 3: Total Passive Income -->
                <div class="admin-stat-card" style="border-top: 4px solid #7c3aed; background: #ffffff; border-radius: 12px; padding: 1.4rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #7c3aed; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 6px;">
                        💎 TOTAL PASSIVE INCOME
                    </div>
                    <div style="font-size: 1.85rem; font-weight: 900; color: #7c3aed; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['total_passive_income']) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Paid to Tier-2 team referral sponsors
                    </div>
                </div>

                <!-- KPI 4: Net Retained Profit -->
                <div class="admin-stat-card" style="border-top: 4px solid #0284c7; background: #ffffff; border-radius: 12px; padding: 1.4rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #0284c7; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 6px;">
                        🛡️ NET PLATFORM PROFIT
                    </div>
                    <div style="font-size: 1.85rem; font-weight: 900; color: #0284c7; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['net_retained_profit']) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Revenue retained after commission payout
                    </div>
                </div>

                <!-- KPI 5: Pending Commission Queue -->
                <div class="admin-stat-card" style="border-top: 4px solid #f59e0b; background: #fffbeb; border-radius: 12px; padding: 1.4rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #fde68a;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #b45309; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 6px;">
                        ⏳ PENDING APPROVALS
                    </div>
                    <div style="font-size: 1.85rem; font-weight: 900; color: #b45309; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['pending_amount']) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #92400e; font-weight: 700;">
                        {{ $stats['pending_count'] }} orders awaiting payment check
                    </div>
                </div>

                <!-- KPI 6: Total Commissions Paid -->
                <div class="admin-stat-card" style="border-top: 4px solid #64748b; background: #ffffff; border-radius: 12px; padding: 1.4rem; box-shadow: 0 4px 14px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.76rem; font-weight: 800; color: #64748b; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 6px;">
                        📊 TOTAL COMMISSIONS PAID
                    </div>
                    <div style="font-size: 1.85rem; font-weight: 900; color: #1e293b; line-height: 1.2; margin-bottom: 4px;">
                        ₹{{ number_format($stats['total_commissions_paid']) }}
                    </div>
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Active + Passive combined payout
                    </div>
                </div>

            </div>

            <!-- 2. Package Sales Volume Breakdown -->
            <div class="portal-box-card" style="margin-bottom: 2rem;">
                <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.3rem;">
                    📦 Package Sales Performance
                </h4>
                <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.2rem;">
                    Breakdown of student enrollments and earnings generated across the 5 core packages.
                </p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                    @php
                        $packagesRef = [
                            ['name' => 'Basic Package', 'price' => 599, 'active' => 420, 'passive' => 50, 'color' => '#8b5cf6'],
                            ['name' => 'Growth Package', 'price' => 1199, 'active' => 840, 'passive' => 100, 'color' => '#10b981'],
                            ['name' => 'Advance Package', 'price' => 2499, 'active' => 1900, 'passive' => 200, 'color' => '#0284c7'],
                            ['name' => 'Premium Package', 'price' => 4999, 'active' => 3800, 'passive' => 400, 'color' => '#f59e0b'],
                            ['name' => 'Infinity Package', 'price' => 7999, 'active' => 5500, 'passive' => 500, 'color' => '#ef4444'],
                        ];
                    @endphp

                    @foreach($packagesRef as $p)
                        @php
                            $ordersCount = $stats['package_breakdown'][$p['name']] ?? 0;
                            $pkgRev = $ordersCount * $p['price'];
                        @endphp
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.1rem; border-top: 3px solid {{ $p['color'] }};">
                            <div style="font-size: 0.88rem; font-weight: 800; color: #0f172a; margin-bottom: 2px;">
                                {{ $p['name'] }}
                            </div>
                            <div style="font-size: 0.82rem; color: #64748b; font-weight: 600; margin-bottom: 8px;">
                                Price: ₹{{ number_format($p['price']) }}
                            </div>
                            <div style="font-size: 0.76rem; color: #059669; font-weight: 700; margin-bottom: 2px;">
                                ⚡ Active: ₹{{ number_format($p['active']) }}
                            </div>
                            <div style="font-size: 0.76rem; color: #7c3aed; font-weight: 700; margin-bottom: 8px;">
                                💎 Passive: ₹{{ number_format($p['passive']) }}
                            </div>
                            <div style="border-top: 1px dashed #cbd5e1; padding-top: 6px; display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700;">
                                <span style="color: #64748b;">Orders:</span>
                                <span style="color: #0f172a;">{{ $ordersCount }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3. Payment Verification & Commission Approvals Table -->
            <div class="portal-box-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
                            💳 Referral Sales &amp; Payment Verification Center
                        </h4>
                        <p style="font-size: 0.86rem; color: #64748b; margin: 0;">
                            When users refer a student, verify payment before approving. Approving instantly credits the sponsor's wallet balance!
                        </p>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ url('/admin') }}" style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <input type="hidden" name="status" value="{{ $currentFilter }}">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search buyer or sponsor..." style="padding: 0.55rem 0.9rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.86rem; min-width: 220px;">
                        <button type="submit" class="btn btn-primary" style="background: #05B396; color: #fff; padding: 0.55rem 1rem; font-size: 0.86rem; font-weight: 700; border-radius: 8px;">Search</button>
                        @if($search)
                            <a href="{{ url('/admin?status=' . $currentFilter) }}" class="btn" style="background: #f1f5f9; color: #64748b; padding: 0.55rem 0.9rem; font-size: 0.86rem; border-radius: 8px; text-decoration: none;">Clear</a>
                        @endif
                    </form>
                </div>

                <!-- Filter Tabs -->
                <div style="display: flex; gap: 8px; margin-bottom: 1.4rem; flex-wrap: wrap; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.8rem;">
                    <a href="{{ url('/admin?status=all' . ($search ? '&search=' . $search : '')) }}" 
                       style="padding: 6px 14px; border-radius: 20px; font-size: 0.84rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'all' ? 'background: #0f172a; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                        All Commissions ({{ $counts['total'] }})
                    </a>
                    <a href="{{ url('/admin?status=pending' . ($search ? '&search=' . $search : '')) }}" 
                       style="padding: 6px 14px; border-radius: 20px; font-size: 0.84rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'pending' ? 'background: #f59e0b; color: #fff;' : 'background: #fffbeb; color: #b45309; border: 1px solid #fde68a;' }}">
                        ⏳ Pending Approvals ({{ $counts['pending'] }})
                    </a>
                    <a href="{{ url('/admin?status=credited' . ($search ? '&search=' . $search : '')) }}" 
                       style="padding: 6px 14px; border-radius: 20px; font-size: 0.84rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'credited' ? 'background: #10b981; color: #fff;' : 'background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;' }}">
                        ✅ Credited / Approved ({{ $counts['credited'] }})
                    </a>
                    <a href="{{ url('/admin?status=rejected' . ($search ? '&search=' . $search : '')) }}" 
                       style="padding: 6px 14px; border-radius: 20px; font-size: 0.84rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'rejected' ? 'background: #ef4444; color: #fff;' : 'background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;' }}">
                        ❌ Rejected ({{ $counts['rejected'] }})
                    </a>
                </div>

                <!-- Table -->
                <div class="table-responsive-wrapper">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b; background: #f8fafc;">
                                <th style="padding: 12px 14px;">ID &amp; Date</th>
                                <th style="padding: 12px 14px;">Buyer (Student)</th>
                                <th style="padding: 12px 14px;">Package Bought</th>
                                <th style="padding: 12px 14px;">Sponsor (Affiliate)</th>
                                <th style="padding: 12px 14px;">Commission Type</th>
                                <th style="padding: 12px 14px;">Amount</th>
                                <th style="padding: 12px 14px;">Status</th>
                                <th style="padding: 12px 14px; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commissions as $comm)
                                @php
                                    $isPassive = str_contains(strtolower($comm->commission_type), 'passive');
                                    $statusLower = strtolower($comm->status);
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b; background: {{ $statusLower === 'pending' ? 'rgba(254, 243, 199, 0.25)' : '#ffffff' }};">
                                    <td style="padding: 14px;">
                                        <strong style="color: #0f172a;">#{{ $comm->id }}</strong>
                                        <div style="font-size: 0.78rem; color: #94a3b8;">
                                            {{ $comm->created_at ? $comm->created_at->format('d M Y, h:i A') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td style="padding: 14px;">
                                        <div style="font-weight: 700; color: #0f172a;">{{ $comm->buyer_name }}</div>
                                        <span style="font-size: 0.76rem; color: #64748b;">Referred Lead</span>
                                    </td>
                                    <td style="padding: 14px;">
                                        <div style="font-weight: 700; color: #334155;">{{ $comm->package_name }}</div>
                                    </td>
                                    <td style="padding: 14px;">
                                        <div style="font-weight: 700; color: #0f172a;">
                                            {{ $comm->user?->name ?? 'User #' . $comm->user_id }}
                                        </div>
                                        <div style="font-size: 0.78rem; color: #05B396; font-weight: 700;">
                                            ID: {{ $comm->user?->affiliate_id ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td style="padding: 14px;">
                                        <span style="background: {{ $isPassive ? '#ede9fe' : '#ccfbf1' }}; color: {{ $isPassive ? '#6d28d9' : '#048873' }}; padding: 3px 9px; border-radius: 4px; font-size: 0.76rem; font-weight: 700; display: inline-block;">
                                            {{ $comm->commission_type }}
                                        </span>
                                    </td>
                                    <td style="padding: 14px; font-weight: 900; font-size: 1rem; color: {{ $isPassive ? '#7c3aed' : '#059669' }};">
                                        ₹{{ number_format($comm->amount) }}
                                    </td>
                                    <td style="padding: 14px;">
                                        @if($statusLower === 'pending')
                                            <span style="background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 800; border: 1px solid #fde68a; display: inline-flex; align-items: center; gap: 4px;">
                                                ⏳ Pending Verification
                                            </span>
                                        @elseif($statusLower === 'credited')
                                            <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 800; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 4px;">
                                                ✅ Credited (In Wallet)
                                            </span>
                                        @else
                                            <span style="background: #fee2e2; color: #b91c1c; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 800; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 4px;">
                                                ✕ Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 14px; text-align: right;">
                                        @if($statusLower === 'pending')
                                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                                <!-- Approve & Credit Button -->
                                                <form method="POST" action="{{ route('admin.commissions.approve', $comm->id) }}" onsubmit="return confirm('Verify payment and credit ₹{{ number_format($comm->amount) }} to {{ addslashes($comm->user?->name) }}\'s wallet balance?');" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" style="background: #05B396; color: #ffffff; padding: 6px 12px; font-size: 0.78rem; font-weight: 800; border-radius: 6px; border: none; cursor: pointer; white-space: nowrap;">
                                                        ✓ Verify &amp; Credit
                                                    </button>
                                                </form>

                                                <!-- Reject Button -->
                                                <form method="POST" action="{{ route('admin.commissions.reject', $comm->id) }}" onsubmit="return confirm('Reject this commission? (No money will be added to the wallet)');" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 10px; font-size: 0.78rem; font-weight: 700; border-radius: 6px; cursor: pointer;">
                                                        ✕
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($statusLower === 'credited')
                                            <span style="color: #10b981; font-size: 0.8rem; font-weight: 700;">
                                                ● Verified
                                            </span>
                                        @else
                                            <span style="color: #94a3b8; font-size: 0.8rem; font-weight: 600;">
                                                No Action
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📭</div>
                                        <strong style="color: #475569;">No commissions found matching your criteria.</strong>
                                        <p style="font-size: 0.84rem; margin: 4px 0 0;">When referral purchases occur, they will appear here for payment verification.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($commissions instanceof \Illuminate\Pagination\LengthAwarePaginator && $commissions->hasPages())
                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                        {{ $commissions->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

@include('portal.styles')
@endsection

