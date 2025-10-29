@if($isAdminNotification)
<html>

<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #f8f9fa; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
        <h1 style="color: #dc3545; margin: 0 0 10px 0; font-size: 24px;">🚨 New Complaint Submitted</h1>
        <p style="color: #6c757d; margin: 0;">A member has submitted a complaint that requires attention.</p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 20px;">
        <h2 style="color: #495057; margin: 0 0 15px 0; font-size: 18px;">⚠️ Complaint Information</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Ticket ID:</td>
                <td style="padding: 8px 0;">#{{ $complaint->ticket_id }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Subject:</td>
                <td style="padding: 8px 0;">{{ $complaint->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Priority:</td>
                <td style="padding: 8px 0;">{{ ucfirst($complaint->priority) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Status:</td>
                <td style="padding: 8px 0;">{{ ucfirst($complaint->status) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Submitted:</td>
                <td style="padding: 8px 0;">{{ $complaint->created_at->format('F j, Y \a\t g:i A') }}</td>
            </tr>
        </table>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 20px;">
        <h2 style="color: #495057; margin: 0 0 15px 0; font-size: 18px;">👤 Complainant Information</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Name:</td>
                <td style="padding: 8px 0;">{{ $complaint->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Email:</td>
                <td style="padding: 8px 0;"><a href="mailto:{{ $complaint->user->email }}" style="color: #007bff;">{{ $complaint->user->email ?? 'N/A' }}</a></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Member ID:</td>
                <td style="padding: 8px 0;">{{ $complaint->member_profile->staff_number ?? ($complaint->user->memberProfile->staff_number ?? 'N/A') }}</td>
            </tr>
        </table>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 20px;">
        <h2 style="color: #495057; margin: 0 0 15px 0; font-size: 18px;">📝 Complaint Description</h2>
        <p style="margin: 0; line-height: 1.6;">{{ $complaint->description }}</p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/admin/complaints/' . $complaint->id) }}" style="background: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">View in Admin Panel</a>
    </div>

    <div style="background: #fff3cd; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;">
        <p style="margin: 0; color: #856404; font-weight: 500;">
            <strong>Action Required:</strong> This complaint requires your attention. Please review and respond promptly to maintain member satisfaction.
        </p>
    </div>

    <div style="text-align: center; margin-top: 30px; color: #6c757d; font-size: 14px;">
        <p>Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>

@else
<html>

<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #d4edda; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
        <h1 style="color: #155724; margin: 0 0 10px 0; font-size: 24px;">✅ Complaint Submitted Successfully</h1>
        <p style="color: #155724; margin: 0;">Thank you for your submission. We have received your complaint and will review it shortly.</p>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 20px;">
        <h2 style="color: #495057; margin: 0 0 15px 0; font-size: 18px;">📋 Your Complaint Details</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Ticket ID:</td>
                <td style="padding: 8px 0;">#{{ $complaint->ticket_id }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Subject:</td>
                <td style="padding: 8px 0;">{{ $complaint->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Priority:</td>
                <td style="padding: 8px 0;">{{ ucfirst($complaint->priority) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Status:</td>
                <td style="padding: 8px 0;">{{ ucfirst($complaint->status) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: bold;">Submitted:</td>
                <td style="padding: 8px 0;">{{ $complaint->created_at->format('F j, Y \a\t g:i A') }}</td>
            </tr>
        </table>
    </div>

    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 20px;">
        <h2 style="color: #495057; margin: 0 0 15px 0; font-size: 18px;">📝 Your Description</h2>
        <p style="margin: 0; line-height: 1.6;">{{ $complaint->description }}</p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/complaints/' . $complaint->id) }}" style="background: #28a745; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">Track Your Complaint</a>
    </div>

    <div style="background: #d1ecf1; padding: 20px; border-radius: 8px; border-left: 4px solid #17a2b8;">
        <p style="margin: 0; color: #0c5460; font-weight: 500;">
            <strong>Next Steps:</strong> Our team will review your complaint and respond within 2-3 business days. You can track the progress using your ticket ID: <strong>#{{ $complaint->ticket_id }}</strong>
        </p>
    </div>

    <div style="text-align: center; margin-top: 30px; color: #6c757d; font-size: 14px;">
        <p>Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>
@endif