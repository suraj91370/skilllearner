@extends('layouts.app')

@section('title', 'Sales & Revenue Report — SkillLearner')

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
            @include('admin.reports.tabs', ['activeReport' => 'revenue'])

            <!-- Top Row: Revenue KPI Summary -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Gross Sales</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #05B396; margin-top: 4px;">₹{{ number_format($grossRevenue, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #64748b; margin-top: 2px;">{{ $paidCount }} Paid Orders</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Net Revenue</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #0B4F4A; margin-top: 4px;">₹{{ number_format($netRevenue, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #0B4F4A; font-weight: 700; margin-top: 2px;">After Approved Refunds</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Refunded Volume</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #ef4444; margin-top: 4px;">₹{{ number_format($refundedAmount, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #ef4444; font-weight: 700; margin-top: 2px;">Returned to Students</div>
                </div>

                <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Avg Transaction (AOV)</div>
                    <div style="font-size: 1.7rem; font-weight: 900; color: #0284c7; margin-top: 4px;">₹{{ number_format($avgOrderValue, 2) }}</div>
                    <div style="font-size: 0.76rem; color: #64748b; margin-top: 2px;">Per Checkout</div>
                </div>
            </div>

            <!-- Monthly Sales Summary (Last 6 Months Comparison) -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 1.8rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">Monthly Revenue Breakdown</h3>
                        <p style="margin: 2px 0 0; font-size: 0.82rem; color: #64748b;">Month-by-month revenue velocity and paid transactions</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    @foreach($monthlyRecords as $mr)
                        <div style="background: {{ $mr['is_current'] ? '#f0fdf9' : '#f8fafc' }}; border: 1.5px solid {{ $mr['is_current'] ? '#a7f3d0' : '#e2e8f0' }}; border-radius: 12px; padding: 1.2rem; text-align: center;">
                            <div style="font-size: 0.78rem; font-weight: 800; color: {{ $mr['is_current'] ? '#05B396' : '#64748b' }}; text-transform: uppercase;">
                                {{ $mr['month_name'] }}
                            </div>
                            <div style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 4px 0;">
                                ₹{{ number_format($mr['net_amount'], 2) }}
                            </div>
                            <div style="font-size: 0.76rem; color: #64748b; font-weight: 600;">
                                {{ $mr['paid_orders'] }} Orders
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Daily Sales Table -->
            <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 2rem;">
                <div style="padding: 1.4rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Daily Sales Records</h3>
                        <p style="margin: 2px 0 0; font-size: 0.8rem; color: #64748b;">Day-by-day order count, gross sales, refunds and net earnings</p>
                    </div>
                    <a href="{{ route('admin.reports.export.csv', ['type' => 'revenue', 'range' => $range, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn" style="background: #f8fafc; color: #0f172a; font-size: 0.82rem; font-weight: 700; border: 1px solid #cbd5e1; padding: 6px 14px; border-radius: 6px; text-decoration: none;">
                        📄 Download Daily CSV
                    </a>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 12px 16px;">Date</th>
                                <th style="padding: 12px 16px;">Day</th>
                                <th style="padding: 12px 16px; text-align: center;">Total Orders</th>
                                <th style="padding: 12px 16px; text-align: center;">Paid Orders</th>
                                <th style="padding: 12px 16px; text-align: right;">Gross Sales</th>
                                <th style="padding: 12px 16px; text-align: right;">Refunds</th>
                                <th style="padding: 12px 16px; text-align: right;">Net Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dailyRecords as $dr)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px 16px; font-weight: 800; color: #0f172a;">{{ $dr['date'] }}</td>
                                    <td style="padding: 12px 16px; color: #64748b;">{{ $dr['day_name'] }}</td>
                                    <td style="padding: 12px 16px; text-align: center; font-weight: 700;">{{ $dr['total_orders'] }}</td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="display: inline-block; background: #ecfdf5; color: #059669; font-weight: 800; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px;">
                                            {{ $dr['paid_orders'] }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: #0f172a;">₹{{ number_format($dr['gross_amount'], 2) }}</td>
                                    <td style="padding: 12px 16px; text-align: right; color: {{ $dr['refund_amount'] > 0 ? '#ef4444' : '#94a3b8' }}; font-weight: {{ $dr['refund_amount'] > 0 ? '700' : 'normal' }};">
                                        {{ $dr['refund_amount'] > 0 ? '-₹' . number_format($dr['refund_amount'], 2) : '₹0.00' }}
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 900; color: #05B396; font-size: 0.95rem;">
                                        ₹{{ number_format($dr['net_amount'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2.5rem; color: #94a3b8;">
                                        No sales records found for this period.
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

