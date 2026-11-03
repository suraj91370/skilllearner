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
            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.95rem 1.2rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.95rem; font-weight: 700; box-shadow: 0 2px 10px rgba(5, 179, 150, 0.1);">
                    {{ session('success') }}
                </div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Affiliate Command Center</h2>
                    <p style="color: #64748b; font-size: 0.92rem;">Active Tier: <strong style="color: #05B396;">{{ session('user.active_package', 'Advance Package') }}</strong> | Referral ID: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a; font-weight: 700;">{{ session('user.affiliate_id', 'SL-8821') }}</code></p>
                </div>
                <button type="button" onclick="window.openLoginVideoModal()" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(5, 179, 150, 0.12); border: 1.5px solid #05B396; color: #05B396; padding: 0.6rem 1.15rem; border-radius: 10px; font-weight: 700; font-size: 0.88rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(5, 179, 150, 0.15);" onmouseover="this.style.background='#05B396'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(5, 179, 150, 0.12)'; this.style.color='#05B396';">
                    <span style="font-size: 1.1rem;">🎬</span>
                    <span>Watch Welcome Video</span>
                </button>
            </div>

            <!-- Earnings Grid (Responsive 4 cols desktop, 2 cols mobile) -->
            <!-- 6 Income Metric Cards (Today, Last 7 Day, Last 30 Day, All Time, All Time Passive, Pending Verification) -->
            <div class="earnings-grid-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.8rem;">
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

                <!-- 6. Pending Verification Income -->
                <div class="income-card" style="border-top: 4px solid #f59e0b; background: #fffbeb; border: 1px solid #fde68a;">
                    <h5 class="income-card-label" style="color: #b45309;">PENDING VERIFICATION</h5>
                    <div class="income-card-value" style="color: #b45309;">₹{{ number_format($pendingCommissions ?? 0) }}</div>
                    <div class="income-card-sub" style="color: #92400e; font-weight: 600;">⏳ Credits after admin approval</div>
                </div>
            </div>

            <!-- Active & Passive Income Distribution Matrix (2-Tier Hierarchy) -->
            <div class="portal-box-card" style="border: 1.5px solid #e0e7ff; background: linear-gradient(180deg, #ffffff 0%, #faf5ff 100%);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.2rem;">
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.1); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                            ⚡ 2-TIER REFERRAL COMMISSION RATES
                        </div>
                        <h4 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">
                            Active &amp; Passive Income Distribution Plan
                        </h4>
                        <p style="color: #64748b; font-size: 0.88rem; margin: 0;">
                            Refer directly to earn <strong>Active Income</strong>. When your direct members refer others, you earn <strong>Passive Income</strong>. Strictly 2 levels only (Level 3+ receives ₹0).
                        </p>
                    </div>
                </div>

                <!-- 2-Tier Explanation Visual Flow -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1rem; margin-bottom: 1.4rem;">
                    <div style="background: #ffffff; border: 1.5px solid #a7f3d0; border-radius: 12px; padding: 1rem; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.05);">
                        <div style="font-size: 0.74rem; font-weight: 800; color: #059669; letter-spacing: 0.5px;">LEVEL 1 • DIRECT REFERRAL</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #065f46; margin: 3px 0;">🟢 Active Income</div>
                        <div style="font-size: 0.82rem; color: #475569; line-height: 1.4;">
                            You directly refer Member B. Once their payment is verified, you receive <strong>Active Income</strong> (up to ₹5,500).
                        </div>
                    </div>
                    <div style="background: #ffffff; border: 1.5px solid #ddd6fe; border-radius: 12px; padding: 1rem; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.05);">
                        <div style="font-size: 0.74rem; font-weight: 800; color: #7c3aed; letter-spacing: 0.5px;">LEVEL 2 • TEAM MEMBER'S REFERRAL</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #5b21b6; margin: 3px 0;">💎 Passive Income</div>
                        <div style="font-size: 0.82rem; color: #475569; line-height: 1.4;">
                            Member B refers Member C. Member B gets Active Income, and <strong>YOU get Passive Income</strong> (up to ₹500).
                        </div>
                    </div>
                    <div style="background: #ffffff; border: 1.5px solid #fecaca; border-radius: 12px; padding: 1rem; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.05);">
                        <div style="font-size: 0.74rem; font-weight: 800; color: #dc2626; letter-spacing: 0.5px;">LEVEL 3+ • STRICT STOP</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #991b1b; margin: 3px 0;">🛑 ₹0 Commission</div>
                        <div style="font-size: 0.82rem; color: #475569; line-height: 1.4;">
                            Member C refers Member D. Member C gets Active, Member B gets Passive. <strong>You get ₹0</strong> (2-tier limit enforced).
                        </div>
                    </div>
                </div>

                <!-- Package Rates Table (Reference only, no artificial self-credit buttons) -->
                <div class="table-responsive-wrapper">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left; background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
                                <th style="padding: 12px 14px;">Package Name</th>
                                <th style="padding: 12px 14px;">Package Price</th>
                                <th style="padding: 12px 14px; color: #059669;">⚡ Active Income (Tier-1)</th>
                                <th style="padding: 12px 14px; color: #7c3aed;">💎 Passive Income (Tier-2)</th>
                                <th style="padding: 12px 14px; color: #94a3b8;">Level 3+</th>
                                <th style="padding: 12px 14px; text-align: right;">Payment Crediting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $pkg)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px 14px; font-weight: 800; color: #0f172a;">
                                        {{ $pkg['name'] }}
                                    </td>
                                    <td style="padding: 12px 14px; font-weight: 700; color: #334155;">
                                        ₹{{ number_format($pkg['price']) }}
                                    </td>
                                    <td style="padding: 12px 14px; font-weight: 800; color: #059669; font-size: 1rem;">
                                        +₹{{ number_format($pkg['active_income']) }}/-
                                    </td>
                                    <td style="padding: 12px 14px; font-weight: 800; color: #7c3aed; font-size: 1rem;">
                                        +₹{{ number_format($pkg['passive_income']) }}/-
                                    </td>
                                    <td style="padding: 12px 14px; color: #94a3b8; font-weight: 600;">
                                        ₹0 (Strict 2 tiers)
                                    </td>
                                    <td style="padding: 12px 14px; text-align: right;">
                                        <span style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; display: inline-block;">
                                            🛡️ Verified by Admin
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1rem; padding: 0.85rem 1rem; background: #f8fafc; border-radius: 8px; font-size: 0.84rem; color: #64748b; display: flex; align-items: center; gap: 8px;">
                    <span>🔒</span>
                    <span><strong>Security Note:</strong> Commissions are added to your wallet automatically as soon as your referred student completes payment and it is confirmed by the verification team.</span>
                </div>
            </div>

            <!-- Personal Referral Link -->
            <div class="portal-box-card" style="border: 1.5px solid #a7f3d0; background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem; flex-wrap: wrap; gap: 8px;">
                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #064e3b; margin: 0;">🌟 Your Common All-Packages Referral Link</h4>
                    <a href="{{ url('/affiliate-link') }}" style="font-size: 0.82rem; font-weight: 700; color: #05B396; text-decoration: underline;">
                        Need individual package links? Click here ➔
                    </a>
                </div>
                <p style="color: #475569; font-size: 0.88rem; margin-bottom: 1rem;">
                    Jab aap ye Common Link share karenge, to buyer ke samne <strong>sabhi 5 packages</strong> khulenge aur wo koi bhi package purchase kar sakta hai.
                </p>
                <div class="referral-box-row">
                    <input type="text" id="portalAffiliateLink" style="flex: 1; padding: 0.75rem 1rem; border: 1.5px solid #a7f3d0; border-radius: 8px; font-size: 0.92rem; background: #ffffff; color: #065f46; font-weight: 700;" value="{{ url('/plans') }}?ref={{ session('user.affiliate_id', 'SL-8821') }}" readonly>
                    <button type="button" onclick="copyPortalLink()" class="btn btn-primary" style="background: #05B396; color: #fff; padding: 0.75rem 1.4rem; font-weight: 700; border-radius: 8px; white-space: nowrap;">Copy Common Link</button>
                    <a href="{{ url('/affiliate-link') }}" class="btn" style="background: #ffffff; border: 1.5px solid #a7f3d0; color: #047857; font-size: 0.86rem; font-weight: 700; padding: 0.75rem 1.1rem; border-radius: 8px; text-decoration: none; white-space: nowrap;">
                        🎯 All 5 Package Links ➔
                    </a>
                </div>
            </div>

            <!-- Commission Table -->
            <div class="portal-box-card">
                <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.2rem;">👥 Real-Time Commission Log</h4>
                <div class="table-responsive-wrapper">
                    <table style="border-collapse: collapse; font-size: 0.92rem; text-align: left; width: 100%;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Enrolled Student</th>
                                <th style="padding: 10px;">Package</th>
                                <th style="padding: 10px;">Your Profit</th>
                                <th style="padding: 10px;">Type</th>
                                <th style="padding: 10px;">Time</th>
                                <th style="padding: 10px;">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commissions as $comm)
                                @php
                                    $isPassive = str_contains(strtolower($comm['type'] ?? ''), 'passive');
                                    $isPending = str_contains(strtolower($comm['status'] ?? ''), 'pending');
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                                    <td style="padding: 12px 10px;"><strong>{{ $comm['name'] }}</strong></td>
                                    <td style="padding: 12px 10px;">{{ $comm['package'] }}</td>
                                    <td style="padding: 12px 10px; font-weight: 700; color: {{ $isPending ? '#d97706' : ($isPassive ? '#7c3aed' : '#10b981') }};">
                                        {{ $isPending ? '₹' . number_format($comm['amount']) . ' (Pending)' : '+₹' . number_format($comm['amount']) }}
                                    </td>
                                    <td style="padding: 12px 10px;">
                                        <span style="background: {{ $isPassive ? '#ede9fe' : '#ccfbf1' }}; color: {{ $isPassive ? '#6d28d9' : '#048873' }}; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
                                            {{ $comm['type'] }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 10px; color: #64748b; font-size: 0.82rem;">{{ $comm['time'] }}</td>
                                    <td style="padding: 12px 10px;">
                                        @if($isPending)
                                            <span style="background: #fef3c7; color: #b45309; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 800; border: 1px solid #fde68a;">
                                                ⏳ Pending (Verifying Payment)
                                            </span>
                                        @else
                                            <span style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 800; border: 1px solid #bbf7d0;">
                                                ● Credited (In Wallet)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem 1rem; color: #94a3b8;">
                                        No commissions recorded yet. Share your referral link to start earning!
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
