@extends('emails.layout')

@section('content')
    <!-- Attention Heading -->
    <div style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border: 1px solid #fed7aa; border-radius: 12px; padding: 18px 22px; text-align: center; margin-bottom: 24px;">
        <p style="margin: 0 0 4px; color: #9a3412; font-size: 17px; font-weight: 800; letter-spacing: -0.2px;">
            🔒 Password Reset Request
        </p>
        <p style="margin: 0; color: #c2410c; font-size: 14px; font-weight: 500;">
            Follow the instructions below to reset your password
        </p>
    </div>

    <!-- Body text -->
    <p style="color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 24px;">
        We received a request to reset the password for your <strong>Skilllearner</strong> account. Click the button below to choose a new secure password:
    </p>

    <!-- Reset Password CTA Button -->
    <div style="text-align: center; margin: 28px 0;">
        <a href="{{ $resetUrl }}" target="_blank" style="background-color: #05B396; color: #ffffff; padding: 14px 36px; border-radius: 8px; text-decoration: none; font-size: 15px; font-weight: 700; display: inline-block; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
            Reset Password &rarr;
        </a>
    </div>

    <!-- Security Expiration Note -->
    <div style="background-color: #f1f5f9; border-left: 4px solid #05B396; padding: 14px 16px; border-radius: 6px; margin: 24px 0;">
        <p style="margin: 0; color: #334155; font-size: 13px; line-height: 1.5;">
            ⏱️ <strong>Note:</strong> This password reset link will expire in <strong>60 minutes</strong>.
        </p>
    </div>

    <p style="color: #64748b; font-size: 13px; line-height: 1.5; margin: 0 0 20px;">
        If you did not request a password reset, you can safely ignore this email. Your account remains completely secure.
    </p>

    <div style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px 14px; margin-top: 20px;">
        <p style="color: #94a3b8; font-size: 11px; line-height: 1.5; margin: 0; word-break: break-all;">
            If the button doesn't work, copy and paste this link in your browser:<br>
            <a href="{{ $resetUrl }}" style="color: #05B396; text-decoration: underline;">{{ $resetUrl }}</a>
        </p>
    </div>
@endsection

