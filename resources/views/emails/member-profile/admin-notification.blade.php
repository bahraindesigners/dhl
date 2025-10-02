@component('emails.layouts.base', [
    'title' => 'New Member Profile Submission',
    'subtitle' => 'A new member has joined the union'
])

<!-- Member Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📋 Member Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Full Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $user->name }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="mailto:{{ $user->email }}" style="color: #ffcb00; text-decoration: none;">{{ $user->email }}</a>
            </div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">CPR Number</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->cpr_number }}</div>
        </div>
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Staff Number</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->staff_number }}</div>
        </div>
    </div>
</div>

<!-- Work Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">🏢 Work Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Position</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->position }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Department</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->department }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Section</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->section ?? 'Not specified' }}</div>
        </div>
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Date of Joining</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->date_of_joining?->format('F j, Y') ?? 'Not specified' }}</div>
        </div>
    </div>
</div>

<!-- Contact Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📞 Contact Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Mobile Number</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="tel:{{ $memberProfile->mobile_number }}" style="color: #ffcb00; text-decoration: none;">{{ $memberProfile->mobile_number }}</a>
            </div>
        </div>
        @if($memberProfile->office_phone)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Office Phone</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="tel:{{ $memberProfile->office_phone }}" style="color: #ffcb00; text-decoration: none;">{{ $memberProfile->office_phone }}</a>
            </div>
        </div>
        @endif
        @if($memberProfile->home_phone)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Home Phone</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $memberProfile->home_phone }}</div>
        </div>
        @endif
    </div>
</div>

<!-- Action Button -->
<div style="text-align: center; margin: 30px 0;">
    <a href="{{ config('app.url') . '/admin/member-profiles' }}" style="display: inline-block; background: linear-gradient(135deg, #ffcb00 0%, #ffd700 100%); color: #1a1a1a; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 3px 10px rgba(255, 203, 0, 0.3);">
        View in Admin Panel
    </a>
</div>

<!-- Action Required Notice -->
<div style="background: #fff8e1; padding: 20px; border-radius: 8px; border-left: 4px solid #ffcb00; margin-top: 30px;">
    <p style="margin: 0; color: #92400e; font-weight: 500;">
        <strong>Action Required:</strong> Please review this member profile submission and take appropriate action in the admin panel.
    </p>
</div>

@endcomponent
