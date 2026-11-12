@extends('layouts.app')

@section('title', 'Mentor Earnings Report — SkillLearner')

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
            @include('admin.reports.tabs', ['activeReport' => 'mentors'])

            <!-- Top Row: Mentor Financial Aggregates -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Mentor Earnings</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #05B396; margin-top: 4px;">₹{{ number_format($totalMentorEarnings, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #64748b; margin-top: 2px;">Cumulative Revenue Share</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Processed Payouts</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #0B4F4A; margin-top: 4px;">₹{{ number_format($totalProcessedPayouts, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #059669; font-weight: 700; margin-top: 2px;">Transferred to Bank/UPI</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Pending Wallet Balances</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #d97706; margin-top: 4px;">₹{{ number_format($totalPendingWallets, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #d97706; font-weight: 700; margin-top: 2px;">Awaiting Withdrawal</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Faculty Count</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #7c3aed; margin-top: 4px;">{{ count($mentors) }} Mentors</div>
                    <div style="font-size: 0.76rem; color: #7c3aed; font-weight: 700; margin-top: 2px;">Active Instructors</div>
                </div>
            </div>

            <!-- Mentor Earnings Table -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 2rem;">
                <div style="padding: 1.4rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Mentor Commission &amp; Earnings Report</h3>
                        <p style="margin: 2px 0 0; font-size: 0.8rem; color: #64748b;">Individual commission percentages, cumulative earnings, and bank balances</p>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.mentors') }}" class="btn" style="background: #f8fafc; color: #0f172a; font-size: 0.82rem; font-weight: 700; border: 1px solid #cbd5e1; padding: 6px 12px; border-radius: 6px; text-decoration: none;">
                            👥 Manage Mentors
                        </a>
                        <a href="{{ route('admin.reports.export.csv', ['type' => 'mentors', 'range' => $range]) }}" class="btn" style="background: #05B396; color: #fff; font-size: 0.82rem; font-weight: 700; border: none; padding: 6px 14px; border-radius: 6px; text-decoration: none;">
                            📄 Export CSV
                        </a>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 12px 16px;">Mentor Name</th>
                                <th style="padding: 12px 16px;">Assigned Courses</th>
                                <th style="padding: 12px 16px; text-align: center;">Commission %</th>
                                <th style="padding: 12px 16px; text-align: right;">Total Earned</th>
                                <th style="padding: 12px 16px; text-align: right;">Processed Payouts</th>
                                <th style="padding: 12px 16px; text-align: right;">Wallet Balance</th>
                                <th style="padding: 12px 16px; text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mentors as $m)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px 16px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 38px; height: 38px; border-radius: 50%; background: #0B4F4A; color: #fff; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 0.95rem;">
                                                {{ strtoupper(substr($m['name'], 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 800; color: #0f172a; font-size: 0.92rem;">{{ $m['name'] }}</div>
                                                <div style="font-size: 0.76rem; color: #64748b;">{{ $m['email'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px; max-width: 250px;">
                                        @if(!empty($m['assigned_courses']))
                                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                                @foreach(array_slice($m['assigned_courses'], 0, 3) as $cName)
                                                    <span style="background: #f1f5f9; color: #475569; font-size: 0.74rem; font-weight: 600; padding: 2px 6px; border-radius: 4px;">
                                                        {{ $cName }}
                                                    </span>
                                                @endforeach
                                                @if(count($m['assigned_courses']) > 3)
                                                    <span style="font-size: 0.74rem; color: #94a3b8;">+{{ count($m['assigned_courses']) - 3 }} more</span>
                                                @endif
                                            </div>
                                        @else
                                            <span style="color: #94a3b8; font-size: 0.8rem;">All platform courses</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="display: inline-block; background: rgba(5, 179, 150, 0.12); color: #05B396; font-weight: 900; font-size: 0.82rem; padding: 3px 10px; border-radius: 50px;">
                                            {{ $m['commission_percentage'] }}%
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 900; color: #0f172a; font-size: 0.95rem;">
                                        ₹{{ number_format($m['total_earned'], 2) }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; color: #059669; font-weight: 700;">
                                        ₹{{ number_format($m['processed_payouts'], 2) }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: #d97706;">
                                        ₹{{ number_format($m['wallet_balance'], 2) }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        @if($m['status'] === 'active')
                                            <span style="background: #ecfdf5; color: #059669; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">ACTIVE</span>
                                        @else
                                            <span style="background: #fee2e2; color: #991b1b; font-size: 0.74rem; font-weight: 800; padding: 2px 8px; border-radius: 4px;">INACTIVE</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                                        No mentors found.
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

