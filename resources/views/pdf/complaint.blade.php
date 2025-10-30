<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint - {{ $complaint->ticket_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #991b1b;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #64748b;
        }

        .ticket-badge {
            display: inline-block;
            background-color: #fef3c7;
            color: #92400e;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #991b1b;
            background-color: #fee2e2;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-left: 4px solid #dc2626;
        }

        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #475569;
            padding: 8px 12px;
            width: 35%;
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .info-value {
            display: table-cell;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-in_progress {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-resolved {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-closed {
            background-color: #f1f5f9;
            color: #475569;
        }

        .priority-low {
            background-color: #dcfce7;
            color: #166534;
        }

        .priority-medium {
            background-color: #fef3c7;
            color: #92400e;
        }

        .priority-high,
        .priority-urgent {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .description-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            line-height: 1.8;
        }

        .admin-notes-box {
            background-color: #fef3c7;
            border: 1px solid #fde047;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            line-height: 1.8;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Complaint Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
        <div class="ticket-badge">{{ $complaint->ticket_id }}</div>
    </div>

    <!-- User Information -->
    <div class="section">
        <div class="section-title">Submitted By</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            @if($memberProfile)
            <div class="info-row">
                <div class="info-label">CPR Number</div>
                <div class="info-value">{{ $memberProfile->cpr_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Staff Number</div>
                <div class="info-value">{{ $memberProfile->staff_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nationality</div>
                <div class="info-value">{{ $memberProfile->nationality }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gender</div>
                <div class="info-value">{{ ucfirst($memberProfile->gender) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Marital Status</div>
                <div class="info-value">{{ ucfirst($memberProfile->marital_status) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Mobile Number</div>
                <div class="info-value">{{ $memberProfile->mobile_number }}</div>
            </div>
            @if($memberProfile->home_phone)
            <div class="info-row">
                <div class="info-label">Home Phone</div>
                <div class="info-value">{{ $memberProfile->home_phone }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Permanent Address</div>
                <div class="info-value">{{ $memberProfile->permanent_address }}</div>
            </div>
            @endif
        </div>
    </div>

    @if($memberProfile)
    <!-- Employment Information -->
    <div class="section">
        <div class="section-title">Employment Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Position</div>
                <div class="info-value">{{ $memberProfile->position }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $memberProfile->department }}</div>
            </div>
            @if($memberProfile->section)
            <div class="info-row">
                <div class="info-label">Section</div>
                <div class="info-value">{{ $memberProfile->section }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Date of Joining</div>
                <div class="info-value">{{ $memberProfile->date_of_joining?->format('F d, Y') ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Working Place Address</div>
                <div class="info-value">{{ $memberProfile->working_place_address }}</div>
            </div>
            @if($memberProfile->office_phone)
            <div class="info-row">
                <div class="info-label">Office Phone</div>
                <div class="info-value">{{ $memberProfile->office_phone }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Education Qualification</div>
                <div class="info-value">{{ $memberProfile->education_qualification }}</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Complaint Details -->
    <div class="section">
        <div class="section-title">Complaint Details</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Subject</div>
                <div class="info-value">{{ $complaint->subject }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $complaint->status }}">
                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Priority</div>
                <div class="info-value">
                    <span class="status-badge priority-{{ $complaint->priority }}">
                        {{ ucfirst($complaint->priority) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Submitted On</div>
                <div class="info-value">{{ $complaint->created_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            @if($complaint->resolved_at)
            <div class="info-row">
                <div class="info-label">Resolved On</div>
                <div class="info-value">{{ $complaint->resolved_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $complaint->updated_at->format('F d, Y \a\t H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="section">
        <div class="section-title">Complaint Description</div>
        <div class="description-box">
            {{ $complaint->description }}
        </div>
    </div>

    <!-- Admin Notes -->
    @if($complaint->admin_notes)
    <div class="section">
        <div class="section-title">Administrative Notes</div>
        <div class="admin-notes-box">
            {{ $complaint->admin_notes }}
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This is an official complaint document generated by the system.</p>
        <p>Document generated on {{ now()->format('F d, Y \a\t H:i:s') }}</p>
    </div>
</body>

</html>