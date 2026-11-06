@extends('layouts.app')

@section('title', 'My Profile — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'profile'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'profile'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            
            @if(session('success'))
                <div class="profile-alert success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="profile-alert error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="profile-layout-grid">
                <!-- ==========================================
                     1. LEFT OVERVIEW CARD (Exact to Screenshot)
                     ========================================== -->
                <div class="profile-overview-card">
                    <!-- Dark Header Banner with Avatar & Verified Badge -->
                    <div class="profile-header-dark">
                        <div class="profile-avatar-wrapper">
                            @php
                                $displayAvatar = !empty(session('user.avatar')) ? session('user.avatar') : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop&q=80';
                            @endphp
                            <img src="{{ $displayAvatar }}" 
                                 alt="{{ session('user.name', 'Addy') }}" 
                                 class="profile-avatar-img" id="overviewAvatarImg"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop&q=80';">
                            <span class="profile-verified-badge" title="Verified Member">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                        </div>
                        <h3 class="profile-user-name">{{ session('user.name', 'Addy') }}</h3>
                        <p class="profile-user-email">{{ session('user.email', 'adarah242@gmail.com') }}</p>
                    </div>

                    <!-- Lower Information List -->
                    <div class="profile-overview-body">
                        <!-- Ref Code Row -->
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    <polyline points="9 12 11 14 15 10"></polyline>
                                </svg>
                                <span>Ref Code</span>
                            </div>
                            <div class="profile-info-val-wrap">
                                <span class="profile-info-value" id="userRefCodeVal">{{ session('user.affiliate_id', 'SK-558') }}</span>
                                <button type="button" class="profile-copy-btn" onclick="copyRefCode('{{ session('user.affiliate_id', 'SK-558') }}', this)" title="Copy Referral Code">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Package Row -->
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <span>Package</span>
                            </div>
                            <span class="profile-info-value">{{ session('user.active_package', 'Finance Pro Package') }}</span>
                        </div>

                        <!-- Kyc Status Row -->
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                </svg>
                                <span>Kyc Status</span>
                            </div>
                            <span class="profile-info-value profile-status-approved">approved</span>
                        </div>

                        <!-- Sponsor Row -->
                        <div class="profile-info-row">
                            <div class="profile-info-label">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span>Sponsor</span>
                            </div>
                            <span class="profile-info-value profile-sponsor-text">{{ session('user.sponsor_name', session('user.sponsor_id', 'RISHABH')) }}</span>
                        </div>

                        <!-- Dual Metric Boxes -->
                        <div class="profile-stats-grid">
                            <div class="profile-stat-box">
                                <div class="profile-stat-number">{{ number_format(session('user.wallet_balance', 180)) }}</div>
                                <div class="profile-stat-label">Wallet Balance</div>
                            </div>
                            <div class="profile-stat-box">
                                <div class="profile-stat-number">{{ number_format(session('user.pending_withdrawal', 0)) }}</div>
                                <div class="profile-stat-label">Pending Withdrawal</div>
                            </div>
                        </div>

                        <!-- Dual Action Buttons -->
                        <div class="profile-actions-grid">
                            <a href="{{ url('/my-payout') }}" class="profile-btn-withdraw">
                                WITHDRAW AMOUNT
                            </a>
                            <a href="{{ url('/my-payout') }}" class="profile-btn-payout">
                                PAYOUT HISTORY
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ==========================================
                     2. RIGHT TABS CONTAINER (Exact to Screenshot)
                     ========================================== -->
                <div class="profile-tabs-card">
                    <!-- Tab Navigation Header -->
                    <div class="profile-tab-header">
                        <button type="button" class="profile-tab-btn active" id="tab-btn-profileDetails" onclick="switchProfileTab('profileDetails')">
                            Profile Details
                        </button>
                        <button type="button" class="profile-tab-btn" id="tab-btn-kycDetails" onclick="switchProfileTab('kycDetails')">
                            Kyc Details
                        </button>
                        <button type="button" class="profile-tab-btn" id="tab-btn-changePassword" onclick="switchProfileTab('changePassword')">
                            Change Password
                        </button>
                    </div>

                    <!-- Tab 1: Profile Details Pane -->
                    <div class="profile-tab-pane active" id="pane-profileDetails">
                        <form action="{{ route('portal.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form" onsubmit="handleProfileSubmit(event)">
                            @csrf

                            <!-- Profile Picture Upload -->
                            <div class="profile-form-group">
                                <label class="profile-form-label">Profile Picture</label>
                                <div class="profile-file-box">
                                    <button type="button" class="profile-file-btn" onclick="document.getElementById('profilePicInput').click()">
                                        Choose File
                                    </button>
                                    <span class="profile-file-name" id="profileFileName">No file chosen</span>
                                    <input type="file" id="profilePicInput" name="avatar" accept="image/*" style="display: none;" onchange="handleProfilePicChange(this)">
                                </div>
                                <div class="profile-file-hint">
                                    Upload profile in size (1:1) for proper fit.
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="profile-form-group">
                                <label class="profile-form-label">Name</label>
                                <input type="text" name="name" class="profile-input" value="{{ session('user.name', 'Addy') }}" required>
                            </div>

                            <!-- Phone -->
                            <div class="profile-form-group">
                                <label class="profile-form-label">Phone</label>
                                <input type="text" name="phone" class="profile-input" value="{{ session('user.phone', '8318373108') }}">
                            </div>

                            <!-- Email ID -->
                            <div class="profile-form-group">
                                <label class="profile-form-label">Email ID</label>
                                <input type="email" class="profile-input profile-input-readonly" value="{{ session('user.email', 'adarah242@gmail.com') }}" readonly>
                            </div>

                            <!-- Instagram Username -->
                            <div class="profile-form-group">
                                <label class="profile-form-label">Instagram Username</label>
                                <input type="text" name="instagram" class="profile-input" placeholder="Please enter only username" value="{{ session('user.instagram', '') }}">
                            </div>

                            <!-- Submit Button -->
                            <div class="profile-form-action">
                                <button type="submit" class="profile-save-btn">
                                    SAVE CHANGES
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: Kyc Details Pane -->
                    <div class="profile-tab-pane" id="pane-kycDetails" style="display: none;">
                        <div class="profile-kyc-pane-content">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                                <div>
                                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Bank &amp; KYC Verification</h4>
                                    <p style="font-size: 0.88rem; color: #64748b; margin: 4px 0 0;">Your linked payout bank account details for direct withdrawals.</p>
                                </div>
                                <span style="background: #dcfce7; color: #059669; padding: 5px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 800; border: 1px solid #bbf7d0;">
                                    ● KYC Approved ✅
                                </span>
                            </div>

                            <div class="profile-kyc-grid">
                                <div class="profile-kyc-item">
                                    <span class="kyc-field-title">Bank Name</span>
                                    <div class="kyc-field-val">HDFC Bank</div>
                                </div>
                                <div class="profile-kyc-item">
                                    <span class="kyc-field-title">Account Holder Name</span>
                                    <div class="kyc-field-val">{{ session('user.name', 'Addy') }}</div>
                                </div>
                                <div class="profile-kyc-item">
                                    <span class="kyc-field-title">Account Number</span>
                                    <div class="kyc-field-val">50100494320380</div>
                                </div>
                                <div class="profile-kyc-item">
                                    <span class="kyc-field-title">IFSC Code</span>
                                    <div class="kyc-field-val">HDFC0000194</div>
                                </div>
                                <div class="profile-kyc-item" style="grid-column: 1 / -1;">
                                    <span class="kyc-field-title">UPI ID</span>
                                    <div class="kyc-field-val">adarshpandey3851-3@okhdfcbank</div>
                                </div>
                            </div>

                            <div style="margin-top: 1.8rem;">
                                <a href="{{ url('/kyc') }}" class="profile-save-btn" style="display: inline-block; text-decoration: none;">
                                    UPDATE BANK DETAILS
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Change Password Pane -->
                    <div class="profile-tab-pane" id="pane-changePassword" style="display: none;">
                        <form action="{{ route('portal.profile.password') }}" method="POST" class="profile-form">
                            @csrf
                            <div class="profile-form-group">
                                <label class="profile-form-label">Current Password</label>
                                <input type="password" name="current_password" class="profile-input" placeholder="Enter current account password" required>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label">New Password</label>
                                <input type="password" name="password" class="profile-input" placeholder="Enter minimum 6 characters" required>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="profile-input" placeholder="Re-enter new password" required>
                            </div>

                            <div class="profile-form-action">
                                <button type="submit" class="profile-save-btn">
                                    UPDATE PASSWORD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    /* ==========================================================
       PROFILE PAGE STYLES (MATCHES SCREENSHOT & PROJECT THEME)
       ========================================================== */
    .profile-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        font-size: 0.92rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    .profile-alert.success {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }
    .profile-alert.error {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .profile-layout-grid {
        display: grid;
        grid-template-columns: 320px minmax(0, 1fr);
        gap: 1.8rem;
        align-items: start;
        width: 100%;
        box-sizing: border-box;
    }

    /* 1. Left Overview Card */
    .profile-overview-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .profile-header-dark {
        background: linear-gradient(180deg, #090e29 0%, #00137a 100%);
        padding: 2.2rem 1.5rem 1.8rem;
        text-align: center;
        position: relative;
    }

    .profile-avatar-wrapper {
        position: relative;
        width: 112px;
        height: 112px;
        margin: 0 auto;
    }

    .profile-avatar-img {
        width: 112px;
        height: 112px;
        border-radius: 50%;
        border: 4px solid #ffffff;
        object-fit: cover;
        display: block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }

    .profile-verified-badge {
        position: absolute;
        right: 4px;
        bottom: 4px;
        width: 22px;
        height: 22px;
        background: #10b981;
        border: 2.5px solid #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .profile-user-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff;
        margin: 12px 0 0 0;
        letter-spacing: -0.2px;
    }

    .profile-user-email {
        font-size: 0.88rem;
        color: #94a3b8;
        margin: 4px 0 0 0;
        word-break: break-all;
    }

    .profile-overview-body {
        padding: 1.4rem 1.4rem 1.6rem;
    }

    .profile-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.92rem;
    }

    .profile-info-row:last-of-type {
        border-bottom: none;
    }

    .profile-info-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-weight: 600;
    }

    .profile-info-val-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-info-value {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.92rem;
    }

    .profile-status-approved {
        color: #05B396;
        font-weight: 800;
    }

    .profile-sponsor-text {
        color: #0f172a;
        font-weight: 800;
        text-transform: uppercase;
    }

    .profile-copy-btn {
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .profile-copy-btn:hover {
        color: #05B396;
        background: #f0fdfa;
    }

    /* Metric Dual Boxes */
    .profile-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 1.4rem;
        margin-bottom: 1.2rem;
    }

    .profile-stat-box {
        border: 1.5px dashed #cbd5e1;
        border-radius: 12px;
        padding: 12px 6px;
        text-align: center;
        background: #ffffff;
    }

    .profile-stat-number {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .profile-stat-label {
        font-size: 0.76rem;
        font-weight: 600;
        color: #64748b;
        margin-top: 5px;
    }

    /* Action Buttons */
    .profile-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .profile-btn-withdraw {
        background: #05B396;
        color: #ffffff;
        padding: 0.8rem 0.4rem;
        border-radius: 8px;
        font-size: 0.74rem;
        font-weight: 800;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        box-shadow: 0 4px 12px rgba(5, 179, 150, 0.25);
    }
    .profile-btn-withdraw:hover {
        background: #04947c;
        transform: translateY(-1px);
        color: #ffffff;
    }

    .profile-btn-payout {
        background: #00137a;
        color: #ffffff;
        padding: 0.8rem 0.4rem;
        border-radius: 8px;
        font-size: 0.74rem;
        font-weight: 800;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 19, 122, 0.2);
    }
    .profile-btn-payout:hover {
        background: #000e5c;
        transform: translateY(-1px);
        color: #ffffff;
    }

    /* 2. Right Tabs Card */
    .profile-tabs-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .profile-tab-header {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .profile-tab-btn {
        background: transparent;
        color: #475569;
        border: none;
        border-bottom: 3px solid transparent;
        font-size: 0.95rem;
        font-weight: 600;
        padding: 1.15rem 2.2rem;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
        outline: none;
    }
    .profile-tab-btn:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .profile-tab-btn.active {
        color: #05B396;
        border-bottom-color: #05B396;
        font-weight: 700;
        background: #f0fdfa;
    }

    .profile-tab-pane {
        padding: 2.2rem 2.4rem 2.5rem;
    }

    .profile-form-group {
        margin-bottom: 1.4rem;
    }

    .profile-form-label {
        display: block;
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .profile-input {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem 1.15rem;
        font-size: 0.94rem;
        font-weight: 600;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .profile-input:focus {
        border-color: #05B396;
        box-shadow: 0 0 0 3px rgba(5, 179, 150, 0.14);
    }

    .profile-input-readonly {
        background: #eef2f6 !important;
        color: #64748b !important;
        cursor: not-allowed;
        border-color: #e2e8f0;
    }

    /* Custom File Box */
    .profile-file-box {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 7px 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
    }

    .profile-file-btn {
        background: #eef2f6;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .profile-file-btn:hover {
        background: #e2e8f0;
    }

    .profile-file-name {
        color: #64748b;
        font-size: 0.88rem;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .profile-file-hint {
        color: #05B396;
        font-size: 0.82rem;
        font-weight: 600;
        margin-top: 6px;
    }

    .profile-form-action {
        margin-top: 2rem;
    }

    .profile-save-btn {
        background: #05B396;
        color: #ffffff;
        font-size: 0.88rem;
        font-weight: 800;
        padding: 0.85rem 2.4rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3);
    }
    .profile-save-btn:hover {
        background: #04947c;
        box-shadow: 0 6px 18px rgba(5, 179, 150, 0.4);
        transform: translateY(-1px);
    }

    /* KYC Pane Details */
    .profile-kyc-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-top: 1rem;
    }
    .profile-kyc-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem 1rem;
    }
    .kyc-field-title {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .kyc-field-val {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
    }

    /* Responsive Breakpoints */
    @media (max-width: 991px) {
        .profile-layout-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        .profile-tab-pane {
            padding: 1.6rem 1.4rem 2rem;
        }
        .profile-tab-btn {
            padding: 1rem 1.4rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .profile-kyc-grid {
            grid-template-columns: 1fr;
        }
        .profile-tab-pane {
            padding: 1.4rem 1rem 1.8rem;
        }
        .profile-stats-grid {
            gap: 8px;
        }
        .profile-stat-box {
            padding: 10px 4px;
        }
        .profile-stat-number {
            font-size: 1.25rem;
        }
    }
</style>

@push('scripts')
<script>
    function switchProfileTab(tabKey) {
        // Remove active class from buttons
        document.querySelectorAll('.profile-tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        // Hide all panes
        document.querySelectorAll('.profile-tab-pane').forEach(pane => {
            pane.classList.remove('active');
            pane.style.display = 'none';
        });

        // Activate selected button & pane
        const targetBtn = document.getElementById('tab-btn-' + tabKey);
        const targetPane = document.getElementById('pane-' + tabKey);
        if (targetBtn && targetPane) {
            targetBtn.classList.add('active');
            targetPane.classList.add('active');
            targetPane.style.display = 'block';
        }
    }

    function handleProfilePicChange(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const nameEl = document.getElementById('profileFileName');
            if (nameEl) nameEl.innerText = fileName;

            // Live preview avatar image
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('overviewAvatarImg');
                if (img) img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function copyRefCode(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            const originalSvg = btn.innerHTML;
            btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>';
            setTimeout(() => {
                btn.innerHTML = originalSvg;
            }, 1800);
        });
    }

    function handleProfileSubmit(e) {
        // Optional client-side feedback
    }
</script>
@endpush

@include('portal.styles')
@endsection
