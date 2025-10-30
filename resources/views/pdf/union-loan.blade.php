<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Union Loan - {{ $user->name }}</title>
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
            border-bottom: 3px solid #16a34a;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #15803d;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #64748b;
        }

        .loan-badge {
            display: inline-block;
            background-color: #dcfce7;
            color: #166534;
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
            color: #15803d;
            background-color: #dcfce7;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-left: 4px solid #16a34a;
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
            color: #15803d;
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
            background-color: #eff6ff;
            border: 2px solid #3b82f6;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #bfdbfe;
        }

        .calculation-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #3b82f6;
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
        <h1>Union Loan Application</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
        <div class="loan-badge">BHD {{ number_format($unionLoan->amount, 2) }}</div>
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

    <!-- Loan Details -->
    <div class="section">
        <div class="section-title">Loan Details</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Loan Amount</div>
                <div class="info-value">
                    <span class="amount-highlight">BHD {{ number_format($unionLoan->amount, 2) }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Repayment Period</div>
                <div class="info-value">{{ $unionLoan->months }} months</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $unionLoan->status->value }}">
                        {{ ucfirst($unionLoan->status->value) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Application Date</div>
                <div class="info-value">{{ $unionLoan->created_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $unionLoan->updated_at->format('F d, Y \a\t H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Repayment Calculation -->
    <div class="section">
        <div class="section-title">Repayment Calculation</div>
        <div class="calculation-box">
            <div class="calculation-row">
                <span>Total Loan Amount:</span>
                <span>BHD {{ number_format($unionLoan->amount, 2) }}</span>
            </div>
            <div class="calculation-row">
                <span>Number of Months:</span>
                <span>{{ $unionLoan->months }} months</span>
            </div>
            <div class="calculation-row">
                <span>Monthly Installment:</span>
                <span class="amount-highlight">BHD {{ number_format($unionLoan->amount / $unionLoan->months, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($unionLoan->note)
    <div class="section">
        <div class="section-title">Application Notes</div>
        <div class="note-box">
            {{ $unionLoan->note }}
        </div>
    </div>
    @endif

    <!-- Rejection Reason -->
    @if($unionLoan->rejected_reason)
    <div class="section">
        <div class="section-title">Rejection Reason</div>
        <div class="rejection-box">
            {{ $unionLoan->rejected_reason }}
        </div>
    </div>
    @endif

    <div class="footer">
        <p>This is an official union loan document generated by the system.</p>
        <p>Document generated on {{ now()->format('F d, Y \a\t H:i:s') }}</p>
    </div>
</body>

</html>