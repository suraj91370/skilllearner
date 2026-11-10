<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $subject ?? 'Skilllearner' }}</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, Helvetica, sans-serif !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6fb; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">

    <!-- Outer Table -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6fb; margin: 0; padding: 30px 12px;">
        <tr>
            <td align="center">
                <!-- Inner Container (Max 560px) -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 560px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 24px rgba(15, 23, 42, 0.07); border: 1px solid #e2e8f0;">
                    
                    <!-- Top Accent Bar -->
                    <tr>
                        <td style="background: linear-gradient(90deg, #00137a 0%, #05B396 100%); height: 5px; font-size: 0; line-height: 0;">&nbsp;</td>
                    </tr>

                    <!-- Logo Header -->
                    <tr>
                        <td align="center" style="padding: 28px 24px 22px; background-color: #ffffff; border-bottom: 1px solid #f1f5f9;">
                            <a href="{{ config('app.url', 'https://skilllearner.org') }}" target="_blank" style="text-decoration: none; display: inline-block;">
                                @php
                                    $logoSrc = asset('images/logo.png');
                                    if (isset($message) && method_exists($message, 'embedData') && file_exists(public_path('images/logo.png'))) {
                                        try {
                                            $logoData = @file_get_contents(public_path('images/logo.png'));
                                            if ($logoData) {
                                                $logoSrc = $message->embedData($logoData, 'logo.png', 'image/png');
                                            }
                                        } catch (\Throwable $e) {
                                            $logoSrc = asset('images/logo.png');
                                        }
                                    }
                                @endphp
                                <img src="{{ $logoSrc }}" 
                                     alt="Skilllearner" 
                                     width="190" 
                                     style="width: 190px; max-width: 190px; height: auto; display: block; margin: 0 auto; border: 0;" />
                            </a>
                        </td>
                    </tr>

                    <!-- Main Content Body -->
                    <tr>
                        <td style="padding: 32px 30px 28px; background-color: #ffffff;">
                            
                            <!-- Salutation -->
                            <h2 style="color: #0f172a; font-size: 20px; font-weight: 700; margin: 0 0 10px; line-height: 1.3;">
                                Hey, {{ $userName ?? 'Learner' }}
                            </h2>

                            <!-- Greeting -->
                            <p style="color: #475569; font-size: 15px; margin: 0 0 24px; line-height: 1.5;">
                                We Hope you are doing well today:)
                            </p>

                            <!-- Dynamic Yield Body -->
                            @yield('content')

                            <!-- Best Regards Sign-off -->
                            <div style="margin-top: 32px; padding-top: 22px; border-top: 1px solid #eef2f6;">
                                <p style="margin: 0 0 4px; color: #64748b; font-size: 14px; line-height: 1.5;">
                                    Best Regards,
                                </p>
                                <p style="margin: 0; color: #00137a; font-size: 15px; font-weight: 700; line-height: 1.5;">
                                    Team Skilllearner
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 22px 28px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 6px; color: #64748b; font-size: 13px; font-weight: 600;">
                                Skilllearner — Learn Skills &bull; Grow Career &bull; Earn
                            </p>
                            <p style="margin: 0 0 10px; color: #94a3b8; font-size: 12px; line-height: 1.5;">
                                Need help? Email us at <a href="mailto:info@skilllearner.org" style="color: #05B396; text-decoration: none; font-weight: 600;">info@skilllearner.org</a>
                            </p>
                            <p style="margin: 0; color: #cbd5e1; font-size: 11px;">
                                &copy; {{ date('Y') }} Skilllearner. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
