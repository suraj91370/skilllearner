@extends('layouts.app')

@section('title', 'My Payout — SkillLearner')

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
            <div class="portal-box-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3 style="font-size: 1.5rem; color: #0f172a; font-weight: 800;">💳 Bank &amp; UPI Withdrawal Portal</h3>
                        <p style="color: #64748b; font-size: 0.92rem;">Available to Withdraw: <strong style="color: #10b981; font-size: 1.3rem;">₹{{ number_format(session('user.wallet_balance', 14200)) }}</strong></p>
                    </div>
                    <button type="button" onclick="openPayoutModal()" class="btn btn-primary" style="background: #10b981; font-weight: 700; padding: 0.75rem 1.4rem;">
                        + Request New Withdrawal
                    </button>
                </div>

                <div class="table-responsive-wrapper">
                    <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left; width: 100%;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Payout ID</th>
                                <th style="padding: 10px;">Amount</th>
                                <th style="padding: 10px;">Destination Account</th>
                                <th style="padding: 10px;">Status</th>
                                <th style="padding: 10px;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payouts as $p)
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                    <td style="padding: 12px 10px;"><code>{{ $p['id'] }}</code></td>
                                    <td style="padding: 12px 10px; font-weight: 700; color: #0f172a;">₹{{ number_format($p['amount']) }}</td>
                                    <td style="padding: 12px 10px; color: #64748b;">{{ $p['method'] }}</td>
                                    <td style="padding: 12px 10px; color: #10b981; font-weight: 600;">● {{ $p['status'] }}</td>
                                    <td style="padding: 12px 10px; color: #64748b; font-size: 0.82rem;">{{ $p['date'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem; color: #94a3b8;">No payout requests found yet.</td>
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
<div id="payoutModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 2000; align-items: center; justify-content: center; padding: 1rem;">
    <div class="modal-box" style="background: #ffffff; border-radius: 16px; padding: 2rem; max-width: 480px; width: 100%; border: 1px solid #e2e8f0; box-shadow: 0 20px 45px rgba(0,0,0,0.2); position: relative;">
        <button type="button" onclick="closePayoutModal()" style="position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
        <h3 style="margin-bottom: 0.5rem; color: #0f172a; font-weight: 800; font-size: 1.3rem;">💸 Request Bank Withdrawal</h3>
        <p style="color: #64748b; font-size: 0.88rem; margin-bottom: 1.5rem;">Available Balance: <strong style="color: #10b981;">₹{{ number_format(session('user.wallet_balance', 14200)) }}</strong></p>
        
        <form method="POST" action="{{ url('/payout-request') }}">
            @csrf
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">Amount to Withdraw (Min ₹500)</label>
                <input type="number" name="payout_amount" value="2000" min="500" max="{{ session('user.wallet_balance', 14200) }}" style="width: 100%; padding: 0.75rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; color: #0f172a; font-size: 0.95rem; font-weight: 700;" required>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px;">UPI ID or Bank Account Details</label>
                <input type="text" name="payout_details" value="suraj@okhdfcbank" placeholder="yourname@okhdfcbank or HDFC A/C No." style="width: 100%; padding: 0.75rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; color: #0f172a; font-size: 0.92rem;" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; background: #05B396; font-weight: 800; border-radius: 8px; border: none; color: #ffffff; cursor: pointer;">Submit Withdrawal Request</button>
        </form>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function openPayoutModal() {
        const m = document.getElementById('payoutModal');
        if (m) m.style.display = 'flex';
    }
    function closePayoutModal() {
        const m = document.getElementById('payoutModal');
        if (m) m.style.display = 'none';
    }
</script>
@endpush
@endsection
