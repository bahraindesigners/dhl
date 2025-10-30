@component('emails.layouts.base', [
'title' => 'New Al Hasala Application',
'subtitle' => 'A member has submitted an Al Hasala savings plan application'
])

<!-- Alert -->
<div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px; margin-bottom: 32px; text-align: center;">
    <div style="width: 48px; height: 48px; background: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
    </div>
    <p style="color: #047857; font-size: 16px; margin: 0; font-weight: 500;">New Al Hasala savings plan application requires review</p>
</div>

<!-- Application Details -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Savings Plan Details</h3>

    <div>
        <!-- Application ID -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Application ID</div>
            <div style="color: #111827; font-size: 16px; font-weight: 600; font-family: mono;">#{{ $alHasala->id }}</div>
        </div>

        <!-- Monthly Amount -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Monthly Savings</div>
            <div style="color: #059669; font-size: 20px; font-weight: 700;">BD {{ number_format($alHasala->monthly_amount, 2) }}</div>
        </div>

        <!-- Duration -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Duration</div>
            <div style="color: #111827; font-size: 16px;">{{ $alHasala->months }} months</div>
        </div>

        <!-- Total Amount -->
        <div style="margin-bottom: 16px; background: #f0fdf4; padding: 16px; border-radius: 8px; border: 1px solid #bbf7d0;">
            <div style="color: #047857; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Total Amount at End</div>
            <div style="color: #047857; font-size: 24px; font-weight: 700;">BD {{ number_format($alHasala->total_amount, 2) }}</div>
        </div>

        <!-- Status -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Status</div>
            <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">{{ $alHasala->status->label() }}</span>
        </div>

        <!-- Application Date -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Submitted</div>
            <div style="color: #111827; font-size: 16px;">{{ $alHasala->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

@if($alHasala->note)
<!-- Additional Notes -->
<div style="margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 12px 0;">Additional Notes</h3>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-size: 16px; color: #374151;">{{ $alHasala->note }}</div>
</div>
@endif

<!-- Applicant Information -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Applicant Information</h3>

    <div>
        <!-- Name -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Name</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $alHasala->user->name }}</div>
        </div>

        <!-- Email -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Email</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="mailto:{{ $alHasala->user->email }}" style="color: #3b82f6; text-decoration: none;">{{ $alHasala->user->email }}</a>
            </div>
        </div>

        @if($alHasala->user->memberProfile)
        <!-- Staff Number -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Staff Number</div>
            <div style="color: #111827; font-size: 16px;">{{ $alHasala->user->memberProfile->staff_number ?? 'N/A' }}</div>
        </div>

        <!-- Department -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Department</div>
            <div style="color: #111827; font-size: 16px;">{{ $alHasala->user->memberProfile->department ?? 'N/A' }}</div>
        </div>

        @if($alHasala->user->memberProfile->mobile_number)
        <!-- Mobile -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Mobile</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="tel:{{ $alHasala->user->memberProfile->mobile_number }}" style="color: #3b82f6; text-decoration: none;">{{ $alHasala->user->memberProfile->mobile_number }}</a>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<!-- Action Button -->
<div style="text-align: center; margin: 32px 0;">
    <a href="{{ url('/admin/al-hasalas/' . $alHasala->id) }}" style="display: inline-block; background: #10b981; color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 500; font-size: 16px;">
        Review Application
    </a>
</div>

<!-- Action Notice -->
<div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px; text-align: center;">
    <p style="margin: 0; color: #047857; font-size: 14px; line-height: 1.5;">
        <strong>Action Required:</strong> Please review this application in the admin panel
    </p>
</div>

@endcomponent