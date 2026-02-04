<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>{{ $subject ?? config('app.name') }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style type="text/css">
        body { margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
        a { color: #308ce8; text-decoration: underline; }
    </style>
</head>
<body style="margin: 0; padding: 20px 0; background-color: #f6f7f8; font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5; color: #1e293b;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f6f7f8;">
    <tr>
        <td align="center" style="padding: 20px 10px;">
            <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <!-- Header / Logo -->
                <tr>
                    <td style="padding: 24px 32px; border-bottom: 1px solid #e2e8f0;">
                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>
                                    <img src="{{ asset('images/sotm-logo.png') }}" alt="SOTM" width="120" height="40" style="display: block; height: 40px; width: auto; max-width: 120px;"/>
                                </td>
                                <td align="right" style="font-size: 14px; color: #64748b; font-weight: 500;">{{ $emailType ?? 'Notification' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @yield('content')

                <!-- Footer -->
                <tr>
                    <td style="padding: 32px; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" style="font-size: 13px; color: #94a3b8; line-height: 1.6;">
                                    You received this because you are part of {{ config('app.name') }}.<br/>
                                    © 2026, made with ♥ by SOTM
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-top: 16px; font-size: 12px;">
                                    <a href="{{ url('/') }}" style="color: #308ce8; text-decoration: underline; font-weight: 600;">Notification Settings</a>
                                    <span style="color: #cbd5e1;"> | </span>
                                    <a href="{{ url('/') }}" style="color: #308ce8; text-decoration: underline; font-weight: 600;">Unsubscribe</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
