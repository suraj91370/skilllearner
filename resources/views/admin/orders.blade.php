@extends('layouts.app')

@section('title', 'Orders, Payments & Refund Management — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-orders'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-orders'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        💳 Orders, Payments &amp; Refund Management
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Track real-time transactions, Cashfree orders, failed payments, process refunds, and generate GST tax invoices.
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.payment-gateway') }}" style="background: #ffffff; border: 1.5px solid #05B396; color: #05B396; padding: 0.6rem 1.1rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <span>⚙️ Cashfree Gateway Settings</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- Top Revenue & Metrics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
                <!-- Total Orders -->
                <div class="admin-stat-card">
                    <div class="admin-stat-label">TOTAL ORDERS</div>
                    <div class="admin-stat-val">{{ number_format($metrics['total_orders']) }}</div>
                    <div class="admin-stat-sub">All-time transactions</div>
                </div>

                <!-- Total Paid Revenue -->
                <div class="admin-stat-card" style="border-top: 3px solid #05B396;">
                    <div class="admin-stat-label" style="color: #05B396;">💰 TOTAL REVENUE</div>
                    <div class="admin-stat-val" style="color: #05B396;">₹{{ number_format($metrics['total_revenue'], 2) }}</div>
                    <div class="admin-stat-sub">From paid enrollments</div>
                </div>

                <!-- Today's Revenue -->
                <div class="admin-stat-card" style="border-top: 3px solid #0284c7;">
                    <div class="admin-stat-label" style="color: #0284c7;">📈 TODAY'S REVENUE</div>
                    <div class="admin-stat-val" style="color: #0284c7;">₹{{ number_format($metrics['today_revenue'], 2) }}</div>
                    <div class="admin-stat-sub">Since midnight</div>
                </div>

                <!-- Successful / Paid Count -->
                <div class="admin-stat-card" style="border-top: 3px solid #10b981;">
                    <div class="admin-stat-label" style="color: #10b981;">✅ PAID ORDERS</div>
                    <div class="admin-stat-val" style="color: #10b981;">{{ number_format($metrics['paid_count']) }}</div>
                    <div class="admin-stat-sub">Classroom unlocked</div>
                </div>

                <!-- Pending Verification -->
                <div class="admin-stat-card" style="border-top: 3px solid #f59e0b;">
                    <div class="admin-stat-label" style="color: #f59e0b;">⏳ PENDING VERIFY</div>
                    <div class="admin-stat-val" style="color: #f59e0b;">{{ number_format($metrics['pending_count']) }}</div>
                    <div class="admin-stat-sub">Awaiting admin check</div>
                </div>

                <!-- Failed Payments (Failed Payment Tracking) -->
                <div class="admin-stat-card" style="border-top: 3px solid #ef4444; background: {{ $metrics['failed_count'] > 0 ? '#fff5f5' : '#ffffff' }};">
                    <div class="admin-stat-label" style="color: #ef4444;">⚠️ FAILED PAYMENTS</div>
                    <div class="admin-stat-val" style="color: #ef4444;">{{ number_format($metrics['failed_count']) }}</div>
                    <div class="admin-stat-sub">Requires follow-up</div>
                </div>

                <!-- Refunded Orders -->
                <div class="admin-stat-card" style="border-top: 3px solid #7c3aed;">
                    <div class="admin-stat-label" style="color: #7c3aed;">↩️ REFUNDED</div>
                    <div class="admin-stat-val" style="color: #7c3aed;">{{ number_format($metrics['refunded_count']) }}</div>
                    <div class="admin-stat-sub">₹{{ number_format($metrics['total_refunded'], 2) }} returned</div>
                </div>
            </div>

            <!-- Filter Pills & Search Form -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 1.2rem; margin-bottom: 1.5rem;">
                <form method="GET" action="{{ route('admin.orders') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                    <!-- Status Filter Tabs -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}" 
                           class="admin-filter-pill {{ $currentStatus === 'all' ? 'active' : '' }}">
                            All ({{ $metrics['total_orders'] }})
                        </a>
                        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'paid'])) }}" 
                           class="admin-filter-pill {{ $currentStatus === 'paid' ? 'active' : '' }}">
                            🟢 Paid ({{ $metrics['paid_count'] }})
                        </a>
                        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}" 
                           class="admin-filter-pill {{ $currentStatus === 'pending' ? 'active' : '' }}">
                            ⏳ Pending ({{ $metrics['pending_count'] }})
                        </a>
                        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'failed'])) }}" 
                           class="admin-filter-pill {{ $currentStatus === 'failed' ? 'active' : '' }}" style="{{ $metrics['failed_count'] > 0 ? 'border: 1px solid #f87171;' : '' }}">
                            ⚠️ Failed Attempts ({{ $metrics['failed_count'] }})
                        </a>
                        <a href="{{ route('admin.orders', array_merge(request()->except(['status', 'page']), ['status' => 'refunded'])) }}" 
                           class="admin-filter-pill {{ $currentStatus === 'refunded' ? 'active' : '' }}">
                            ↩️ Refunded ({{ $metrics['refunded_count'] }})
                        </a>
                    </div>

                    <!-- Payment Method Dropdown & Search -->
                    <div style="display: flex; gap: 8px; flex: 1; max-width: 480px; justify-content: flex-end;">
                        <select name="method" onchange="this.form.submit()" style="padding: 0.55rem 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.85rem; background: #fff; outline: none; font-weight: 600;">
                            <option value="all" {{ $currentMethod === 'all' ? 'selected' : '' }}>All Methods</option>
                            <option value="cashfree" {{ $currentMethod === 'cashfree' ? 'selected' : '' }}>💳 Cashfree PG</option>
                            <option value="manual_upi" {{ $currentMethod === 'manual_upi' ? 'selected' : '' }}>📱 Manual QR / UPI</option>
                        </select>

                        <input type="text" name="search" value="{{ $search }}" placeholder="Search Order ID, Name, Email, UTR..." style="flex: 1; padding: 0.55rem 0.9rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;">
                        <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.55rem 1rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">
                            Search
                        </button>
                        @if($search || $currentStatus !== 'all' || $currentMethod !== 'all')
                            <a href="{{ route('admin.orders') }}" style="background: #f1f5f9; color: #475569; padding: 0.55rem 0.8rem; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center;">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Orders Table Card -->
            <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 18px; box-shadow: 0 4px 20px rgba(5, 179, 150, 0.04); overflow: hidden;">
                <div style="padding: 1.2rem 1.6rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        Orders &amp; Payment Records ({{ $orders->total() }})
                    </h3>
                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">
                        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }}
                    </span>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <th style="padding: 0.85rem 1.2rem;">Order &amp; Invoice</th>
                                <th style="padding: 0.85rem 0.8rem;">Customer / Student</th>
                                <th style="padding: 0.85rem 0.8rem;">Package &amp; Price</th>
                                <th style="padding: 0.85rem 0.8rem;">Gateway &amp; Method</th>
                                <th style="padding: 0.85rem 0.8rem;">Transaction / UTR</th>
                                <th style="padding: 0.85rem 0.8rem;">Status</th>
                                <th style="padding: 0.85rem 0.8rem;">Date</th>
                                <th style="padding: 0.85rem 1.2rem; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease; {{ $order->payment_status === 'failed' ? 'background: #fff8f8;' : ($order->payment_status === 'refunded' ? 'background: #faf5ff;' : '') }}" 
                                    onmouseover="this.style.background='{{ $order->payment_status === 'failed' ? '#fee2e2' : '#f0fdfa' }}'" 
                                    onmouseout="this.style.background='{{ $order->payment_status === 'failed' ? '#fff8f8' : ($order->payment_status === 'refunded' ? '#faf5ff' : '#ffffff') }}'">
                                    
                                    <!-- Order ID & Tax Invoice -->
                                    <td style="padding: 0.95rem 1.2rem;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.92rem; font-family: monospace;">
                                            #{{ $order->order_id }}
                                        </div>
                                        <div style="margin-top: 3px; display: flex; align-items: center; gap: 6px;">
                                            @if($order->payment_status === 'paid' || $order->invoice_number)
                                                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; background: #ecfdf5; border: 1px solid #a7f3d0; color: #059669; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 4px; text-decoration: none;">
                                                    🧾 {{ $order->invoice_number ?: 'Invoice' }}
                                                </a>
                                            @else
                                                <span style="font-size: 0.72rem; color: #94a3b8; font-style: italic;">No invoice</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Customer / Buyer -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">
                                            {{ $order->buyer_name }}
                                        </div>
                                        <div style="font-size: 0.78rem; color: #64748b;">
                                            {{ $order->buyer_email }}
                                        </div>
                                        <div style="font-size: 0.74rem; color: #05B396; display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                                            <span>📞 {{ $order->buyer_phone ?: 'N/A' }}</span>
                                            @if($order->buyer_phone)
                                                @php
                                                    $cleanPhone = preg_replace('/[^0-9]/', '', $order->buyer_phone);
                                                    if (strlen($cleanPhone) === 10) { $cleanPhone = '91' . $cleanPhone; }
                                                    $waMsg = urlencode("Hello {$order->buyer_name}, this is regarding your SkillLearner order #{$order->order_id} for {$order->package_name}.");
                                                @endphp
                                                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank" title="WhatsApp Customer" style="color: #25d366; text-decoration: none; font-weight: bold; font-size: 0.82rem;">
                                                    💬
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Package & Price -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="font-weight: 700; color: #334155; font-size: 0.88rem;">
                                            {{ $order->package_name }}
                                        </div>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.95rem; margin-top: 2px;">
                                            ₹{{ number_format((float) $order->amount, 2) }}
                                        </div>
                                        @if($order->coupon_discount > 0)
                                            <div style="font-size: 0.72rem; color: #16a34a; font-weight: 600;">
                                                Coupon: {{ $order->coupon_code }} (-₹{{ number_format($order->coupon_discount) }})
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Gateway & Method -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        @if($order->payment_method === 'cashfree')
                                            <span style="background: rgba(124, 58, 237, 0.1); border: 1px solid rgba(124, 58, 237, 0.3); color: #7c3aed; font-weight: 800; font-size: 0.74rem; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                                ⚡ Cashfree PG
                                            </span>
                                        @elseif($order->payment_method === 'manual_upi')
                                            <span style="background: rgba(2, 132, 199, 0.1); border: 1px solid rgba(2, 132, 199, 0.3); color: #0284c7; font-weight: 800; font-size: 0.74rem; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                                📱 Manual UPI
                                            </span>
                                        @else
                                            <span style="background: #f1f5f9; color: #475569; font-weight: 700; font-size: 0.74rem; padding: 3px 8px; border-radius: 6px;">
                                                {{ ucfirst($order->payment_method ?? 'Online') }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Transaction / UTR ID -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        <div style="font-family: monospace; font-size: 0.8rem; font-weight: 700; color: {{ $order->transaction_id && $order->transaction_id !== 'PENDING' ? '#0f172a' : '#94a3b8' }};">
                                            {{ $order->transaction_id ?: 'PENDING' }}
                                        </div>
                                    </td>

                                    <!-- Payment Status & Failure Tracking -->
                                    <td style="padding: 0.95rem 0.8rem;">
                                        @if($order->payment_status === 'paid')
                                            <span style="background: #f0fdf4; color: #166534; font-weight: 800; font-size: 0.75rem; padding: 3px 9px; border-radius: 6px; border: 1px solid #bbf7d0; display: inline-flex; align-items: center; gap: 4px;">
                                                🟢 Paid
                                            </span>
                                        @elseif($order->payment_status === 'pending')
                                            <span style="background: #fffbeb; color: #b45309; font-weight: 800; font-size: 0.75rem; padding: 3px 9px; border-radius: 6px; border: 1px solid #fde68a; display: inline-flex; align-items: center; gap: 4px;">
                                                ⏳ Pending
                                            </span>
                                        @elseif($order->payment_status === 'failed')
                                            <div style="display: flex; flex-direction: column; gap: 3px; align-items: flex-start;">
                                                <span style="background: #fef2f2; color: #dc2626; font-weight: 800; font-size: 0.75rem; padding: 3px 9px; border-radius: 6px; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 4px;">
                                                    ⚠️ Failed
                                                </span>
                                                @if($order->failure_reason)
                                                    <span style="font-size: 0.7rem; color: #991b1b; max-width: 150px; line-height: 1.2;" title="{{ $order->failure_reason }}">
                                                        Reason: {{ Str::limit($order->failure_reason, 26) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @elseif($order->payment_status === 'refunded')
                                            <div style="display: flex; flex-direction: column; gap: 3px; align-items: flex-start;">
                                                <span style="background: #faf5ff; color: #7c3aed; font-weight: 800; font-size: 0.75rem; padding: 3px 9px; border-radius: 6px; border: 1px solid #e9d5ff; display: inline-flex; align-items: center; gap: 4px;">
                                                    ↩️ Refunded
                                                </span>
                                                <span style="font-size: 0.7rem; color: #6b21a8; font-weight: 700;">
                                                    ₹{{ number_format((float) $order->refund_amount, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Date -->
                                    <td style="padding: 0.95rem 0.8rem; font-size: 0.78rem; color: #64748b;">
                                        <div>{{ $order->created_at ? $order->created_at->format('d M Y') : '—' }}</div>
                                        <div style="font-size: 0.72rem; color: #94a3b8;">{{ $order->created_at ? $order->created_at->format('h:i A') : '' }}</div>
                                    </td>

                                    <!-- Action Buttons -->
                                    <td style="padding: 0.95rem 1.2rem; text-align: right;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px; justify-content: flex-end; flex-wrap: wrap;">
                                            <!-- Download Invoice Button -->
                                            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" title="View &amp; Print Tax Invoice" style="background: #f0fdfa; border: 1px solid #a7f3d0; color: #05B396; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; text-decoration: none;">
                                                🧾 Invoice
                                            </a>

                                            <!-- If Paid: Refund Action Modal Trigger -->
                                            @if($order->payment_status === 'paid')
                                                <button type="button" 
                                                        onclick="openRefundModal('{{ $order->id }}', '{{ $order->order_id }}', '{{ addslashes($order->buyer_name) }}', '{{ (float) $order->amount }}')" 
                                                        style="background: #faf5ff; border: 1px solid #d8b4fe; color: #7c3aed; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                                    ↩️ Refund
                                                </button>
                                            @endif

                                            <!-- If Pending or Failed: Mark As Paid Action (Resolve Offline / Cash payment) -->
                                            @if(in_array($order->payment_status, ['pending', 'failed']))
                                                <button type="button" 
                                                        onclick="openMarkPaidModal('{{ $order->id }}', '{{ $order->order_id }}', '{{ addslashes($order->buyer_name) }}', '{{ (float) $order->amount }}', '{{ addslashes($order->transaction_id ?? '') }}')" 
                                                        style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; font-size: 0.74rem; font-weight: 700; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                                                    ✅ Mark Paid
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="padding: 3rem 1.5rem; text-align: center; color: #64748b;">
                                        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">🧾</div>
                                        <div style="font-weight: 700; font-size: 1rem; color: #1e293b; margin-bottom: 0.25rem;">No orders found</div>
                                        <p style="font-size: 0.88rem; color: #64748b; margin: 0;">Try adjusting your status filter or search query.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div style="padding: 1.2rem 1.6rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: center;">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>

{{-- ========================================================= --}}
{{-- MODAL 1: PROCESS REFUND (Super Admin & Admin)             --}}
{{-- ========================================================= --}}
<div id="refundModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 480px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; animation: popIn 0.2s ease-out;">
        <div style="background: linear-gradient(135deg, #7c3aed, #4f46e5); padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.1rem; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <span>↩️ Process Order Refund</span>
            </div>
            <button type="button" onclick="closeRefundModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; font-size: 1.1rem; cursor: pointer;">✕</button>
        </div>

        <form id="refundForm" method="POST" action="" style="padding: 1.5rem;">
            @csrf
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.9rem 1.1rem; margin-bottom: 1.2rem; font-size: 0.88rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span style="color: #64748b;">Order ID:</span>
                    <strong id="refundModalOrderId" style="font-family: monospace;">#—</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span style="color: #64748b;">Student Name:</span>
                    <strong id="refundModalBuyerName">—</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b;">Total Paid Amount:</span>
                    <strong id="refundModalTotalAmount" style="color: #05B396; font-size: 1rem;">₹0.00</strong>
                </div>
            </div>

            <!-- Refund Action Decision -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Refund Decision *
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; border: 1.5px solid #d8b4fe; padding: 0.6rem 0.8rem; border-radius: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: #6b21a8; background: #faf5ff;">
                        <input type="radio" name="action" value="approve" checked>
                        <span>✅ Approve Refund</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; border: 1.5px solid #fecaca; padding: 0.6rem 0.8rem; border-radius: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 700; color: #991b1b; background: #fff5f5;">
                        <input type="radio" name="action" value="reject">
                        <span>❌ Reject Refund</span>
                    </label>
                </div>
            </div>

            <!-- Refund Amount -->
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Refund Amount (₹) *
                </label>
                <input type="number" step="0.01" name="refund_amount" id="refundModalAmountInput" required style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; font-weight: 700; outline: none;">
                <small style="color: #64748b; font-size: 0.74rem;">Defaults to full order amount. Partial refunds are allowed.</small>
            </div>

            <!-- Refund Reason / Note -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Refund Reason / Approval Note
                </label>
                <textarea name="refund_reason" rows="3" placeholder="Enter reason for refund or audit remark (e.g. Double payment, Student requested cancellation)..." style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.88rem; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeRefundModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">
                    Cancel
                </button>
                <button type="submit" style="background: #7c3aed; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 0.88rem;">
                    Submit Decision
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================= --}}
{{-- MODAL 2: MARK AS PAID (Offline UTR / Failed Resolve)       --}}
{{-- ========================================================= --}}
<div id="markPaidModal" style="display: none; position: fixed; inset: 0; z-index: 99999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #ffffff; border-radius: 16px; max-width: 480px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.25); overflow: hidden; animation: popIn 0.2s ease-out;">
        <div style="background: linear-gradient(135deg, #05B396, #047857); padding: 1.2rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 1.1rem; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <span>✅ Mark Order as Paid</span>
            </div>
            <button type="button" onclick="closeMarkPaidModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; border-radius: 50%; width: 28px; height: 28px; font-size: 1.1rem; cursor: pointer;">✕</button>
        </div>

        <form id="markPaidForm" method="POST" action="" style="padding: 1.5rem;">
            @csrf
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.9rem 1.1rem; margin-bottom: 1.2rem; font-size: 0.88rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span style="color: #64748b;">Order ID:</span>
                    <strong id="markPaidModalOrderId" style="font-family: monospace;">#—</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                    <span style="color: #64748b;">Student Name:</span>
                    <strong id="markPaidModalBuyerName">—</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #64748b;">Amount to Confirm:</span>
                    <strong id="markPaidModalTotalAmount" style="color: #05B396; font-size: 1rem;">₹0.00</strong>
                </div>
            </div>

            <div style="background: #f0fdf4; border-left: 4px solid #05B396; padding: 0.8rem 1rem; border-radius: 6px; margin-bottom: 1.2rem; font-size: 0.82rem; color: #166534; line-height: 1.4;">
                ℹ️ Marking this order as <strong>PAID</strong> will immediately activate the student's classroom, unlock all package courses, generate the GST tax invoice, and credit the 2-tier affiliate referral commissions.
            </div>

            <!-- Transaction UTR Input -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                    Confirmed Bank UTR / Transaction ID *
                </label>
                <input type="text" name="transaction_id" id="markPaidModalTxnInput" required placeholder="e.g. 429381749281 or CASH_VERIFIED" style="width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; font-family: monospace; font-weight: 700; outline: none;">
                <small style="color: #64748b; font-size: 0.74rem;">Enter the 12-digit UPI reference number or payment confirmation code.</small>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeMarkPaidModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 0.88rem;">
                    Cancel
                </button>
                <button type="submit" style="background: #05B396; color: #fff; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 0.88rem;">
                    Confirm &amp; Unlock Account
                </button>
            </div>
        </form>
    </div>
</div>

@include('portal.styles')

@push('styles')
<style>
    .admin-stat-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.1rem 1.3rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }
    .admin-stat-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 0.35rem;
    }
    .admin-stat-val {
        font-size: 1.7rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.25rem;
    }
    .admin-stat-sub {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .admin-filter-pill {
        display: inline-block;
        padding: 0.45rem 0.95rem;
        border-radius: 20px;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .admin-filter-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .admin-filter-pill.active {
        background: #05B396;
        color: #ffffff;
    }
    @keyframes popIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    function openRefundModal(id, orderId, buyerName, amount) {
        document.getElementById('refundForm').action = '/admin/orders/' + id + '/refund';
        document.getElementById('refundModalOrderId').textContent = '#' + orderId;
        document.getElementById('refundModalBuyerName').textContent = buyerName;
        document.getElementById('refundModalTotalAmount').textContent = '₹' + Number(amount).toFixed(2);
        document.getElementById('refundModalAmountInput').value = Number(amount).toFixed(2);
        document.getElementById('refundModal').style.display = 'flex';
    }

    function closeRefundModal() {
        document.getElementById('refundModal').style.display = 'none';
    }

    function openMarkPaidModal(id, orderId, buyerName, amount, currentTxn) {
        document.getElementById('markPaidForm').action = '/admin/orders/' + id + '/mark-paid';
        document.getElementById('markPaidModalOrderId').textContent = '#' + orderId;
        document.getElementById('markPaidModalBuyerName').textContent = buyerName;
        document.getElementById('markPaidModalTotalAmount').textContent = '₹' + Number(amount).toFixed(2);
        document.getElementById('markPaidModalTxnInput').value = (currentTxn && currentTxn !== 'PENDING') ? currentTxn : '';
        document.getElementById('markPaidModal').style.display = 'flex';
    }

    function closeMarkPaidModal() {
        document.getElementById('markPaidModal').style.display = 'none';
    }

    // Close on background click
    window.onclick = function(event) {
        var refundModal = document.getElementById('refundModal');
        var markPaidModal = document.getElementById('markPaidModal');
        if (event.target === refundModal) { closeRefundModal(); }
        if (event.target === markPaidModal) { closeMarkPaidModal(); }
    };
</script>
@endpush
@endsection

