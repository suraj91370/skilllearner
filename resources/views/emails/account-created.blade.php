@extends('emails.layout')

@section('content')
    <!-- Congratulations Heading -->
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px 22px; text-align: center; margin-bottom: 24px;">
        <p style="margin: 0 0 6px; color: #166534; font-size: 18px; font-weight: 800; letter-spacing: -0.2px;">
            🎉 Many Many congratulations !!!
        </p>
        <p style="margin: 0; color: #15803d; font-size: 15px; font-weight: 600;">
            Your Skilllearner Account is Created Successfully!
        </p>
    </div>

    <!-- Intro Text -->
    <p style="color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 20px;">
        Welcome to the <strong>Skilllearner</strong> family! We are thrilled to have you onboard. Your student portal access has been provisioned and your course tracks are ready.
    </p>

    <!-- Account Details Box -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 20px 22px;">
                <p style="margin: 0 0 14px; color: #00137a; font-size: 15px; font-weight: 700;">
                    📋 Your Account & Enrollment Details
                </p>

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top: 1px solid #e2e8f0; padding-top: 12px;">
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Student Name:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 700; padding: 6px 0;">
                            {{ $userName }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Login Email:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 700; padding: 6px 0;">
                            {{ $email }}
                        </td>
                    </tr>
                    @if(!empty($affiliateId))
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Affiliate ID:</td>
                        <td align="right" style="color: #05B396; font-size: 13px; font-weight: 800; padding: 6px 0;">
                            {{ $affiliateId }}
                        </td>
                    </tr>
                    @endif
                    @if(!empty($packageName))
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Enrolled Package:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 700; padding: 6px 0;">
                            {{ $packageName }}
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <!-- Encouragement Message -->
    <p style="color: #334155; font-size: 15px; line-height: 1.6; margin: 0 0 24px; font-weight: 500;">
        We wish you all the best for your learning and growth journey with us!
    </p>

    <!-- Call to action button -->
    <div style="text-align: center; margin: 26px 0 10px;">
        <a href="{{ url('/login') }}" target="_blank" style="background-color: #05B396; color: #ffffff; padding: 14px 34px; border-radius: 8px; text-decoration: none; font-size: 15px; font-weight: 700; display: inline-block; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
            Login to Student Portal &rarr;
        </a>
    </div>
@endsection

