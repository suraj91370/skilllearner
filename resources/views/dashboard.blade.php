@extends('layouts.app')

@section('title', 'Affiliate Dashboard — CareerFixx')

@section('content')
<section class="container">
    <div style="display: grid; grid-template-columns: 290px 1fr; gap: 2.2rem;">
        <!-- Sidebar -->
        <aside class="glass" style="padding: 1.8rem; border-radius: var(--radius-md); height: fit-content;">
            <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-glass); margin-bottom: 1.5rem;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--primary-gradient); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 800;">
                    {{ substr(session('user.name', 'Suraj Sharma'), 0, 1) }}
                </div>
                <div>
                    <h4 style="font-size: 1rem;">{{ session('user.name', 'Suraj Sharma') }}</h4>
                    <span style="font-size: 0.75rem; color: var(--success); font-weight: 700;">● {{ session('user.kyc_status', 'Verified ✅') }}</span>
                </div>
            </div>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                <li><a href="{{ url('/dashboard') }}" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">📊 Overview & Wallet</a></li>
                <li><a href="{{ url('/classroom') }}" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">🎓 My Courses</a></li>
                <li><a href="javascript:void(0)" onclick="openModal('payoutModal')" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">💸 Request Payout</a></li>
                <li><a href="javascript:void(0)" onclick="alert('KYC is active under Aadhaar: XXXXXXXX4819 and PAN: ABCDE1234F')" class="btn btn-secondary" style="width: 100%; justify-content: flex-start;">🛡️ KYC Documents</a></li>
                <li><a href="{{ url('/logout') }}" class="btn btn-secondary" style="width: 100%; justify-content: flex-start; color: #ef4444;">🚪 Logout</a></li>
                <li><a href="{{ url('/reset-demo') }}" onclick="return confirm('Reset all demo state?')" class="btn btn-secondary" style="width: 100%; justify-content: flex-start; color: #94a3b8; font-size: 0.85rem;">🔄 Reset Account</a></li>
            </ul>
        </aside>

        <!-- Dashboard Content -->
        <main>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 2rem; font-weight: 800;">Affiliate Command Center</h2>
                    <p style="color: var(--text-body);">Active Tier: <strong style="color: #a855f7;">{{ session('user.active_package', 'Prime Package') }}</strong> | Referral Code: <code>{{ session('user.affiliate_id', 'CFX-8821') }}</code></p>
                </div>
                <a href="{{ url('/simulate-sale') }}" class="btn btn-primary" style="background: var(--secondary-gradient);">
                    ⚡ Simulate ₹2,200 New Sale
                </a>
            </div>

            <!-- Earnings Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1.4rem; margin-bottom: 2.2rem;">
                <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md); border-left: 4px solid var(--success);">
                    <h5 style="color: var(--text-body); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem;">TODAY'S EARNING</h5>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--success);">₹{{ number_format(session('user.today_earning', 2200)) }}</div>
                </div>
                <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md); border-left: 4px solid var(--primary);">
                    <h5 style="color: var(--text-body); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem;">LAST 7 DAYS</h5>
                    <div style="font-size: 2rem; font-weight: 800;">₹{{ number_format(session('user.weekly_earning', 7400)) }}</div>
                </div>
                <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md); border-left: 4px solid var(--gold);">
                    <h5 style="color: var(--text-body); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem;">TOTAL COMMISSIONS</h5>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--gold);">₹{{ number_format(session('user.total_earning', 48600)) }}</div>
                </div>
                <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md); border-left: 4px solid var(--success);">
                    <h5 style="color: var(--text-body); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem;">AVAILABLE WALLET</h5>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--success);">₹{{ number_format(session('user.wallet_balance', 14200)) }}</div>
                    <button onclick="openModal('payoutModal')" class="btn btn-secondary" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; margin-top: 0.6rem; width: 100%;">Withdraw Funds</button>
                </div>
            </div>

            <!-- Personal Referral Link Box -->
            <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                <h4 style="font-size: 1.05rem; margin-bottom: 0.4rem;">🔗 Your Personal Referral Link</h4>
                <p style="color: var(--text-body); font-size: 0.88rem; margin-bottom: 1rem;">Share this link on your Instagram bio, WhatsApp, or YouTube. When leads register, you receive up to 70% direct commissions.</p>
                <div style="display: flex; gap: 0.8rem;">
                    <input type="text" id="affiliateLink" class="form-control" value="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'CFX-8821') }}" readonly>
                    <button onclick="copyAffiliateLink()" class="btn btn-primary" style="white-space: nowrap;">Copy Link</button>
                </div>
            </div>

            <!-- Recent Commissions -->
            <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                <h4 style="margin-bottom: 1.2rem; font-size: 1.1rem;">👥 Real-Time Commission Log</h4>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Enrolled Student</th>
                            <th>Package</th>
                            <th>Your Profit</th>
                            <th>Type</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commissions as $comm)
                            <tr>
                                <td><strong>{{ $comm['name'] }}</strong></td>
                                <td>{{ $comm['package'] }}</td>
                                <td style="color: var(--success); font-weight: 700;">+₹{{ number_format($comm['amount']) }}</td>
                                <td><span style="background: rgba(99, 102, 241, 0.15); color: #818cf8; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">{{ $comm['type'] }}</span></td>
                                <td style="color: var(--text-body); font-size: 0.82rem;">{{ $comm['time'] }}</td>
                                <td><span style="color: var(--success); font-weight: 600;">● {{ $comm['status'] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Payout History -->
            <div class="glass" style="padding: 1.6rem; border-radius: var(--radius-md);">
                <h4 style="margin-bottom: 1.2rem; font-size: 1.1rem;">💳 Bank & UPI Withdrawal History</h4>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Payout ID</th>
                            <th>Amount</th>
                            <th>Destination Account</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payouts as $p)
                            <tr>
                                <td><code>{{ $p['id'] }}</code></td>
                                <td style="font-weight: 700;">₹{{ number_format($p['amount']) }}</td>
                                <td style="color: var(--text-body);">{{ $p['method'] }}</td>
                                <td><span style="color: {{ str_contains($p['status'], 'Transferred') ? 'var(--success)' : 'var(--gold)' }}; font-weight: 600;">● {{ $p['status'] }}</span></td>
                                <td style="color: var(--text-body); font-size: 0.82rem;">{{ $p['date'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</section>

<!-- Payout Modal -->
<div id="payoutModal" class="modal">
    <div class="modal-box">
        <button class="close-btn" onclick="closeModal('payoutModal')">&times;</button>
        <h3 style="margin-bottom: 0.6rem;">💸 Request Bank Withdrawal</h3>
        <p style="color: var(--text-body); font-size: 0.88rem; margin-bottom: 1.5rem;">Available Balance: <strong style="color: var(--success);">₹{{ number_format(session('user.wallet_balance', 14200)) }}</strong></p>
        
        <form method="POST" action="{{ url('/payout-request') }}">
            @csrf
            <div class="form-group">
                <label>Amount (Min ₹500)</label>
                <input type="number" name="payout_amount" class="form-control" value="2000" min="500" max="{{ session('user.wallet_balance', 14200) }}" required>
            </div>
            <div class="form-group">
                <label>UPI ID or Bank Account Details</label>
                <input type="text" name="payout_details" class="form-control" placeholder="suraj@okaxis or HDFC A/C No." required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem;">Submit Withdrawal Request</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyAffiliateLink() {
        const input = document.getElementById('affiliateLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Link Copied to Clipboard!\n' + input.value);
            });
        }
    }
</script>
@endpush
