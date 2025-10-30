<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Profile - {{ $user->name }}</title>
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
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #64748b;
        }

        .profile-image {
            text-align: center;
            margin: 20px 0;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #2563eb;
            object-fit: cover;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            background-color: #eff6ff;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-left: 4px solid #2563eb;
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
            width: 40%;
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

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .signature-section {
            margin-top: 30px;
            text-align: center;
        }

        .signature-section img {
            max-width: 200px;
            max-height: 100px;
            border: 1px solid #e2e8f0;
            padding: 5px;
        }

        .signature-label {
            margin-top: 10px;
            font-size: 11px;
            color: #64748b;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Member Profile</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    @if($memberProfile->hasMedia('employee_image'))
    <div class="profile-image">
        <img src="{{ $memberProfile->getFirstMediaPath('employee_image') }}" alt="Employee Photo">
    </div>
    @endif

    <!-- User Information -->
    <div class="section">
        <div class="section-title">User Account Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Account Created</div>
                <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="section">
        <div class="section-title">Personal Information</div>
        <div class="info-grid">
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
        </div>
    </div>

    <!-- Employment Information -->
    <div class="section">
        <div class="section-title">Employment Information</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Date of Joining</div>
                <div class="info-value">{{ $memberProfile->date_of_joining?->format('F d, Y') ?? 'N/A' }}</div>
            </div>
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

    <!-- Contact Information -->
    <div class="section">
        <div class="section-title">Contact Information</div>
        <div class="info-grid">
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
        </div>
    </div>

    <!-- Profile Status -->
    <div class="section">
        <div class="section-title">Profile Status</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge {{ $memberProfile->profile_status ? 'status-active' : 'status-inactive' }}">
                        {{ $memberProfile->profile_status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Profile Created</div>
                <div class="info-value">{{ $memberProfile->created_at->format('F d, Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $memberProfile->updated_at->format('F d, Y H:i') }}</div>
            </div>
        </div>
    </div>

    @if($memberProfile->hasMedia('signature'))
    <div class="signature-section">
        <div class="signature-label">Digital Signature</div>
        <img src="{{ $memberProfile->getFirstMediaPath('signature') }}" alt="Signature">
    </div>
    @endif

    <div class="footer">
        <p>This is an official member profile document generated by the system.</p>
        <p>Document generated on {{ now()->format('F d, Y \a\t H:i:s') }}</p>
    </div>
</body>

</html>