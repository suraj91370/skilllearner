@extends('layouts.app')

@section('title', 'Affiliate Command Center — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'dashboard'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'dashboard'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Affiliate Command Center</h2>
                    <p style="color: #64748b; font-size: 0.92rem;">Active Tier: <strong style="color: #05B396;">{{ session('user.active_package', 'Advance Package') }}</strong> | Referral ID: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a; font-weight: 700;">{{ session('user.affiliate_id', 'SL-8821') }}</code></p>
                </div>
            </div>

            <!-- Earnings Grid (Responsive 4 cols desktop, 2 cols mobile) -->
                        <!-- 5 Income Metric Cards (Today, Last 7 Day, Last 30 Day, All Time, All Time Passive) -->
            <div class="earnings-grid-container">
                <!-- 1. Today Income -->
                <div class="income-card border-today">
                    <h5 class="income-card-label">TODAY INCOME</h5>
                    <div class="income-card-value text-emerald">₹{{ number_format(session('user.today_earning', 2200)) }}</div>
                    <div class="income-card-sub">⚡ Today's Direct Profit</div>
                </div>

                <!-- 2. Last 7 Day -->
                <div class="income-card border-blue">
                    <h5 class="income-card-label">LAST 7 DAY</h5>
                    <div class="income-card-value text-dark">₹{{ number_format(session('user.weekly_earning', 7400)) }}</div>
                    <div class="income-card-sub">📅 Last 7 Days Performance</div>
                </div>

                <!-- 3. Last 30 Day -->
                <div class="income-card border-purple">
                    <h5 class="income-card-label">LAST 30 DAY</h5>
                    <div class="income-card-value text-purple">₹{{ number_format(session('user.monthly_earning', 21500)) }}</div>
                    <div class="income-card-sub">📈 Last 30 Days Growth</div>
                </div>

                <!-- 4. All Time Income -->
                <div class="income-card border-amber">
                    <h5 class="income-card-label">ALL TIME INCOME</h5>
                    <div class="income-card-value text-amber">₹{{ number_format(session('user.total_earning', 48600)) }}</div>
                    <div class="income-card-sub">🏆 Total Direct + Bonus</div>
                </div>

                <!-- 5. All Time Passive Income -->
                <div class="income-card border-teal">
                    <h5 class="income-card-label">ALL TIME PASSIVE INCOME</h5>
                    <div class="income-card-value text-teal">₹{{ number_format(session('user.passive_earning', 8400)) }}</div>
                    <div class="income-card-sub">💎 Tier-2 Non-Working Bonus</div>
                </div>
            </div>

            <!-- Personal Referral Link -->
            <div class="portal-box-card">
                <h4 style="font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: 0.4rem;">🔗 Your Personal Referral Link</h4>
                <p style="color: #64748b; font-size: 0.88rem; margin-bottom: 1rem;">Share your link on WhatsApp, Instagram bio, or YouTube. Earn 70% direct commission instantly upon lead signup.</p>
                <div class="referral-box-row">
                    <input type="text" id="portalAffiliateLink" style="flex: 1; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.92rem; background: #f8fafc; color: #0f172a;" value="{{ url('/register') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}" readonly>
                    <button type="button" onclick="copyPortalLink()" class="btn btn-primary" style="background: #05B396; color: #fff; padding: 0.75rem 1.4rem; font-weight: 700; border-radius: 8px; white-space: nowrap;">Copy Link</button>
                </div>
            </div>

            <!-- Commission Table -->
            <div class="portal-box-card">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.2rem;">👥 Real-Time Commission Log</h4>
                <div class="table-responsive-wrapper">
                    <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Enrolled Student</th>
                                <th style="padding: 10px;">Package</th>
                                <th style="padding: 10px;">Your Profit</th>
                                <th style="padding: 10px;">Type</th>
                                <th style="padding: 10px;">Time</th>
                                <th style="padding: 10px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $comm)
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                    <td style="padding: 12px 10px;"><strong>{{ $comm['name'] }}</strong></td>
                                    <td style="padding: 12px 10px;">{{ $comm['package'] }}</td>
                                    <td style="padding: 12px 10px; color: #10b981; font-weight: 700;">+₹{{ number_format($comm['amount']) }}</td>
                                    <td style="padding: 12px 10px;"><span style="background: #ccfbf1; color: #048873; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">{{ $comm['type'] }}</span></td>
                                    <td style="padding: 12px 10px; color: #64748b; font-size: 0.82rem;">{{ $comm['time'] }}</td>
                                    <td style="padding: 12px 10px; color: #10b981; font-weight: 600;">● {{ $comm['status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function copyPortalLink() {
        const input = document.getElementById('portalAffiliateLink');
        if (input) {
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                alert('✅ Referral Link Copied to Clipboard!\n' + input.value);
            });
        }
    }
</script>
@endpush
@endsection
