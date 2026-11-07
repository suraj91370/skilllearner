@extends('layouts.app')

@section('title', 'Forgot Password — SkillLearner')

@section('content')
<!-- Page Banner Header -->
<div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 2.5rem 1.5rem; text-align: center;">
    <h1 style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.4rem; letter-spacing: -0.5px;">Forgot Password</h1>
    <p style="font-size: 0.92rem; color: #64748b; font-weight: 600;">
        <a href="{{ url('/') }}" style="color: #64748b; text-decoration: none; transition: color 0.2s;">Home</a>
        <span style="margin: 0 8px; color: #94a3b8;">&gt;</span>
        <span style="color: #0f172a;">Forgot Password</span>
    </p>
</div>

<!-- Main Section Matching Uploaded Design -->
<section style="background: #ffffff; padding: 4.5rem 1.5rem; min-height: 580px; display: flex; align-items: center; justify-content: center;">
    <div class="forgot-grid-container" style="max-width: 1040px; width: 100%; display: grid; grid-template-columns: 1.1fr 1fr; gap: 4rem; align-items: center;">
        
        <!-- Left Column: Illustration -->
        <div class="forgot-illustration-col" style="display: flex; justify-content: center; align-items: center;">
            <img src="{{ asset('images/forgot-password-illustration.png') }}" alt="Forgot Password Illustration" style="width: 100%; max-width: 480px; height: auto; object-fit: contain; display: block;">
        </div>

        <!-- Right Column: Form -->
        <div style="display: flex; justify-content: center; width: 100%;">
            <div style="width: 100%; max-width: 440px;">
                
                @if (session('status'))
                    <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 1rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; line-height: 1.5;">
                        <div style="font-weight: 700; margin-bottom: 2px;">Check your email</div>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/forgot-password') }}" onsubmit="handleForgotSubmit(event)" id="forgotPasswordForm">
                    @csrf
                    
                    <div style="margin-bottom: 1.4rem;">
                        <label for="resetEmail" style="display: block; font-size: 0.95rem; font-weight: 600; color: #334155; margin-bottom: 0.55rem;">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="resetEmail" 
                            required 
                            placeholder="Enter your registered email" 
                            value="{{ old('email', '') }}"
                            style="width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; color: #0f172a; background: #ffffff; outline: none; box-sizing: border-box; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#05B396'; this.style.boxShadow='0 0 0 3px rgba(5, 179, 150, 0.15)';"
                            onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';"
                        >
                    </div>

                    <button 
                        type="submit" 
                        id="resetSubmitBtn"
                        style="width: 100%; padding: 0.85rem 1.5rem; background: #05B396; border: none; border-radius: 8px; font-size: 1rem; font-weight: 700; color: #ffffff; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='#049e84'; this.style.transform='translateY(-1px)';"
                        onmouseout="this.style.background='#05B396'; this.style.transform='none';"
                    >
                        <span>Send Reset Link</span>
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

                <div id="clientResetSuccess" style="display: none; background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 1.2rem; border-radius: 8px; margin-top: 1.2rem; font-size: 0.92rem; line-height: 1.5;">
                    <div style="font-weight: 800; font-size: 1rem; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#05B396" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Reset Link Sent!</span>
                    </div>
                    <div>A password reset link has been dispatched to <strong id="sentEmailDisplay"></strong>. Please check your inbox and spam folder.</div>
                </div>

            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    @media (max-width: 860px) {
        .forgot-grid-container {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
            padding: 1rem 0;
        }
        .forgot-illustration-col img {
            max-width: 340px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function handleForgotSubmit(e) {
        const emailInput = document.getElementById('resetEmail');
        if (emailInput && emailInput.value) {
            const form = document.getElementById('forgotPasswordForm');
            // If running without backend POST handler (e.g. static export)
            if (window.location.protocol === 'file:' || !navigator.onLine) {
                e.preventDefault();
                document.getElementById('sentEmailDisplay').textContent = emailInput.value;
                document.getElementById('clientResetSuccess').style.display = 'block';
                form.style.display = 'none';
            } else {
                const btn = document.getElementById('resetSubmitBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span>Sending Email...</span>';
                    btn.style.opacity = '0.75';
                    btn.style.cursor = 'wait';
                }
            }
        }
    }
</script>
@endpush
@endsection

