@component('emails.layouts.base', [
    'title' => 'New Al Hasala Application',
    'subtitle' => 'A member has submitted an Al Hasala application'
])

<!-- Al Hasala Application Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">💰 Al Hasala Application Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Application ID</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">#{{ $alHasala->id }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Amount Requested</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 700; color: #059669; font-size: 18px; line-height: 1.5;">
                BD {{ number_format($alHasala->amount, 2) }}
            </div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Duration</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $alHasala->months }} months</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Status</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #fef3c7; color: #92400e;">{{ $alHasala->status->label() }}</span>
            </div>
        </div>
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Application Date</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $alHasala->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

@if($alHasala->note)
<!-- Application Note Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📝 Application Note</h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-family: Georgia, serif; font-size: 15px; color: #374151;">{{ $alHasala->note }}</div>
</div>
@endif

<!-- Applicant Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">👤 Applicant Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $alHasala->user->name }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Email</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="mailto:{{ $alHasala->user->email }}" style="color: #ffcb00; text-decoration: none;">{{ $alHasala->user->email }}</a>
            </div>
        </div>
        @if($alHasala->memberProfile)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Staff Number</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $alHasala->memberProfile->staff_number ?? 'N/A' }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Department</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $alHasala->memberProfile->department ?? 'N/A' }}</div>
        </div>
        @if($alHasala->memberProfile->mobile_number)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Mobile</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="tel:{{ $alHasala->memberProfile->mobile_number }}" style="color: #ffcb00; text-decoration: none;">{{ $alHasala->memberProfile->mobile_number }}</a>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<!-- Action Button -->
<div style="text-align: center; margin: 30px 0;">
    <a href="{{ url('/admin/al-hasalas/' . $alHasala->id) }}" style="display: inline-block; background: linear-gradient(135deg, #ffcb00 0%, #ffd700 100%); color: #1a1a1a; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 3px 10px rgba(255, 203, 0, 0.3);">
        Review Application
    </a>
</div>

<!-- Action Required Notice -->
<div style="background: #fff8e1; padding: 20px; border-radius: 8px; border-left: 4px solid #ffcb00; margin-top: 30px;">
    <p style="margin: 0; color: #92400e; font-weight: 500;">
        <strong>Action Required:</strong> Please review this Al Hasala application and take appropriate action in the admin panel.
    </p>
</div>

@endcomponent
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