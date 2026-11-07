@extends('layouts.app')

@section('title', 'Reset Password — SkillLearner')

@section('content')
<!-- Page Banner Header -->
<div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 2.5rem 1.5rem; text-align: center;">
    <h1 style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem; letter-spacing: -0.5px;">Reset Password</h1>
    <p style="font-size: 0.92rem; color: #64748b; font-weight: 600;">
        <a href="{{ url('/') }}" style="color: #64748b; text-decoration: none; transition: color 0.2s;">Home</a>
        <span style="margin: 0 8px; color: #94a3b8;">&gt;</span>
        <span style="color: #0f172a;">Reset Password</span>
    </p>
</div>

<!-- Main Section -->
<section style="background: #ffffff; padding: 4.5rem 1.5rem; min-height: 580px; display: flex; align-items: center; justify-content: center;">
    <div class="reset-grid-container" style="max-width: 1040px; width: 100%; display: grid; grid-template-columns: 1.1fr 1fr; gap: 4rem; align-items: center;">
        
        <!-- Left Column: Vector Illustration -->
        <div class="reset-illustration-col" style="display: flex; justify-content: center; align-items: center;">
            <svg viewBox="0 0 460 380" width="100%" height="auto" style="max-width: 440px; display: block;" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="shieldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#00137a"/>
                        <stop offset="100%" stop-color="#05B396"/>
                    </linearGradient>
                    <linearGradient id="keyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#f59e0b"/>
                        <stop offset="100%" stop-color="#fbbf24"/>
                    </linearGradient>
                </defs>
                
                <!-- Floor shadow -->
                <ellipse cx="230" cy="340" rx="180" ry="14" fill="#f1f5f9"/>

                <!-- Shield Container -->
                <path d="M 230 60 C 310 60 350 90 350 160 C 350 250 280 300 230 320 C 180 300 110 250 110 160 C 110 90 150 60 230 60 Z" fill="url(#shieldGrad)" opacity="0.95"/>
                
                <!-- Shield Inner Accent -->
                <path d="M 230 75 C 298 75 334 100 334 162 C 334 238 274 284 230 302 C 186 284 126 238 126 162 C 126 100 162 75 230 75 Z" fill="#ffffff" opacity="0.1"/>

                <!-- Padlock Body Inside Shield -->
                <rect x="180" y="165" width="100" height="85" rx="14" fill="#ffffff"/>
                <!-- Shackle -->
                <path d="M 195 165 L 195 130 C 195 105 265 105 265 130 L 265 165" fill="none" stroke="#ffffff" stroke-width="12" stroke-linecap="round"/>
                <!-- Keyhole -->
                <circle cx="230" cy="200" r="8" fill="#00137a"/>
                <polygon points="226,200 234,200 232,225 228,225" fill="#00137a"/>

                <!-- Check Badge -->
                <circle cx="330" cy="230" r="28" fill="#05B396"/>
                <polyline points="318,230 326,238 342,222" fill="none" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>

                <!-- Sparkles -->
                <circle cx="100" cy="110" r="4" fill="#05B396"/>
                <circle cx="370" cy="90" r="6" fill="#fbbf24"/>
                <circle cx="90" cy="250" r="5" fill="#3b82f6"/>
            </svg>
        </div>

        <!-- Right Column: Reset Password Card -->
        <div style="display: flex; justify-content: center; width: 100%;">
            <div style="width: 100%; max-width: 440px;">
                
                <div style="margin-bottom: 1.8rem;">
                    <h2 style="font-size: 1.65rem; font-weight: 800; color: #0f172a; margin-bottom: 0.35rem;">
                        Create New Password
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Choose a strong, secure password for your SkillLearner account.
                    </p>
                </div>

                @if ($errors->any())
                    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/reset-password') }}" id="resetPasswordForm">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Address -->
                    <div style="margin-bottom: 1.3rem;">
                        <label for="resetEmail" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="resetEmail" 
                            required 
                            placeholder="your-email@example.com" 
                            value="{{ old('email', $email) }}"
                            style="width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; color: #0f172a; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#05B396'; this.style.boxShadow='0 0 0 3px rgba(5, 179, 150, 0.15)';"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';"
                        >
                    </div>

                    <!-- New Password -->
                    <div style="margin-bottom: 1.3rem; position: relative;">
                        <label for="newPassword" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            New Password
                        </label>
                        <div style="position: relative;">
                            <input 
                                type="password" 
                                name="password" 
                                id="newPassword" 
                                required 
                                placeholder="Enter at least 6 characters" 
                                style="width: 100%; padding: 0.85rem 3rem 0.85rem 1.1rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; color: #0f172a; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#05B396'; this.style.boxShadow='0 0 0 3px rgba(5, 179, 150, 0.15)';"
                                onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';"
                            >
                            <button type="button" onclick="togglePasswordVisibility('newPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div style="margin-bottom: 1.6rem; position: relative;">
                        <label for="confirmPassword" style="display: block; font-size: 0.92rem; font-weight: 600; color: #334155; margin-bottom: 0.45rem;">
                            Confirm New Password
                        </label>
                        <div style="position: relative;">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="confirmPassword" 
                                required 
                                placeholder="Re-enter your new password" 
                                style="width: 100%; padding: 0.85rem 3rem 0.85rem 1.1rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; color: #0f172a; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#05B396'; this.style.boxShadow='0 0 0 3px rgba(5, 179, 150, 0.15)';"
                                onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';"
                            >
                            <button type="button" onclick="togglePasswordVisibility('confirmPassword', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        id="resetPasswordBtn"
                        style="width: 100%; padding: 0.85rem 1.5rem; background: #05B396; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; color: #ffffff; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='#049e84'; this.style.transform='translateY(-1px)';"
                        onmouseout="this.style.background='#05B396'; this.style.transform='none';"
                    >
                        <span>Update Password</span>
                    </button>

                    <div style="text-align: center; margin-top: 1.6rem;">
                        <a href="{{ url('/login') }}" style="color: #64748b; font-size: 0.9rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            <span>Back to Login</span>
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    @media (max-width: 860px) {
        .reset-grid-container {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
            padding: 1rem 0;
        }
        .reset-illustration-col svg {
            max-width: 300px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;
        } else {
            input.type = 'password';
            btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
        }
    }
</script>
@endpush
@endsection

