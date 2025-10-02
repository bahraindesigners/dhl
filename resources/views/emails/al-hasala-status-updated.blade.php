<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al Hasala Application Update</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #059669;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #047857;
            margin: 0;
            font-size: 28px;
        }
        .status-update {
            background-color: #f0fdf4;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #059669;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 10px 0;
        }
        .status-approved {
            background-color: #10b981;
            color: white;
        }
        .status-rejected {
            background-color: #ef4444;
            color: white;
        }
        .status-pending {
            background-color: #f59e0b;
            color: white;
        }
        .hasala-details {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #6b7280;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #374151;
            flex: 1;
        }
        .value {
            flex: 2;
            text-align: right;
            color: #111827;
        }
        .rejection-reason {
            background-color: #fef2f2;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ef4444;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #059669;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #047857;
        }
        .action-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f0fdf4;
            border-radius: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Al Hasala Application Update</h1>
            <p style="margin: 10px 0 0 0; color: #6b7280;">DHL Bahrain Trade Union</p>
        </div>

        <p><strong>Dear {{ $alHasala->user->name }},</strong></p>
        
        <p>Your Al Hasala application status has been updated. Please find the details below:</p>

        <div class="status-update">
            <h3 style="margin-top: 0; color: #047857;">📋 Status Update</h3>
            <p style="font-size: 18px; margin: 10px 0;">Your Al Hasala application is now:</p>
            <span class="status-badge status-{{ $alHasala->status->value }}">{{ ucfirst($alHasala->status->value) }}</span>
        </div>

        <div class="hasala-details">
            <h3 style="margin-top: 0; color: #374151;">📋 Al Hasala Application Details</h3>
            
            <div class="detail-row">
                <span class="label">Application ID:</span>
                <span class="value"><strong>#{{ $alHasala->id }}</strong></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Amount Requested:</span>
                <span class="value"><strong>BHD {{ number_format($alHasala->amount, 2) }}</strong></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Duration:</span>
                <span class="value">{{ $alHasala->months }} months</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Applied On:</span>
                <span class="value">{{ $alHasala->created_at->format('M d, Y') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Last Updated:</span>
                <span class="value">{{ $alHasala->updated_at->format('M d, Y H:i') }}</span>
            </div>
        </div>

        @if($alHasala->status->value === 'approved')
        <div style="background-color: #f0fdf4; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10b981;">
            <h3 style="margin-top: 0; color: #047857;">🎉 Congratulations!</h3>
            <p>Your Al Hasala application has been <strong>approved</strong>! Please contact the Al Hasala department to proceed with the next steps.</p>
        </div>
        @endif

        @if($alHasala->status->value === 'rejected' && $alHasala->rejected_reason)
        <div class="rejection-reason">
            <h3 style="margin-top: 0; color: #dc2626;">❌ Rejection Reason</h3>
            <p style="margin-bottom: 0; white-space: pre-wrap;">{{ $alHasala->rejected_reason }}</p>
            <p style="margin-top: 15px; font-size: 14px; color: #6b7280;">
                You may submit a new application after addressing the concerns mentioned above.
            </p>
        </div>
        @endif

        @if($alHasala->status->value === 'pending')
        <div style="background-color: #fffbeb; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">⏳ Under Review</h3>
            <p>Your Al Hasala application is currently under review. We will notify you once a decision has been made.</p>
        </div>
        @endif

        <div class="action-section">
            <p><strong>View your complete application details in the member portal.</strong></p>
            <a href="{{ url('/al-hasala') }}" class="btn">
                View My Al Hasala Applications →
            </a>
        </div>

        <div class="footer">
            <p>
                This is an automated notification from the DHL Bahrain Trade Union Al Hasala Management System.<br>
                For questions, please contact the Al Hasala department.
            </p>
            <p>
                <strong>DHL Bahrain Trade Union</strong><br>
                Al Hasala Department
            </p>
        </div>
    </div>
</body>
</html>