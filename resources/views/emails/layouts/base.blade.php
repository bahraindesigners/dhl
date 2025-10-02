<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $subject ?? 'DHL Bahrain Trade Union' }}</title>
    <style>
        /* Reset */
        body, table, td, p, h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }
        /* Mobile-first responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                margin: 0 !important;
            }
            .content {
                padding: 24px 16px !important;
            }
            .header {
                padding: 24px 16px !important;
            }
            .footer {
                padding: 20px 16px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; line-height: 1.5; color: #111827; background-color: #f9fafb;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; padding: 24px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table class="container" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background: #ffffff; border-radius: 16px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow: hidden; margin: 0 auto; border: 1px solid #e5e7eb;">
                    
                    <!-- Minimal Header -->
                    <tr>
                        <td class="header" style="background: #ffffff; padding: 32px 32px 0; text-align: center; border-bottom: 1px solid #f3f4f6;">
                            <!-- Logo -->
                            <img src="{{ asset('uinuon-logo.jpeg') }}" alt="DHL Bahrain Trade Union" style="max-height: 48px; width: auto; margin-bottom: 16px;">
                            
                            <!-- Title -->
                            @if($title ?? false)
                            <h1 style="color: #111827; font-size: 24px; font-weight: 600; margin: 0 0 8px 0; letter-spacing: -0.025em;">{{ $title }}</h1>
                            @endif
                            
                            <!-- Subtitle -->
                            @if($subtitle ?? false)
                            <p style="color: #6b7280; font-size: 16px; margin: 0 0 24px 0;">{{ $subtitle }}</p>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td class="content" style="padding: 32px;">
                            {{ $slot }}
                        </td>
                    </tr>
                    
                    <!-- Minimal Footer -->
                    <tr>
                        <td class="footer" style="background: #f9fafb; padding: 24px 32px; text-align: center; border-top: 1px solid #f3f4f6;">
                            <div style="color: #6b7280; font-size: 14px; line-height: 1.4;">
                                <div style="font-weight: 500; margin-bottom: 4px;">DHL Bahrain Trade Union</div>
                                <div style="color: #9ca3af; font-size: 13px;">
                                    This is an automated message from our system.
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>