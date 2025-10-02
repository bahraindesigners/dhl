@component('emails.layouts.base', [
    'title' => 'New Loan Application',
    'subtitle' => 'A member has submitted a union loan application'
])

<!-- Alert -->
<div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 20px; margin-bottom: 32px; text-align: center;">
    <div style="width: 48px; height: 48px; background: #2563eb; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
    </div>
    <p style="color: #1d4ed8; font-size: 16px; margin: 0; font-weight: 500;">New union loan application requires review</p>
</div>

<!-- Loan Application Details -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Application Details</h3>
    
    <div>
        <!-- Application ID -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Application ID</div>
            <div style="color: #111827; font-size: 16px; font-weight: 600; font-family: mono;">#{{ $unionLoan->id }}</div>
        </div>
        
        <!-- Amount -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Amount Requested</div>
            <div style="color: #059669; font-size: 20px; font-weight: 700;">BD {{ number_format($unionLoan->amount, 2) }}</div>
        </div>
        
        <!-- Duration -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Duration</div>
            <div style="color: #111827; font-size: 16px;">{{ $unionLoan->months }} months</div>
        </div>
        
        <!-- Status -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Status</div>
            <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">{{ ucfirst($unionLoan->status) }}</span>
        </div>
        
        <!-- Application Date -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Submitted</div>
            <div style="color: #111827; font-size: 16px;">{{ $unionLoan->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>
@if($unionLoan->note)
<!-- Additional Notes -->
<div style="margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 12px 0;">Additional Notes</h3>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-size: 16px; color: #374151;">{{ $unionLoan->note }}</div>
</div>
@endif

<!-- Applicant Information -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Applicant Information</h3>
    
    <div>
        <!-- Name -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Name</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $unionLoan->user->name }}</div>
        </div>
        
        <!-- Email -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Email</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="mailto:{{ $unionLoan->user->email }}" style="color: #3b82f6; text-decoration: none;">{{ $unionLoan->user->email }}</a>
            </div>
        </div>
        
        @if($unionLoan->user->memberProfile)
        <!-- Staff Number -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Staff Number</div>
            <div style="color: #111827; font-size: 16px;">{{ $unionLoan->user->memberProfile->staff_number ?? 'N/A' }}</div>
        </div>
        
        <!-- Department -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Department</div>
            <div style="color: #111827; font-size: 16px;">{{ $unionLoan->user->memberProfile->department ?? 'N/A' }}</div>
        </div>
        
        @if($unionLoan->user->memberProfile->mobile_number)
        <!-- Mobile -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Mobile</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="tel:{{ $unionLoan->user->memberProfile->mobile_number }}" style="color: #3b82f6; text-decoration: none;">{{ $unionLoan->user->memberProfile->mobile_number }}</a>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<!-- Action Button -->
<div style="text-align: center; margin: 32px 0;">
    <a href="{{ url('/admin/union-loans/' . $unionLoan->id) }}" style="display: inline-block; background: #3b82f6; color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 500; font-size: 16px;">
        Review Application
    </a>
</div>

<!-- Action Notice -->
<div style="background: #f0f9ff; border: 1px solid #c7d2fe; border-radius: 12px; padding: 20px; text-align: center;">
    <p style="margin: 0; color: #4338ca; font-size: 14px; line-height: 1.5;">
        <strong>Action Required:</strong> Please review this application in the admin panel
    </p>
</div>

@endcomponent
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