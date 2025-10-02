@component('emails.layouts.base', [
    'title' => 'New Union Loan Application',
    'subtitle' => 'A member has submitted a union loan application'
])

<!-- Union Loan Application Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">💰 Union Loan Application Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Application ID</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">#{{ $unionLoan->id }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Loan Type</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->loan_type }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Amount Requested</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 700; color: #059669; font-size: 18px; line-height: 1.5;">
                BD {{ number_format($unionLoan->amount, 2) }}
            </div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Duration</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->duration_months }} months</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Purpose</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->purpose }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Status</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #fef3c7; color: #92400e;">{{ $unionLoan->status->label() }}</span>
            </div>
        </div>
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Application Date</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

@if($unionLoan->documents_provided)
<!-- Documents Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📄 Documents Provided</h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-family: Georgia, serif; font-size: 15px; color: #374151;">{{ $unionLoan->documents_provided }}</div>
</div>
@endif

@if($unionLoan->notes)
<!-- Application Notes Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📝 Application Notes</h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-family: Georgia, serif; font-size: 15px; color: #374151;">{{ $unionLoan->notes }}</div>
</div>
@endif

<!-- Applicant Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">👤 Applicant Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->user->name }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Email</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="mailto:{{ $unionLoan->user->email }}" style="color: #ffcb00; text-decoration: none;">{{ $unionLoan->user->email }}</a>
            </div>
        </div>
        @if($unionLoan->memberProfile)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Staff Number</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->memberProfile->staff_number ?? 'N/A' }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Department</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->memberProfile->department ?? 'N/A' }}</div>
        </div>
        @if($unionLoan->memberProfile->mobile_number)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Mobile</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="tel:{{ $unionLoan->memberProfile->mobile_number }}" style="color: #ffcb00; text-decoration: none;">{{ $unionLoan->memberProfile->mobile_number }}</a>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

@if($unionLoan->guarantor_name)
<!-- Guarantor Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">🤝 Guarantor Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Guarantor Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->guarantor_name }}</div>
        </div>
        @if($unionLoan->guarantor_staff_number)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Guarantor Staff Number</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->guarantor_staff_number }}</div>
        </div>
        @endif
        @if($unionLoan->guarantor_relationship)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Relationship</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->guarantor_relationship }}</div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Action Button -->
<div style="text-align: center; margin: 30px 0;">
    <a href="{{ url('/admin/union-loans/' . $unionLoan->id) }}" style="display: inline-block; background: linear-gradient(135deg, #ffcb00 0%, #ffd700 100%); color: #1a1a1a; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 3px 10px rgba(255, 203, 0, 0.3);">
        Review Application
    </a>
</div>

<!-- Action Required Notice -->
<div style="background: #fff8e1; padding: 20px; border-radius: 8px; border-left: 4px solid #ffcb00; margin-top: 30px;">
    <p style="margin: 0; color: #92400e; font-weight: 500;">
        <strong>Action Required:</strong> Please review this union loan application and take appropriate action in the admin panel.
    </p>
</div>

@endcomponent
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