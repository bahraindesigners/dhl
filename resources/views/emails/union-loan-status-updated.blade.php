<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Application Status Update</title>
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
        .status-update {
            text-align: center;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
        }
        .status-approved {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        .status-rejected {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        .status-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        .status-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }
        .status-text {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
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
        .rejection-reason {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ef4444;
        }
        .rejection-reason h3 {
            color: #dc2626;
            margin-top: 0;
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
        .next-steps {
            background-color: #eff6ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏦 Loan Application Update</h1>
            <p style="margin: 10px 0 0 0; color: #6b7280;">Application #{{ $unionLoan->id }}</p>
        </div>

        <p>Dear {{ $unionLoan->user->name }},</p>

        <p>We have an update regarding your union loan application. Please see the details below:</p>

        <div class="status-update status-{{ strtolower($unionLoan->status->value) }}">
            @if($unionLoan->status->value === 'approved')
                <span class="status-icon">🎉</span>
                <p class="status-text">Congratulations! Your loan has been APPROVED</p>
            @elseif($unionLoan->status->value === 'rejected')
                <span class="status-icon">❌</span>
                <p class="status-text">Your loan application has been REJECTED</p>
            @else
                <span class="status-icon">⏳</span>
                <p class="status-text">Your loan application is PENDING review</p>
            @endif
        </div>

        <div class="loan-details">
            <h3 style="margin-top: 0; color: #1e40af;">💰 Application Details</h3>
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
                <span class="label">Current Status:</span>
                <span class="value">{{ $unionLoan->status->label() }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Application Date:</span>
                <span class="value">{{ $unionLoan->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Last Updated:</span>
                <span class="value">{{ $unionLoan->updated_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
        </div>

        @if($unionLoan->status->value === 'rejected' && $unionLoan->rejected_reason)
        <div class="rejection-reason">
            <h3>📋 Rejection Reason</h3>
            <p style="margin-bottom: 0; white-space: pre-wrap;">{{ $unionLoan->rejected_reason }}</p>
        </div>
        @endif

        @if($unionLoan->status->value === 'approved')
        <div class="next-steps">
            <h3 style="margin-top: 0; color: #1e40af;">🎯 Next Steps</h3>
            <ul style="margin-bottom: 0; padding-left: 20px;">
                <li>You will be contacted by our finance team within 1-2 business days</li>
                <li>Please keep your identification documents ready</li>
                <li>The loan amount will be processed according to our standard procedures</li>
                <li>You will receive loan agreement documents for signature</li>
            </ul>
        </div>
        @elseif($unionLoan->status->value === 'rejected')
        <div class="next-steps">
            <h3 style="margin-top: 0; color: #dc2626;">💡 What You Can Do</h3>
            <ul style="margin-bottom: 0; padding-left: 20px;">
                <li>Review the rejection reason provided above</li>
                <li>Address any issues mentioned in the rejection reason</li>
                <li>You may submit a new application after resolving the mentioned concerns</li>
                <li>Contact our support team if you need clarification</li>
            </ul>
        </div>
        @else
        <div class="next-steps">
            <h3 style="margin-top: 0; color: #d97706;">⏰ What Happens Next</h3>
            <ul style="margin-bottom: 0; padding-left: 20px;">
                <li>Your application is currently under review by our team</li>
                <li>We will evaluate your eligibility and loan requirements</li>
                <li>You will be notified of the decision within 3-5 business days</li>
                <li>No action is required from your side at this time</li>
            </ul>
        </div>
        @endif

        <div class="action-section">
            <p><strong>You can view your complete application details by clicking the button below:</strong></p>
            <a href="{{ url('/loans/' . $unionLoan->id) }}" class="btn">
                View Application Details →
            </a>
        </div>

        <div class="footer">
            <p>If you have any questions about your loan application, please don't hesitate to contact us.</p>
            <p style="margin: 5px 0 0 0;">This is an automated notification from the DHL Union Loan Management System.</p>
        </div>
    </div>
</body>
</html>