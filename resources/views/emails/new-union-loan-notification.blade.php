<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Union Loan Application</title>
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
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 28px;
        }
        .loan-details {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
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
        }
        .value {
            color: #1f2937;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: #fef3c7;
            color: #92400e;
        }
        .member-info {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0ea5e9;
        }
        .action-section {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2563eb;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
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
            <h1>🏦 New Union Loan Application</h1>
            <p style="margin: 10px 0 0 0; color: #6b7280;">Application #{{ $unionLoan->id }}</p>
        </div>

        <p>Dear Administrator,</p>
        
        <p>A new union loan application has been submitted and requires your attention for review and processing.</p>

        <div class="loan-details">
            <h3 style="margin-top: 0; color: #1e40af;">💰 Loan Details</h3>
            <div class="detail-row">
                <span class="label">Application ID:</span>
                <span class="value">#{{ $unionLoan->id }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Loan Amount:</span>
                <span class="value">BD {{ number_format($unionLoan->amount, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Duration:</span>
                <span class="value">{{ $unionLoan->months }} months</span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value">
                    <span class="status">{{ $unionLoan->status->label() }}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="label">Application Date:</span>
                <span class="value">{{ $unionLoan->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
        </div>

        <div class="member-info">
            <h3 style="margin-top: 0; color: #0369a1;">👤 Member Information</h3>
            <div class="detail-row">
                <span class="label">Full Name:</span>
                <span class="value">{{ $unionLoan->user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">{{ $unionLoan->user->email }}</span>
            </div>
            @if($unionLoan->memberProfile)
            <div class="detail-row">
                <span class="label">Member Number:</span>
                <span class="value">{{ $unionLoan->memberProfile->member_number }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Staff Number:</span>
                <span class="value">{{ $unionLoan->memberProfile->staff_number }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Position:</span>
                <span class="value">{{ $unionLoan->memberProfile->position }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Department:</span>
                <span class="value">{{ $unionLoan->memberProfile->department }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $unionLoan->memberProfile->phone }}</span>
            </div>
            @endif
        </div>

        @if($unionLoan->note)
        <div style="background-color: #fffbeb; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
            <h3 style="margin-top: 0; color: #92400e;">📝 Application Note</h3>
            <p style="margin-bottom: 0; white-space: pre-wrap;">{{ $unionLoan->note }}</p>
        </div>
        @endif

        <div class="action-section">
            <p><strong>Please review this application and take appropriate action in the admin panel.</strong></p>
            <a href="{{ url('/admin/union-loans/' . $unionLoan->id) }}" class="btn">
                Review Application →
            </a>
        </div>

        <div class="footer">
            <p>This is an automated notification from the DHL Union Loan Management System.</p>
            <p style="margin: 5px 0 0 0;">Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>