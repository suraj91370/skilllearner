@extends('layouts.app')

@section('title', 'Login & Register — SkillLearner')

@section('content')
<!-- Page Banner Header -->
<div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 2.8rem 1.5rem; text-align: center;">
    <h1 style="font-size: 2.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem; letter-spacing: -0.5px;">Login &amp; Register</h1>
    <p style="font-size: 0.92rem; color: #64748b; font-weight: 600;">
        <a href="{{ url('/') }}" style="color: #64748b; text-decoration: none; transition: color 0.2s;">Home</a>
        <span style="margin: 0 8px; color: #94a3b8;">&gt;</span>
        <span style="color: #0f172a;">Login &amp; Register</span>
    </p>
</div>

<!-- Main Login Section -->
<section style="background: #ffffff; padding: 4rem 1.5rem; min-height: 560px; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 1080px; width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;" class="login-grid-wrapper">
        
        <!-- Left Column: Vector Illustration (Matching Uploaded Image) -->
        <div style="display: flex; justify-content: center; align-items: center;" class="login-illustration-col">
            <svg viewBox="0 0 520 420" width="100%" height="auto" style="max-width: 480px; display: block;" xmlns="http://www.w3.org/2000/svg">
                <!-- Drop Soft Shadow under Illustration -->
                <ellipse cx="260" cy="385" rx="220" ry="14" fill="#f1f5f9"/>
                
                <!-- Floor Base Line -->
                <line x1="80" y1="385" x2="480" y2="385" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"/>

                <!-- Potted Plant on Right -->
                <g id="plant-group">
                    <!-- Stems & Leaves -->
                    <path d="M 430 385 L 430 350 Q 425 320 410 290 Q 425 315 432 350 Z" fill="#1e293b"/>
                    <path d="M 430 350 Q 450 310 460 270 Q 448 300 435 345 Z" fill="#334155"/>
                    <path d="M 425 340 Q 395 310 380 270 Q 405 295 423 335 Z" fill="#0f172a"/>
                    <!-- Additional decorative leaf blades -->
                    <path d="M 428 330 Q 415 280 430 240 Q 438 275 431 325 Z" fill="#1e293b"/>
                    <path d="M 433 330 Q 455 290 470 250 Q 455 285 436 325 Z" fill="#475569"/>
                    <!-- Blue Geometric Planter Pot -->
                    <polygon points="410,350 450,350 444,385 416,385" fill="#3b82f6"/>
                    <polygon points="405,345 455,345 450,352 410,352" fill="#2563eb"/>
                </g>

                <!-- Stacked Storage Boxes Behind/Under Window -->
                <g id="boxes-group" opacity="0.6">
                    <rect x="330" y="325" width="60" height="60" rx="3" fill="#f8fafc" stroke="#cbd5e1" stroke-width="1.5"/>
                    <line x1="330" y1="345" x2="390" y2="345" stroke="#e2e8f0" stroke-width="1.5"/>
                    <rect x="355" y="295" width="55" height="30" rx="3" fill="#ffffff" stroke="#cbd5e1" stroke-width="1.5"/>
                </g>

                <!-- Browser Login Floating Window -->
                <g id="browser-window-group" transform="translate(190, 80)">
                    <!-- Window Frame -->
                    <rect x="0" y="0" width="220" height="160" rx="8" fill="#ffffff" stroke="#cbd5e1" stroke-width="1.5" filter="drop-shadow(0 10px 20px rgba(0,0,0,0.06))"/>
                    <!-- Window Header with 3 dots -->
                    <line x1="0" y1="26" x2="220" y2="26" stroke="#f1f5f9" stroke-width="1.5"/>
                    <circle cx="15" cy="13" r="3" fill="#94a3b8"/>
                    <circle cx="26" cy="13" r="3" fill="#cbd5e1"/>
                    <circle cx="37" cy="13" r="3" fill="#e2e8f0"/>

                    <!-- Padlock Graphic & Dotted Circles -->
                    <circle cx="110" cy="55" r="24" fill="none" stroke="#e2e8f0" stroke-dasharray="2,3" stroke-width="1.5"/>
                    <!-- Padlock Shackle & Body -->
                    <path d="M 103 52 L 103 45 A 7 7 0 0 1 117 45 L 117 52" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round"/>
                    <rect x="99" y="52" width="22" height="17" rx="3" fill="#3b82f6"/>
                    <circle cx="110" cy="59" r="2" fill="#ffffff"/>
                    <line x1="110" y1="61" x2="110" y2="65" stroke="#ffffff" stroke-width="1.5"/>

                    <!-- Input Mock 1: username@gmail.com -->
                    <rect x="25" y="88" width="170" height="22" rx="4" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1"/>
                    <text x="110" y="103" font-size="8.5" fill="#334155" text-anchor="middle" font-family="'Inter', sans-serif" font-weight="600">username@gmail.com</text>

                    <!-- Input Mock 2: password dots -->
                    <rect x="25" y="118" width="170" height="22" rx="4" fill="#f8fafc" stroke="#e2e8f0" stroke-width="1"/>
                    <text x="110" y="133" font-size="11" fill="#64748b" text-anchor="middle" font-family="'Inter', sans-serif" letter-spacing="2">••••••••</text>
                </g>

                <!-- Woman Sitting on Stool Working on Laptop -->
                <g id="student-group">
                    <!-- Blue Stool / Pouf -->
                    <rect x="100" y="300" width="75" height="85" rx="6" fill="#3b82f6"/>
                    <!-- Stool legs -->
                    <rect x="106" y="380" width="8" height="10" fill="#1e293b"/>
                    <rect x="161" y="380" width="8" height="10" fill="#1e293b"/>

                    <!-- Legs & Feet -->
                    <!-- Left Leg (tucked back) -->
                    <path d="M 125 305 L 145 375 L 170 380 L 155 385 L 138 380 Z" fill="#0f172a"/>
                    <!-- Right Leg (bent in front) -->
                    <path d="M 115 280 Q 105 320 120 360 L 135 365 L 145 385 L 125 388 L 110 360 Z" fill="#1e293b"/>
                    <!-- Modern Shoes -->
                    <path d="M 143 382 L 160 384 L 160 388 L 140 388 Z" fill="#334155"/>
                    <path d="M 122 384 L 140 386 L 140 390 L 120 390 Z" fill="#334155"/>

                    <!-- Torso & Black Shirt -->
                    <path d="M 108 220 Q 115 195 130 195 Q 145 195 152 220 L 158 290 Q 135 305 105 290 Z" fill="#0f172a"/>

                    <!-- Arms & Laptop -->
                    <!-- Arm reaching forward -->
                    <path d="M 130 225 Q 150 250 170 260 L 165 270 Q 145 260 125 240 Z" fill="#fed7aa"/>
                    <!-- Black T-shirt sleeve -->
                    <path d="M 125 215 Q 140 215 145 235 L 130 240 Z" fill="#0f172a"/>

                    <!-- Silver Laptop -->
                    <!-- Laptop Screen -->
                    <polygon points="160,250 195,250 190,290 155,290" fill="#cbd5e1" stroke="#94a3b8" stroke-width="1"/>
                    <circle cx="175" cy="270" r="3" fill="#ffffff" opacity="0.8"/>
                    <!-- Laptop Base -->
                    <polygon points="152,290 198,290 205,295 150,295" fill="#94a3b8"/>

                    <!-- Neck & Head -->
                    <!-- Neck -->
                    <rect x="130" y="175" width="12" height="22" fill="#fed7aa"/>
                    <!-- Face/Head Profile -->
                    <circle cx="136" cy="165" r="16" fill="#fed7aa"/>
                    <!-- Eye & Smile -->
                    <circle cx="143" cy="164" r="1.5" fill="#0f172a"/>
                    <path d="M 140 171 Q 144 174 148 171" fill="none" stroke="#0f172a" stroke-width="1.2" stroke-linecap="round"/>

                    <!-- Black Hair Tied in a High Bun -->
                    <path d="M 122 165 Q 120 148 135 148 Q 152 148 150 162 Q 136 154 122 165 Z" fill="#0f172a"/>
                    <!-- Top Bun -->
                    <circle cx="123" cy="148" r="8" fill="#0f172a"/>
                </g>
            </svg>
        </div>

        <!-- Right Column: Login Card (Matches Layout & Gradient Button in Image) -->
        <div style="display: flex; justify-content: center; width: 100%;">
            <div class="login-card-box" style="background: #ffffff; border-radius: 16px; padding: 2.8rem 2.4rem; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); border: 1px solid #f1f5f9; width: 100%; max-width: 480px;">
                
                @if (session('error'))
                    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('info'))
                    <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Single Unified Login Header -->
                <div style="margin-bottom: 1.8rem;">
                    <h2 style="font-size: 1.7rem; font-weight: 800; color: #0f172a; margin-bottom: 0.35rem;">
                        Log In to SkillLearner
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Welcome back! Enter your credentials to access your portal.
                    </p>
                </div>

                <form method="POST" action="{{ url('/login') }}" id="loginForm">
                    @csrf
                    
                    <!-- Username or Email -->
                    <div style="margin-bottom: 1.2rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Username or email <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="username" id="loginUsernameInput" required class="clean-form-input" placeholder="user@skilllearner.com" value="{{ old('username', 'user@skilllearner.com') }}">
                    </div>

                    <!-- Password with Eye Toggle -->
                    <div style="margin-bottom: 1.2rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Password <span style="color: #ef4444;">*</span>
                        </label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" name="password" id="loginPasswordInput" required class="clean-form-input" placeholder="••••••••" value="password123" style="padding-right: 48px;">
                            <button type="button" onclick="togglePasswordVisibility()" id="eyeToggleBtn" aria-label="Toggle Password Visibility" style="position: absolute; right: 12px; background: none; border: none; cursor: pointer; color: #64748b; padding: 6px; display: flex; align-items: center; justify-content: center; transition: color 0.2s;">
                                <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember me & Forgot Password -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.6rem; font-size: 0.88rem;">
                        <label style="display: flex; align-items: center; gap: 8px; color: #64748b; cursor: pointer; user-select: none; font-weight: 500;">
                            <input type="checkbox" name="remember" checked style="accent-color: #05B396; width: 16px; height: 16px; border-radius: 4px; cursor: pointer;">
                            Remember me
                        </label>
                        <a href="javascript:void(0)" onclick="alert('Password reset instructions will be sent to your registered email.')" style="color: #64748b; text-decoration: none; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
                            Forgot your password ?
                        </a>
                    </div>

                    <!-- Single Standard Login Button -->
                    <button type="submit" id="loginSubmitBtn" class="gradient-login-btn user">
                        Log In &nbsp;➔
                    </button>

                    <!-- Demo 1-Click Credentials Bar -->
                    <div style="margin-top: 1.5rem; padding-top: 1.1rem; border-top: 1px solid #f1f5f9; text-align: center;">
                        <div style="font-size: 0.72rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 0.55rem;">
                            1-Click Test Credentials
                        </div>
                        <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                            <button type="button" onclick="fillDemo('superadmin@skilllearner.com', 'password123')" class="demo-chip-btn super" title="Fill Super Admin Credentials">
                                👑 Super Admin
                            </button>
                            <button type="button" onclick="fillDemo('admin@skilllearner.com', 'password123')" class="demo-chip-btn admin" title="Fill Admin Credentials">
                                🛡️ Admin
                            </button>
                            <button type="button" onclick="fillDemo('user@skilllearner.com', 'password123')" class="demo-chip-btn user" title="Fill Student Credentials">
                                🎓 Student
                            </button>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div style="text-align: center; margin-top: 1.3rem; font-size: 0.92rem; color: #64748b;">
                        Don't have an account yet? 
                        <a href="{{ url('/register') }}" style="color: #05B396; font-weight: 700; text-decoration: none; margin-left: 4px;">
                            Register Now →
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    /* Role Selector Cards */
    .role-selector-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .role-selector-card {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.55rem;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .role-selector-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .role-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2px;
    }

    .role-card-icon {
        font-size: 1rem;
    }

    .role-card-badge {
        font-size: 0.62rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 1px 5px;
        border-radius: 6px;
        letter-spacing: 0.4px;
    }

    .role-card-badge.super {
        background: rgba(124, 58, 237, 0.15);
        color: #7c3aed;
    }

    .role-card-badge.admin {
        background: rgba(2, 132, 199, 0.15);
        color: #0284c7;
    }

    .role-card-badge.user {
        background: rgba(5, 179, 150, 0.15);
        color: #05B396;
    }

    .role-card-title {
        font-size: 0.82rem;
        font-weight: 800;
        color: #0f172a;
    }

    .role-card-sub {
        font-size: 0.68rem;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Active Tab Styles */
    .role-selector-card.super-admin.active {
        background: #faf5ff;
        border-color: #7c3aed;
        box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.25);
    }

    .role-selector-card.admin.active {
        background: #f0f9ff;
        border-color: #0284c7;
        box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.25);
    }

    .role-selector-card.user.active {
        background: #f0fdfa;
        border-color: #05B396;
        box-shadow: 0 0 0 2px rgba(5, 179, 150, 0.25);
    }

    /* Role Callout Banner */
    .role-info-callout {
        margin-top: 0.75rem;
        padding: 0.75rem 0.9rem;
        border-radius: 10px;
        transition: all 0.25s ease;
    }

    .role-info-callout.super {
        background: #faf5ff;
        border: 1px solid rgba(124, 58, 237, 0.3);
        color: #6b21a8;
    }

    .role-info-callout.admin {
        background: #f0f9ff;
        border: 1px solid rgba(2, 132, 199, 0.3);
        color: #0369a1;
    }

    .role-info-callout.user {
        background: #f0fdfa;
        border: 1px solid rgba(5, 179, 150, 0.3);
        color: #065f46;
    }

    /* Clean Inputs */
    .clean-form-input {
        width: 100%;
        padding: 0.85rem 1.1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #0f172a !important;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .clean-form-input:focus {
        background: #ffffff;
        border-color: #05B396;
        box-shadow: 0 0 0 3px rgba(5, 179, 150, 0.15);
    }

    /* Gradient Login Button */
    .gradient-login-btn {
        width: 100%;
        padding: 0.92rem 1.5rem;
        font-size: 1.02rem;
        font-weight: 700;
        color: #ffffff;
        background: linear-gradient(135deg, #05B396 0%, #048873 100%);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gradient-login-btn.super {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        box-shadow: 0 4px 18px rgba(124, 58, 237, 0.35);
    }

    .gradient-login-btn.admin {
        background: linear-gradient(135deg, #0284c7 0%, #075985 100%);
        box-shadow: 0 4px 18px rgba(2, 132, 199, 0.35);
    }

    .gradient-login-btn.user {
        background: linear-gradient(135deg, #05B396 0%, #048873 100%);
        box-shadow: 0 4px 18px rgba(5, 179, 150, 0.35);
    }

    .gradient-login-btn:hover {
        transform: translateY(-2px);
        opacity: 0.96;
    }

    @media (max-width: 860px) {
        .login-grid-wrapper {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
        }
        .login-illustration-col {
            order: 2;
        }
    }

    .demo-chip-btn {
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 5px 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .demo-chip-btn.super {
        background: #f5f3ff;
        color: #7c3aed;
        border-color: #ddd6fe;
    }
    .demo-chip-btn.super:hover {
        background: #ede9fe;
        transform: translateY(-1px);
    }
    .demo-chip-btn.admin {
        background: #f0f9ff;
        color: #0284c7;
        border-color: #bae6fd;
    }
    .demo-chip-btn.admin:hover {
        background: #e0f2fe;
        transform: translateY(-1px);
    }
    .demo-chip-btn.user {
        background: #f0fdfa;
        color: #05B396;
        border-color: #a7f3d0;
    }
    .demo-chip-btn.user:hover {
        background: #ccfbf1;
        transform: translateY(-1px);
    }
</style>
@endpush

@push('scripts')
<script>
    function fillDemo(username, password) {
        document.getElementById('loginUsernameInput').value = username;
        document.getElementById('loginPasswordInput').value = password;
    }

    function selectRole(role) {
        if (role === 'super_admin') fillDemo('superadmin@skilllearner.com', 'password123');
        if (role === 'admin') fillDemo('admin@skilllearner.com', 'password123');
        if (role === 'user') fillDemo('user@skilllearner.com', 'password123');
    }

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('loginPasswordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;
        }
    }
</script>
@endpush
@endsection
