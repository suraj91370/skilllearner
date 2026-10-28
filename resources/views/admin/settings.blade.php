@extends('layouts.app')

@section('title', 'Platform & System Settings — SkillLearner Super Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-settings'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-settings'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(124, 58, 237, 0.12); color: #7c3aed; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-bottom: 0.4rem;">
                        👑 SUPER ADMIN EXCLUSIVE ACCESS
                    </div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        ⚙️ Platform &amp; System Configuration
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Global control parameters, commission percentages, payout thresholds, and system utilities.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1.1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;" class="settings-grid">
                <!-- Left: Settings Form -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 18px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                    <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 1.4rem;">
                        Platform Commission &amp; Payout Rules
                    </h3>

                    <form method="POST" action="{{ url('/admin/settings') }}">
                        @csrf
                        
                        <div style="margin-bottom: 1.3rem;">
                            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Platform Brand Name
                            </label>
                            <input type="text" name="platform_name" value="{{ old('platform_name', session('platform_settings.platform_name', 'SkillLearner EdTech')) }}" required class="clean-form-input">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.3rem;">
                            <div>
                                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                    Tier-1 Direct Commission (%)
                                </label>
                                <input type="number" step="0.5" name="tier1_commission" value="{{ old('tier1_commission', session('platform_settings.tier1_commission', 70)) }}" required class="clean-form-input">
                                <span style="font-size: 0.72rem; color: #64748b;">Paid directly to sponsor affiliate</span>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                    Tier-2 Passive Commission (%)
                                </label>
                                <input type="number" step="0.5" name="tier2_commission" value="{{ old('tier2_commission', session('platform_settings.tier2_commission', 10)) }}" required class="clean-form-input">
                                <span style="font-size: 0.72rem; color: #64748b;">Paid to secondary upline</span>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.6rem;">
                            <label style="display: block; font-size: 0.88rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Minimum Withdrawal Threshold (₹)
                            </label>
                            <input type="number" name="min_payout_amount" value="{{ old('min_payout_amount', session('platform_settings.min_payout_amount', 1000)) }}" required class="clean-form-input">
                            <span style="font-size: 0.72rem; color: #64748b;">Minimum wallet balance required to request payout</span>
                        </div>

                        <button type="submit" style="background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: #ffffff; border: none; padding: 0.8rem 1.6rem; border-radius: 8px; font-weight: 800; cursor: pointer; box-shadow: 0 4px 16px rgba(124, 58, 237, 0.35); font-size: 0.95rem;">
                            Save Platform Settings 💾
                        </button>
                    </form>
                </div>

                <!-- Right: Quick Super Admin Actions -->
                <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                    <!-- Super Admin Info Card -->
                    <div style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); border-radius: 18px; padding: 1.5rem; color: #ffffff; box-shadow: 0 10px 25px rgba(30, 27, 75, 0.2);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                            <span style="font-size: 1.6rem;">👑</span>
                            <div>
                                <h4 style="margin: 0; font-size: 1.05rem; font-weight: 800;">Master Super Admin</h4>
                                <span style="font-size: 0.76rem; color: #a5b4fc;">Full system access enabled</span>
                            </div>
                        </div>
                        <p style="font-size: 0.82rem; color: #cbd5e1; line-height: 1.5; margin-bottom: 1rem;">
                            You have authority to assign and demote user roles, modify financial rules, and review operations logs.
                        </p>
                        <div style="font-size: 0.78rem; background: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 0.6rem 0.8rem;">
                            🔒 Super Admin endpoints are guarded by strict role middleware.
                        </div>
                    </div>

                    <!-- Video Option & Show/Hide Card -->
                    <div style="background: #ffffff; border: 1.5px solid #e0e7ff; border-radius: 18px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(79, 70, 229, 0.05);">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.4rem;">
                            <span style="font-size: 1.2rem;">🎥</span>
                            <h4 style="color: #4338ca; font-size: 1rem; font-weight: 800; margin: 0;">
                                Video Option &amp; Show/Hide
                            </h4>
                        </div>
                        <p style="font-size: 0.82rem; color: #64748b; margin-bottom: 1rem; line-height: 1.45;">
                            Add new training videos and toggle whether they are shown or hidden for student accounts.
                        </p>
                        <a href="{{ url('/admin/videos') }}" style="display: block; text-align: center; background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%); color: #ffffff; padding: 0.65rem 1rem; border-radius: 8px; font-weight: 800; text-decoration: none; font-size: 0.85rem; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.3);">
                            Manage Videos &amp; Visibility ➔
                        </a>
                    </div>

                    <!-- Reset Demo State Card -->
                    <div style="background: #ffffff; border: 1.5px solid #fee2e2; border-radius: 18px; padding: 1.5rem;">
                        <h4 style="color: #991b1b; font-size: 0.98rem; font-weight: 800; margin-bottom: 0.5rem;">
                            ⚠️ Reset Demo Session
                        </h4>
                        <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem; line-height: 1.45;">
                            Clear current role session and return to clean login state for testing different roles.
                        </p>
                        <a href="{{ url('/reset-demo') }}" style="display: block; text-align: center; background: #fee2e2; color: #991b1b; padding: 0.65rem 1rem; border-radius: 8px; font-weight: 800; text-decoration: none; font-size: 0.85rem; transition: background 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                            Reset Demo State &amp; Logout ➔
                        </a>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

@include('portal.styles')

@push('styles')
<style>
    @media (max-width: 900px) {
        .settings-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush
@endsection
