@extends('layouts.app')

@section('title', 'Payout Approvals & Transfers — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-payouts'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-payouts'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        💸 Affiliate Payout Approvals
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Process withdrawal requests, review UPI/Bank payment methods, and confirm wallet disbursements.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Payout Metrics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">TOTAL DISBURSED (LIFETIME)</div>
                    <div class="admin-stat-val" style="color: #05B396;">₹{{ number_format($stats['total_paid'], 2) }}</div>
                    <div class="admin-stat-sub">Successfully transferred to bank/UPI</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #f59e0b;">PENDING CLEARANCE</div>
                    <div class="admin-stat-val" style="color: #f59e0b;">₹{{ number_format($stats['pending_amount'], 2) }}</div>
                    <div class="admin-stat-sub">Awaiting admin transfer confirmation</div>
                </div>

                <div class="admin-stat-card" style="border-top: 3px solid #6366f1;">
                    <div class="admin-stat-label" style="color: #6366f1;">WITHDRAWAL REQUESTS</div>
                    <div class="admin-stat-val" style="color: #6366f1;">{{ $stats['total_requests'] }}</div>
                    <div class="admin-stat-sub">Total batch queue volume</div>
                </div>
            </div>

            <!-- Table Card -->
            <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 18px; box-shadow: 0 4px 20px rgba(5, 179, 150, 0.04); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        Payout Queue ({{ count($payouts) }})
                    </h3>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ url('/admin/payout-requests') }}" style="padding: 0.35rem 0.8rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'all' ? 'background: #05B396; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                            All
                        </a>
                        <a href="{{ url('/admin/payout-requests?status=pending') }}" style="padding: 0.35rem 0.8rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'pending' ? 'background: #f59e0b; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                            Pending
                        </a>
                        <a href="{{ url('/admin/payout-requests?status=transferred') }}" style="padding: 0.35rem 0.8rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'transferred' ? 'background: #10b981; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                            Approved
                        </a>
                        <a href="{{ url('/admin/payout-requests?status=rejected') }}" style="padding: 0.35rem 0.8rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-decoration: none; {{ $currentFilter === 'rejected' ? 'background: #ef4444; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                            Rejected
                        </a>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 0.85rem 1.4rem;">Reference Code</th>
                                <th style="padding: 0.85rem 1rem;">Affiliate User</th>
                                <th style="padding: 0.85rem 1rem;">Amount</th>
                                <th style="padding: 0.85rem 1rem;">Payment Method / UPI</th>
                                <th style="padding: 0.85rem 1rem;">Date</th>
                                <th style="padding: 0.85rem 1rem;">Status</th>
                                <th style="padding: 0.85rem 1.4rem; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payouts as $p)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f0fdfa'" onmouseout="this.style.background='#ffffff'">
                                    <td style="padding: 0.95rem 1.4rem; font-weight: 800; color: #0f172a; font-family: monospace;">
                                        #{{ $p->payout_code }}
                                    </td>
                                    <td style="padding: 0.95rem 1rem;">
                                        <div style="font-weight: 700; color: #0f172a;">{{ $p->user?->name ?? 'Affiliate #'.$p->user_id }}</div>
                                        <div style="font-size: 0.78rem; color: #64748b;">{{ $p->user?->email }}</div>
                                    </td>
                                    <td style="padding: 0.95rem 1rem; font-weight: 800; color: #05B396; font-size: 1.05rem;">
                                        ₹{{ number_format($p->amount, 2) }}
                                    </td>
                                    <td style="padding: 0.95rem 1rem; color: #334155; font-size: 0.84rem; font-weight: 600;">
                                        {{ $p->payment_method }}
                                    </td>
                                    <td style="padding: 0.95rem 1rem; color: #64748b; font-size: 0.82rem;">
                                        {{ $p->created_at ? $p->created_at->format('d M Y, h:i A') : 'Recent' }}
                                    </td>
                                    <td style="padding: 0.95rem 1rem;">
                                        @if($p->status === 'Transferred' || $p->status === 'Approved')
                                            <span style="background: #f0fdf4; color: #166534; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; border: 1px solid #bbf7d0;">Approved &amp; Paid ✅</span>
                                        @elseif($p->status === 'Pending')
                                            <span style="background: #fffbeb; color: #b45309; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; border: 1px solid #fde68a;">Pending Approval ⏳</span>
                                        @elseif($p->status === 'Processing')
                                            <span style="background: #eff6ff; color: #1d4ed8; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; border: 1px solid #bfdbfe;">Processing 🔄</span>
                                        @elseif($p->status === 'Rejected')
                                            <span style="background: #fef2f2; color: #991b1b; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; border: 1px solid #fecaca;">Rejected (Refunded) ❌</span>
                                        @else
                                            <span style="background: #f8fafc; color: #475569; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 6px;">{{ $p->status }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.95rem 1.4rem; text-align: right;">
                                        @if(in_array($p->status, ['Pending', 'Processing']))
                                            <div style="display: inline-flex; gap: 6px; align-items: center;">
                                                <form method="POST" action="{{ url('/admin/payout/'.$p->id.'/status') }}" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Transferred">
                                                    <button type="submit" style="background: #05B396; border: none; color: #fff; padding: 0.45rem 0.9rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer; box-shadow: 0 2px 8px rgba(5, 179, 150, 0.25); display: inline-flex; align-items: center; gap: 4px;">
                                                        <span>Approve &amp; Pay</span>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ url('/admin/payout/'.$p->id.'/status') }}" style="display: inline;" onsubmit="return confirm('Reject payout #{{ $p->payout_code }}? ₹{{ number_format($p->amount) }} will be refunded to user wallet.')">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" style="background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 0.45rem 0.75rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($p->status === 'Transferred' || $p->status === 'Approved')
                                            <span style="color: #166534; font-size: 0.8rem; font-weight: 700;">Completed ✅</span>
                                        @elseif($p->status === 'Rejected')
                                            <span style="color: #991b1b; font-size: 0.8rem; font-weight: 700;">Refunded ↩️</span>
                                        @else
                                            <span style="color: #64748b; font-size: 0.8rem; font-weight: 600;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding: 3rem 1rem; text-align: center; color: #64748b;">
                                        No payout requests found in queue.
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
