@extends('emails.layout')

@section('content')
    <!-- Congratulations Heading -->
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px 22px; text-align: center; margin-bottom: 24px;">
        <p style="margin: 0 0 6px; color: #166534; font-size: 18px; font-weight: 800; letter-spacing: -0.2px;">
            🎉 Many Many congratulations !!!
        </p>
        <p style="margin: 0; color: #15803d; font-size: 15px; font-weight: 600;">
            You've Received A New Referral
        </p>
    </div>

    <!-- Income Details Box -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 20px 22px;">
                <p style="margin: 0 0 4px; color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    Passive Referral Income
                </p>
                <p style="margin: 0 0 16px; color: #00137a; font-size: 28px; font-weight: 800;">
                    Affiliate Income: <span style="color: #05B396;">{{ number_format((float) $amount, 2) }} INR</span>
                </p>

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top: 1px dashed #cbd5e1; padding-top: 14px;">
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 4px 0;">Referral Type:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 600; padding: 4px 0;">
                            Passive Income (Tier-2)
                        </td>
                    </tr>
                    @if(!empty($buyerName))
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 4px 0;">Referred By / Student:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 600; padding: 4px 0;">
                            {{ $buyerName }}
                        </td>
                    </tr>
                    @endif
                    @if(!empty($packageName))
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 4px 0;">Package:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 600; padding: 4px 0;">
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
        We wish you all the best for your next one
    </p>

    <!-- Call to action button -->
    <div style="text-align: center; margin: 26px 0 10px;">
        <a href="{{ route('portal.dashboard') }}" target="_blank" style="background-color: #05B396; color: #ffffff; padding: 13px 30px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700; display: inline-block; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
            View Your Wallet & Dashboard &rarr;
        </a>
    </div>
@endsection

