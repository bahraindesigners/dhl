<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Al Hasala Application</title>
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
        .hasala-details {
            background-color: #f0fdf4;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #059669;
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
        .member-info {
            background-color: #fefce8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #eab308;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: #fbbf24;
            color: #92400e;
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
        .icon {
            font-size: 18px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏦 New Al Hasala Application</h1>
            <p style="margin: 10px 0 0 0; color: #6b7280;">DHL Bahrain Trade Union</p>
        </div>

        <p><strong>Dear Al Hasala Administrator,</strong></p>
        
        <p>A new Al Hasala application has been submitted and requires your review.</p>

        <div class="hasala-details">
            <h3 style="margin-top: 0; color: #047857;">📋 Al Hasala Application Details</h3>
            
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
                <span class="label">Status:</span>
                <span class="value"><span class="status-badge">{{ $alHasala->status->value }}</span></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Applied On:</span>
                <span class="value">{{ $alHasala->created_at->format('M d, Y H:i') }}</span>
            </div>
        </div>

        <div class="member-info">
            <h3 style="margin-top: 0; color: #92400e;">👤 Applicant Information</h3>
            
            <div class="detail-row">
                <span class="label">Name:</span>
                <span class="value">{{ $alHasala->user->name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">{{ $alHasala->user->email }}</span>
            </div>
            
            @if($alHasala->memberProfile)
            <div class="detail-row">
                <span class="label">Staff Number:</span>
                <span class="value">EMP-{{ $alHasala->memberProfile->staff_number }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Position:</span>
                <span class="value">{{ $alHasala->memberProfile->position }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Department:</span>
                <span class="value">{{ $alHasala->memberProfile->department }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Mobile:</span>
                <span class="value">{{ $alHasala->memberProfile->mobile_number }}</span>
            </div>
            
            @if($alHasala->memberProfile->office_phone)
            <div class="detail-row">
                <span class="label">Office Phone:</span>
                <span class="value">{{ $alHasala->memberProfile->office_phone }}</span>
            </div>
            @endif
            @endif
        </div>

        @if($alHasala->note)
        <div style="background-color: #fffbeb; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">📝 Application Note</h3>
            <p style="margin-bottom: 0; white-space: pre-wrap;">{{ $alHasala->note }}</p>
        </div>
        @endif

        <div class="action-section">
            <p><strong>Please review this Al Hasala application and take appropriate action in the admin panel.</strong></p>
            <a href="{{ url('/admin/al-hasalas/' . $alHasala->id) }}" class="btn">
                Review Application →
            </a>
        </div>

        <div class="footer">
            <p>
                This is an automated notification from the DHL Bahrain Trade Union Al Hasala Management System.<br>
                Please do not reply directly to this email.
            </p>
            <p>
                <strong>DHL Bahrain Trade Union</strong><br>
                Al Hasala Department
            </p>
        </div>
    </div>
</body>
</html>