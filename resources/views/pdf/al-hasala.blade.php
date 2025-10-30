<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Al Hasala - {{ $user->name }}</title>
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
            border-bottom: 3px solid #7c3aed;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #6d28d9;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #64748b;
        }

        .hasala-badge {
            display: inline-block;
            background-color: #ede9fe;
            color: #5b21b6;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 18px;
            margin: 15px 0;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #6d28d9;
            background-color: #ede9fe;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-left: 4px solid #7c3aed;
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

        .status-approved {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-completed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .amount-highlight {
            font-size: 18px;
            font-weight: bold;
            color: #6d28d9;
        }

        .note-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            line-height: 1.8;
        }

        .rejection-box {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            line-height: 1.8;
            color: #991b1b;
        }

        .calculation-box {
            background-color: #faf5ff;
            border: 2px solid #7c3aed;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9d5ff;
        }

        .calculation-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #7c3aed;
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
        <h1>Al Hasala Application</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
        <div class="hasala-badge">BHD {{ number_format($alHasala->total_amount, 2) }}</div>
    </div>

    <!-- Applicant Information -->
    <div class="section">
        <div class="section-title">Applicant Information</div>
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

    <!-- Al Hasala Details -->
    <div class="section">
        <div class="section-title">Al Hasala Details</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Monthly Amount</div>
                <div class="info-value">
                    <span class="amount-highlight">BHD {{ number_format($alHasala->monthly_amount, 2) }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Number of Months</div>
                <div class="info-value">{{ $alHasala->months }} months</div>
            </div>
            <div class="info-row">
                <div class="info-label">Total Amount</div>
                <div class="info-value">
                    <span class="amount-highlight">BHD {{ number_format($alHasala->total_amount, 2) }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $alHasala->status->value }}">
                        {{ ucfirst($alHasala->status->value) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Application Date</div>
                <div class="info-value">{{ $alHasala->created_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $alHasala->updated_at->format('F d, Y \a\t H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Payment Breakdown -->
    <div class="section">
        <div class="section-title">Payment Breakdown</div>
        <div class="calculation-box">
            <div class="calculation-row">
                <span>Monthly Contribution:</span>
                <span>BHD {{ number_format($alHasala->monthly_amount, 2) }}</span>
            </div>
            <div class="calculation-row">
                <span>Duration:</span>
                <span>{{ $alHasala->months }} months</span>
            </div>
            <div class="calculation-row">
                <span>Total Savings Amount:</span>
                <span class="amount-highlight">BHD {{ number_format($alHasala->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($alHasala->note)
    <div class="section">
        <div class="section-title">Application Notes</div>
        <div class="note-box">
            {{ $alHasala->note }}
        </div>
    </div>
    @endif

    <!-- Rejection Reason -->
    @if($alHasala->rejected_reason)
    <div class="section">
        <div class="section-title">Rejection Reason</div>
        <div class="rejection-box">
            {{ $alHasala->rejected_reason }}
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This is an official Al Hasala document generated by the system.</p>
        <p>Document generated on {{ now()->format('F d, Y \a\t H:i:s') }}</p>
    </div>
</body>

</html>