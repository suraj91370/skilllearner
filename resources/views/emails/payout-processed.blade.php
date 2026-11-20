@extends('emails.layout')

@section('content')
    <!-- Congratulations Heading -->
    <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1px solid #a7f3d0; border-radius: 12px; padding: 22px 24px; text-align: center; margin-bottom: 24px;">
        <p style="margin: 0 0 6px; color: #047857; font-size: 19px; font-weight: 800; letter-spacing: -0.2px;">
            💸 Payout Credited Successfully!
        </p>
        <p style="margin: 0; color: #059669; font-size: 14px; font-weight: 600;">
            Your affiliate earnings withdrawal has been transferred to your account
        </p>
    </div>

    <!-- Payout Details Box -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 22px 24px;">
                <p style="margin: 0 0 4px; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px;">
                    Total Transferred Amount
                </p>
                <p style="margin: 0 0 18px; color: #00137a; font-size: 30px; font-weight: 800; line-height: 1.1;">
                    <span style="color: #05B396;">₹{{ number_format((float) $amount, 2) }}</span> <span style="font-size: 16px; color: #64748b; font-weight: 600;">INR</span>
                </p>

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top: 1px dashed #cbd5e1; padding-top: 14px;">
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Reference Code:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 700; font-family: monospace; padding: 6px 0;">
                            #{{ $payoutCode }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Transfer Details:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 600; padding: 6px 0;">
                            {{ $paymentMethod }}
                        </td>
                    </tr>
                    @if(!empty($utrNumber))
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">UTR / Transaction ID:</td>
                        <td align="right" style="color: #00137a; font-size: 13px; font-weight: 700; font-family: monospace; padding: 6px 0;">
                            <span style="background: #e0e7ff; color: #3730a3; padding: 2px 8px; border-radius: 4px; display: inline-block;">
                                {{ $utrNumber }}
                            </span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Processed On:</td>
                        <td align="right" style="color: #0f172a; font-size: 13px; font-weight: 600; padding: 6px 0;">
                            {{ $processedAt }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Status:</td>
                        <td align="right" style="color: #059669; font-size: 13px; font-weight: 800; padding: 6px 0;">
                            Transferred &amp; Settled ✅
                        </td>
                    </tr>
                    @if(!empty($remarks))
                    <tr>
                        <td style="color: #64748b; font-size: 13px; padding: 6px 0;">Remarks / Note:</td>
                        <td align="right" style="color: #334155; font-size: 13px; font-style: italic; padding: 6px 0;">
                            {{ $remarks }}
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <!-- Notice -->
    <div style="background-color: #f1f5f9; border-left: 3px solid #05B396; padding: 12px 16px; border-radius: 6px; margin-bottom: 24px;">
        <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
            💡 <strong>Note:</strong> Depending on your bank's IMPS/NEFT/UPI settlement network, the credited balance may take a few moments to reflect in your bank statement.
        </p>
    </div>

    <!-- Encouragement Message -->
    <p style="color: #334155; font-size: 15px; line-height: 1.6; margin: 0 0 24px; font-weight: 500;">
        Keep up the phenomenal work! Continue sharing your affiliate links to unlock even greater milestones and weekly payouts.
    </p>

    <!-- Call to action button -->
    <div style="text-align: center; margin: 26px 0 10px;">
        <a href="{{ route('portal.payout') }}" target="_blank" style="background-color: #05B396; color: #ffffff; padding: 13px 30px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700; display: inline-block; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
            View Payout History &rarr;
        </a>
    </div>
@endsection
