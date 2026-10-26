@extends('layouts.app')

@section('title', 'KYC Verification Approvals — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-kyc'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-kyc'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        📋 KYC Verification Queue
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Review government document submissions, verify bank accounts, and approve affiliate payout eligibility.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ℹ️ {{ session('info') }}
                </div>
            @endif

            <!-- KYC Queue Cards -->
            <div style="display: grid; gap: 1.2rem;">
                @forelse($kycList as $kyc)
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.4rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                            <!-- User info -->
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(5, 179, 150, 0.12); color: #05B396; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                                    {{ substr($kyc->user?->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">{{ $kyc->user?->name ?? 'User #'.$kyc->user_id }}</div>
                                    <div style="font-size: 0.82rem; color: #64748b;">{{ $kyc->user?->email }} • {{ $kyc->user?->phone }}</div>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                @if($kyc->status === 'Verified')
                                    <span style="background: #f0fdf4; color: #166534; font-weight: 800; font-size: 0.8rem; padding: 5px 12px; border-radius: 20px; border: 1px solid #bbf7d0;">Verified ✅</span>
                                @elseif($kyc->status === 'Rejected')
                                    <span style="background: #fef2f2; color: #991b1b; font-weight: 800; font-size: 0.8rem; padding: 5px 12px; border-radius: 20px; border: 1px solid #fecaca;">Rejected ❌</span>
                                @else
                                    <span style="background: #fffbeb; color: #b45309; font-weight: 800; font-size: 0.8rem; padding: 5px 12px; border-radius: 20px; border: 1px solid #fde68a;">Pending Verification ⏳</span>
                                @endif
                            </div>
                        </div>

                        <!-- Document & Bank Details Grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.85rem; background: #f8fafc; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; border: 1px solid #f1f5f9;">
                            <div>
                                <span style="font-size: 0.72rem; color: #64748b; font-weight: 700; text-transform: uppercase;">AADHAR NUMBER</span>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">{{ $kyc->aadhar_number ?? 'Not submitted' }}</div>
                            </div>
                            <div>
                                <span style="font-size: 0.72rem; color: #64748b; font-weight: 700; text-transform: uppercase;">PAN NUMBER</span>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">{{ $kyc->pan_number ?? 'Not submitted' }}</div>
                            </div>
                            <div>
                                <span style="font-size: 0.72rem; color: #64748b; font-weight: 700; text-transform: uppercase;">BANK &amp; ACCOUNT</span>
                                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">{{ $kyc->bank_name ?? 'HDFC Bank' }} ({{ $kyc->account_number ?? '••••4819' }})</div>
                            </div>
                            <div>
                                <span style="font-size: 0.72rem; color: #64748b; font-weight: 700; text-transform: uppercase;">UPI ID &amp; IFSC</span>
                                <div style="font-weight: 700; color: #05B396; font-size: 0.9rem;">{{ $kyc->upi_id ?? 'suraj@okaxis' }}</div>
                            </div>
                        </div>

                        @if($kyc->remarks)
                            <div style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">
                                <strong>Audit Note:</strong> {{ $kyc->remarks }}
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                            <form method="POST" action="{{ url('/admin/kyc/'.$kyc->id.'/reject') }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: #ffffff; border: 1.5px solid #ef4444; color: #ef4444; padding: 0.45rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#ffffff'">
                                    ✕ Reject KYC
                                </button>
                            </form>

                            <form method="POST" action="{{ url('/admin/kyc/'.$kyc->id.'/approve') }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: #05B396; border: none; color: #ffffff; padding: 0.45rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; box-shadow: 0 2px 10px rgba(5, 179, 150, 0.3); transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    ✓ Approve KYC
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 3rem 1.5rem; text-align: center; color: #64748b;">
                        🎉 All user KYC verification requests are currently up to date!
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

@include('portal.styles')
@endsection
