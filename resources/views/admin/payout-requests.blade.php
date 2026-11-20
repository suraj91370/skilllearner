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
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        💸 Affiliate Payout Approvals
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Process withdrawal requests, disburse direct manual payouts, and trigger automated notification emails.
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openManualPayoutModal()" style="background: linear-gradient(135deg, #05B396 0%, #047857 100%); color: #ffffff; border: none; padding: 0.7rem 1.3rem; border-radius: 10px; font-weight: 700; font-size: 0.92rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35); transition: transform 0.15s ease;">
                        <span>➕ Disburse Manual Payout</span>
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ❌ {{ session('error') }}
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
                                <th style="padding: 0.85rem 1rem;">Payment Method &amp; UTR</th>
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
                                        @if(str_starts_with($p->payout_code, 'PAY-M-'))
                                            <span style="font-size: 0.68rem; background: #e0e7ff; color: #4338ca; padding: 1px 6px; border-radius: 4px; font-weight: 700; margin-left: 4px;">Manual</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.95rem 1rem;">
                                        <div style="font-weight: 700; color: #0f172a;">{{ $p->user?->name ?? 'Affiliate #'.$p->user_id }}</div>
                                        <div style="font-size: 0.78rem; color: #64748b;">{{ $p->user?->email }}</div>
                                    </td>
                                    <td style="padding: 0.95rem 1rem; font-weight: 800; color: #05B396; font-size: 1.05rem;">
                                        ₹{{ number_format($p->amount, 2) }}
                                    </td>
                                    <td style="padding: 0.95rem 1rem; color: #334155; font-size: 0.84rem;">
                                        <div style="font-weight: 600;">{{ $p->payment_method }}</div>
                                        @if(!empty($p->utr_number))
                                            <div style="margin-top: 3px;">
                                                <span style="font-family: monospace; font-size: 0.75rem; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 2px 7px; border-radius: 4px; font-weight: 700;">
                                                    UTR: {{ $p->utr_number }}
                                                </span>
                                            </div>
                                        @endif
                                        @if(!empty($p->remarks))
                                            <div style="font-size: 0.75rem; color: #64748b; font-style: italic; margin-top: 2px;">
                                                {{ Str::limit($p->remarks, 40) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 0.95rem 1rem; color: #64748b; font-size: 0.82rem;">
                                        <div>{{ $p->created_at ? $p->created_at->format('d M Y, h:i A') : 'Recent' }}</div>
                                        @if($p->processed_at && $p->status === 'Transferred')
                                            <div style="font-size: 0.73rem; color: #05B396;">Paid: {{ $p->processed_at->format('d M, h:i A') }}</div>
                                        @endif
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
                                                <button type="button" onclick="openApproveModal({{ $p->id }}, '{{ $p->payout_code }}', '{{ addslashes($p->user?->name ?? 'Affiliate') }}', '{{ number_format($p->amount, 2) }}', '{{ addslashes($p->payment_method) }}')" style="background: #05B396; border: none; color: #fff; padding: 0.45rem 0.9rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer; box-shadow: 0 2px 8px rgba(5, 179, 150, 0.25); display: inline-flex; align-items: center; gap: 4px;">
                                                    <span>Approve &amp; Pay</span>
                                                </button>
                                                <form method="POST" action="{{ url('/admin/payout/'.$p->id.'/status') }}" style="display: inline;" onsubmit="return confirm('Reject payout #{{ $p->payout_code }}? ₹{{ number_format($p->amount) }} will be refunded to user wallet.')">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" style="background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 0.45rem 0.75rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($p->status === 'Transferred' || $p->status === 'Approved')
                                            <div style="display: inline-flex; flex-direction: column; align-items: flex-end; gap: 2px;">
                                                <span style="color: #166534; font-size: 0.8rem; font-weight: 700;">Completed ✅</span>
                                                <span style="color: #059669; font-size: 0.72rem; font-weight: 600;">✉️ Email Dispatched</span>
                                            </div>
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

<!-- Modal 1: Disburse Manual Direct Payout -->
<div id="manualPayoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); z-index: 2100; align-items: center; justify-content: center; padding: 1rem; box-sizing: border-box;" onclick="handleModalBackdropClick(event, 'manualPayoutModal')">
    <div style="background: #ffffff; border-radius: 18px; padding: 2.2rem 2rem; max-width: 520px; width: 100%; border: 1px solid #e2e8f0; box-shadow: 0 25px 60px -15px rgba(0,0,0,0.3); position: relative; box-sizing: border-box; max-height: 90vh; overflow-y: auto;">
        <button type="button" onclick="closeManualPayoutModal()" style="position: absolute; top: 18px; right: 20px; background: none; border: none; font-size: 1.6rem; color: #64748b; cursor: pointer; line-height: 1;">&times;</button>
        <h3 style="margin-bottom: 0.3rem; color: #0f172a; font-weight: 800; font-size: 1.35rem; display: flex; align-items: center; gap: 8px;">
            💸 Disburse Manual Direct Payout
        </h3>
        <p style="color: #64748b; font-size: 0.88rem; margin-bottom: 1.5rem;">
            Make an instant direct payment or settle user earnings. An official payout email will automatically be sent to the affiliate.
        </p>

        <form method="POST" action="{{ route('admin.payouts.manual') }}" onsubmit="handleManualSubmit(this)">
            @csrf

            <!-- User Select -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Select Affiliate User <span style="color: #ef4444;">*</span></label>
                <select name="user_id" id="manualUserSelect" required onchange="onManualUserChanged(this)" style="width: 100%; padding: 0.85rem 1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.92rem; font-weight: 600; color: #0f172a; box-sizing: border-box;">
                    <option value="">-- Choose Affiliate / Student --</option>
                    @if(isset($users))
                        @foreach($users as $u)
                            @php
                                $upi = $u->kyc?->upi_id ?? '';
                                $bank = $u->kyc?->account_number ? ($u->kyc->bank_name . ' | A/C: ' . $u->kyc->account_number . ' | IFSC: ' . $u->kyc->ifsc_code) : '';
                                $defaultMethod = !empty($upi) ? 'UPI: '.$upi : (!empty($bank) ? $bank : '');
                            @endphp
                            <option value="{{ $u->id }}" 
                                data-name="{{ $u->name }}" 
                                data-wallet="{{ (float)$u->wallet_balance }}" 
                                data-method="{{ $defaultMethod }}">
                                {{ $u->name }} ({{ $u->email }}) — Wallet: ₹{{ number_format($u->wallet_balance) }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <div id="manualUserWalletNotice" style="margin-top: 5px; font-size: 0.8rem; color: #05B396; font-weight: 700; display: none;"></div>
            </div>

            <!-- Amount -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Payout Amount (₹) <span style="color: #ef4444;">*</span></label>
                <input type="number" step="0.01" name="amount" id="manualAmount" placeholder="e.g. 1500" required style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.96rem; font-weight: 700; box-sizing: border-box;">
            </div>

            <!-- Payment Method / UPI / Bank details -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Payment Method / Bank / UPI Details <span style="color: #ef4444;">*</span></label>
                <input type="text" name="payment_method" id="manualPaymentMethod" placeholder="e.g. UPI (student@oksbi) or Bank Account" required style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.92rem; font-weight: 600; box-sizing: border-box;">
            </div>

            <!-- UTR / Transaction Reference Number -->
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    UTR / Transaction Ref ID <span style="color: #64748b; font-weight: 500;">(Optional - appears in User Email)</span>
                </label>
                <input type="text" name="utr_number" placeholder="e.g. UTR1234567890 / IMPS Ref" style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.92rem; font-family: monospace; box-sizing: border-box;">
            </div>

            <!-- Remarks -->
            <div style="margin-bottom: 1.4rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Remarks / Note</label>
                <input type="text" name="remarks" placeholder="e.g. Monthly affiliate commission transfer" value="Direct manual payout disbursed by Super Admin" style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.88rem; box-sizing: border-box;">
            </div>

            <!-- Deduct from Wallet Checkbox -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px; margin-bottom: 1.6rem; display: flex; align-items: flex-start; gap: 10px;">
                <input type="checkbox" name="deduct_wallet" id="deductWalletCheckbox" value="1" checked style="margin-top: 3px; accent-color: #05B396; width: 18px; height: 18px; cursor: pointer;">
                <label for="deductWalletCheckbox" style="font-size: 0.85rem; color: #334155; font-weight: 600; cursor: pointer; line-height: 1.4;">
                    Deduct payout amount from affiliate wallet balance
                    <span style="display: block; font-size: 0.76rem; color: #64748b; font-weight: 500; margin-top: 2px;">
                        (Uncheck if this is an external bonus, offline advance, or already deducted)
                    </span>
                </label>
            </div>

            <button type="submit" id="manualPayoutSubmitBtn" style="width: 100%; padding: 0.95rem; background: #05B396; font-weight: 800; border-radius: 10px; border: none; color: #ffffff; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span>Disburse &amp; Send Email 💸✉️</span>
            </button>
        </form>
    </div>
</div>

<!-- Modal 2: Approve Payout with Optional UTR & Remarks -->
<div id="approvePayoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); z-index: 2100; align-items: center; justify-content: center; padding: 1rem; box-sizing: border-box;" onclick="handleModalBackdropClick(event, 'approvePayoutModal')">
    <div style="background: #ffffff; border-radius: 18px; padding: 2.2rem 2rem; max-width: 480px; width: 100%; border: 1px solid #e2e8f0; box-shadow: 0 25px 60px -15px rgba(0,0,0,0.3); position: relative; box-sizing: border-box;">
        <button type="button" onclick="closeApproveModal()" style="position: absolute; top: 18px; right: 20px; background: none; border: none; font-size: 1.6rem; color: #64748b; cursor: pointer; line-height: 1;">&times;</button>
        <h3 style="margin-bottom: 0.3rem; color: #0f172a; font-weight: 800; font-size: 1.35rem; display: flex; align-items: center; gap: 8px;">
            ✅ Approve &amp; Disburse Payout
        </h3>
        <p style="color: #64748b; font-size: 0.88rem; margin-bottom: 1.3rem;">
            Confirm bank/UPI transfer. An automated confirmation email will immediately be sent to the user.
        </p>

        <!-- Summary box -->
        <div style="background: #f0fdf4; border: 1px solid #a7f3d0; border-radius: 10px; padding: 14px 16px; margin-bottom: 1.4rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="font-size: 0.84rem; color: #64748b;">Payout Code:</span>
                <strong id="approveModalCode" style="font-family: monospace; color: #0f172a; font-size: 0.9rem;">#PAY-0000</strong>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="font-size: 0.84rem; color: #64748b;">Affiliate:</span>
                <strong id="approveModalUser" style="color: #0f172a; font-size: 0.9rem;">User</strong>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="font-size: 0.84rem; color: #64748b;">Transfer Amount:</span>
                <strong id="approveModalAmount" style="color: #05B396; font-size: 1.15rem; font-weight: 800;">₹0.00</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="font-size: 0.84rem; color: #64748b;">Payment Details:</span>
                <span id="approveModalMethod" style="color: #334155; font-size: 0.84rem; font-weight: 600; text-align: right; max-width: 60%;">UPI</span>
            </div>
        </div>

        <form id="approvePayoutForm" method="POST" action="" onsubmit="handleApproveSubmit(this)">
            @csrf
            <input type="hidden" name="status" value="Transferred">

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    Bank UTR / Transaction Reference ID
                    <span style="color: #64748b; font-weight: 500;">(Recommended)</span>
                </label>
                <input type="text" name="utr_number" placeholder="e.g. 432198765432" style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.92rem; font-family: monospace; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                    Remarks / Note <span style="color: #64748b; font-weight: 500;">(Optional)</span>
                </label>
                <input type="text" name="remarks" placeholder="e.g. Transferred via HDFC IMPS" style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.88rem; box-sizing: border-box;">
            </div>

            <button type="submit" id="approveSubmitBtn" style="width: 100%; padding: 0.95rem; background: #05B396; font-weight: 800; border-radius: 10px; border: none; color: #ffffff; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span>Confirm Transfer &amp; Send Email ✉️💸</span>
            </button>
        </form>
    </div>
</div>

<script>
function openManualPayoutModal() {
    document.getElementById('manualPayoutModal').style.display = 'flex';
}

function closeManualPayoutModal() {
    document.getElementById('manualPayoutModal').style.display = 'none';
}

function onManualUserChanged(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const walletBalance = selectedOption.getAttribute('data-wallet');
    const paymentMethod = selectedOption.getAttribute('data-method');
    const noticeEl = document.getElementById('manualUserWalletNotice');
    const methodInput = document.getElementById('manualPaymentMethod');
    const amountInput = document.getElementById('manualAmount');

    if (walletBalance !== null && selectEl.value) {
        noticeEl.style.display = 'block';
        noticeEl.innerText = `Available Wallet Balance: ₹${parseFloat(walletBalance).toLocaleString('en-IN')}`;
        if (parseFloat(walletBalance) > 0 && !amountInput.value) {
            amountInput.value = parseFloat(walletBalance);
        }
    } else {
        noticeEl.style.display = 'none';
    }

    if (paymentMethod && paymentMethod.trim() !== '') {
        methodInput.value = paymentMethod;
    }
}

function openApproveModal(id, code, user, amount, method) {
    document.getElementById('approveModalCode').innerText = '#' + code;
    document.getElementById('approveModalUser').innerText = user;
    document.getElementById('approveModalAmount').innerText = '₹' + amount;
    document.getElementById('approveModalMethod').innerText = method;
    document.getElementById('approvePayoutForm').action = `{{ url('/admin/payout') }}/${id}/status`;
    document.getElementById('approvePayoutModal').style.display = 'flex';
}

function closeApproveModal() {
    document.getElementById('approvePayoutModal').style.display = 'none';
}

function handleModalBackdropClick(e, modalId) {
    if (e.target.id === modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
}

function handleManualSubmit(form) {
    const btn = document.getElementById('manualPayoutSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span>Processing Payout &amp; Email... ⏳</span>';
}

function handleApproveSubmit(form) {
    const btn = document.getElementById('approveSubmitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span>Confirming &amp; Sending Email... ⏳</span>';
}
</script>

@include('portal.styles')
@endsection
