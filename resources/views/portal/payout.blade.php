@extends('layouts.app')

@section('title', 'My Payouts — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'payout'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'payout'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.95rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 700; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(5, 179, 150, 0.08);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 1.3rem; cursor: pointer; color: #166534; line-height: 1;">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.95rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 700; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.08);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 1.3rem; cursor: pointer; color: #991b1b; line-height: 1;">&times;</button>
                </div>
            @endif

            <!-- Page Header: Exact to Screenshot -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: -0.3px;">
                    My Payouts
                </h2>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 0.92rem; color: #64748b;">
                        Wallet Balance: <strong style="color: #05B396; font-size: 1.15rem;">₹{{ number_format(session('user.wallet_balance', 0)) }}</strong>
                    </span>
                    <button type="button" onclick="openPayoutModal()" class="btn btn-primary" style="background: #05B396; font-weight: 700; padding: 0.65rem 1.3rem; border-radius: 8px; border: none; color: #ffffff; cursor: pointer; box-shadow: 0 4px 12px rgba(5, 179, 150, 0.25);">
                        + Request Withdrawal
                    </button>
                </div>
            </div>

            <!-- Table Card: Exact to Screenshot -->
            <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
                <div class="table-responsive-wrapper" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; background: #ffffff;">
                                <th style="padding: 16px 24px; font-size: 0.8rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.4px;">CREATED DATE</th>
                                <th style="padding: 16px 24px; font-size: 0.8rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.4px;">UPDATED DATE</th>
                                <th style="padding: 16px 24px; font-size: 0.8rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.4px;">AMOUNT</th>
                                <th style="padding: 16px 24px; font-size: 0.8rem; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.4px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payouts as $p)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#fbfcfd'" onmouseout="this.style.background='#ffffff'">
                                    <td style="padding: 16px 24px; color: #334155; font-weight: 500;">
                                        {{ $p['created_date'] ?? date('d-m-Y') }}
                                    </td>
                                    <td style="padding: 16px 24px; color: #334155; font-weight: 500;">
                                        {{ $p['updated_date'] ?? date('d-m-Y') }}
                                    </td>
                                    <td style="padding: 16px 24px; color: #334155; font-weight: 500;">
                                        {{ $p['amount_formatted'] ?? number_format($p['amount'], 0, '', '') }}
                                    </td>
                                    <td style="padding: 16px 24px;">
                                        @if($p['status'] === 'Paid' || $p['status'] === 'Transferred' || $p['status'] === 'Approved')
                                            <span style="background: #10b981; color: #ffffff; font-weight: 700; font-size: 0.8rem; padding: 4px 14px; border-radius: 6px; display: inline-block;">Paid</span>
                                        @elseif($p['status'] === 'Pending')
                                            <span style="background: #f59e0b; color: #ffffff; font-weight: 700; font-size: 0.8rem; padding: 4px 14px; border-radius: 6px; display: inline-block;">Pending</span>
                                        @elseif($p['status'] === 'Rejected')
                                            <span style="background: #ef4444; color: #ffffff; font-weight: 700; font-size: 0.8rem; padding: 4px 14px; border-radius: 6px; display: inline-block;">Rejected</span>
                                        @else
                                            <span style="background: #64748b; color: #ffffff; font-weight: 700; font-size: 0.8rem; padding: 4px 14px; border-radius: 6px; display: inline-block;">{{ $p['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 3rem 1rem; color: #94a3b8; font-size: 0.95rem;">
                                        No payout records found.
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

<!-- Modal for Payout -->
<div id="payoutModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); z-index: 2000; align-items: center; justify-content: center; padding: 1rem; box-sizing: border-box;" onclick="handlePayoutModalClick(event)">
    <div class="modal-box" style="background: #ffffff; border-radius: 18px; padding: 2.2rem 2rem; max-width: 480px; width: 100%; border: 1px solid #e2e8f0; box-shadow: 0 25px 60px -15px rgba(0,0,0,0.3); position: relative; box-sizing: border-box;">
        <button type="button" onclick="closePayoutModal()" style="position: absolute; top: 18px; right: 20px; background: none; border: none; font-size: 1.6rem; color: #64748b; cursor: pointer; line-height: 1;">&times;</button>
        <h3 style="margin-bottom: 0.4rem; color: #0f172a; font-weight: 800; font-size: 1.35rem; display: flex; align-items: center; gap: 8px;">💸 Request Bank Withdrawal</h3>
        <p style="color: #64748b; font-size: 0.92rem; margin-bottom: 1.5rem;">Available Balance: <strong style="color: #05B396; font-size: 1.05rem;">₹{{ number_format(session('user.wallet_balance', 0)) }}</strong></p>
        
        <form method="POST" action="{{ route('portal.payout-request') }}" onsubmit="handleSubmitPrevention(this)">
            @csrf
            <div style="margin-bottom: 1.3rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Amount to Withdraw (Min ₹500)</label>
                <input 
                    type="number" 
                    name="payout_amount" 
                    value="" 
                    min="500" 
                    max="{{ (int)session('user.wallet_balance', 0) }}" 
                    placeholder="Enter amount (e.g. 1000)" 
                    style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.96rem; font-weight: 700; box-sizing: border-box;" 
                    required
                >
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 6px;">UPI ID or Bank Account Details</label>
                <input 
                    type="text" 
                    name="payout_details" 
                    value="{{ session('user.upi_id', 'suraj@okhdfcbank') }}" 
                    placeholder="suraj@okhdfcbank or Bank A/C No. & IFSC" 
                    style="width: 100%; padding: 0.85rem 1.1rem; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 10px; color: #0f172a; font-size: 0.96rem; font-weight: 600; box-sizing: border-box;" 
                    required
                >
            </div>
            <button type="submit" id="submitWithdrawBtn" style="width: 100%; padding: 0.95rem; background: #05B396; font-weight: 800; border-radius: 10px; border: none; color: #ffffff; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3);">Submit Withdrawal Request</button>
        </form>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function openPayoutModal() {
        const m = document.getElementById('payoutModal');
        if (m) {
            m.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            const input = m.querySelector('input[name="payout_amount"]');
            if (input) setTimeout(() => input.focus(), 100);
        }
    }
    function closePayoutModal() {
        const m = document.getElementById('payoutModal');
        if (m) {
            m.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    function handlePayoutModalClick(e) {
        if (e.target && e.target.id === 'payoutModal') {
            closePayoutModal();
        }
    }
    function handleSubmitPrevention(form) {
        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerText = 'Submitting Request...';
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePayoutModal();
    });
</script>
@endpush
@endsection
