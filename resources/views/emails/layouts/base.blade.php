<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $subject ?? 'DHL Bahrain Trade Union' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden; margin: 0 auto;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ffcb00 0%, #ffd700 100%); padding: 30px; text-align: center;">
                            <!-- Logo -->
                            <img src="{{ asset('uinuon-logo.jpeg') }}" alt="DHL Bahrain Trade Union" style="max-height: 60px; width: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); margin-bottom: 15px;">
                            <!-- Title -->
                            <h1 style="color: #1a1a1a; font-size: 28px; font-weight: 700; margin: 0; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);">{{ $title ?? 'DHL Bahrain Trade Union' }}</h1>
                            <!-- Subtitle -->
                            <p style="color: #2c2c2c; font-size: 16px; font-weight: 500; margin: 8px 0 0 0; opacity: 0.9;">{{ $subtitle ?? 'Communication from your union' }}</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            {{ $slot }}
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 25px 30px; text-align: center;">
                            <img src="{{ asset('uinuon-logo.jpeg') }}" alt="DHL Bahrain Trade Union" style="max-height: 40px; margin-bottom: 15px; opacity: 0.7;">
                            <div style="color: #6b7280; font-size: 14px; line-height: 1.5; margin-bottom: 10px;">
                                <strong>DHL Bahrain Trade Union</strong><br>
                                Serving DHL employees with dedication and integrity
                            </div>
                            <div style="color: #9ca3af; font-size: 12px;">
                                This is an automated message from our system.<br>
                                For support, please contact us through our official channels.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>