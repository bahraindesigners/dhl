@component('emails.layouts.base', [
    'title' => 'Union Loan Application Update',
    'subtitle' => 'Your union loan application status has been updated'
])

<!-- Greeting -->
<div style="margin-bottom: 20px;">
    <p style="margin: 0; color: #374151; font-size: 16px; line-height: 1.6;">
        <strong>Dear {{ $unionLoan->user->name }},</strong>
    </p>
    <p style="margin: 10px 0 0 0; color: #6b7280; font-size: 15px; line-height: 1.6;">
        Your union loan application status has been updated. Please find the details below:
    </p>
</div>

<!-- Status Update Section -->
<div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 20px; margin-bottom: 30px; text-align: center;">
    <h2 style="color: #0c4a6e; font-size: 20px; font-weight: 600; margin-bottom: 10px;">🔄 Status Update</h2>
    <p style="color: #075985; margin: 10px 0; font-size: 16px;">Your union loan application is now:</p>
    @if($unionLoan->status->value === 'approved')
        <span style="display: inline-block; padding: 8px 20px; border-radius: 20px; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #10b981; color: white;">APPROVED</span>
    @elseif($unionLoan->status->value === 'rejected')
        <span style="display: inline-block; padding: 8px 20px; border-radius: 20px; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #ef4444; color: white;">REJECTED</span>
    @else
        <span style="display: inline-block; padding: 8px 20px; border-radius: 20px; font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #f59e0b; color: white;">{{ strtoupper($unionLoan->status->value) }}</span>
    @endif
</div>

<!-- Loan Application Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">💰 Loan Application Details</h2>
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
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Applied On</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->created_at->format('F j, Y') }}</div>
        </div>
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Last Updated</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $unionLoan->updated_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

@if($unionLoan->status->value === 'approved')
<!-- Approval Message -->
<div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #10b981;">
    <h2 style="color: #047857; font-size: 18px; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">🎉</span> Congratulations!
    </h2>
    <p style="margin: 0; color: #047857; line-height: 1.6;">
        Your union loan application has been <strong>approved</strong>! Please contact the loan department to proceed with the next steps.
    </p>
</div>

@if($unionLoan->approved_amount && $unionLoan->approved_amount != $unionLoan->amount)
<!-- Approved Amount Different -->
<div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #f59e0b;">
    <h2 style="color: #92400e; font-size: 18px; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">💰</span> Approved Amount
    </h2>
    <p style="margin: 0; color: #92400e; line-height: 1.6;">
        <strong>Approved Amount:</strong> BD {{ number_format($unionLoan->approved_amount, 2) }}<br>
        <em>Note: The approved amount may differ from your requested amount based on the loan assessment.</em>
    </p>
</div>
@endif
@endif

@if($unionLoan->status->value === 'rejected' && $unionLoan->rejection_reason)
<!-- Rejection Reason -->
<div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #ef4444;">
    <h2 style="color: #dc2626; font-size: 18px; font-weight: 600; margin-bottom: 15px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">❌</span> Rejection Reason
    </h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; white-space: pre-wrap; line-height: 1.6; font-size: 15px; color: #374151; margin-bottom: 15px;">{{ $unionLoan->rejection_reason }}</div>
    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
        You may submit a new application after addressing the concerns mentioned above.
    </p>
</div>
@endif

@if($unionLoan->status->value === 'pending')
<!-- Pending Review Message -->
<div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #f59e0b;">
    <h2 style="color: #92400e; font-size: 18px; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">⏳</span> Under Review
    </h2>
    <p style="margin: 0; color: #92400e; line-height: 1.6;">
        Your union loan application is currently under review. We will notify you once a decision has been made.
    </p>
</div>
@endif

@if($unionLoan->admin_notes)
<!-- Admin Notes -->
<div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #ffcb00;">
    <h2 style="color: #1a1a1a; font-size: 18px; font-weight: 600; margin-bottom: 15px;">📝 Additional Notes</h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; white-space: pre-wrap; line-height: 1.6; font-size: 15px; color: #374151;">{{ $unionLoan->admin_notes }}</div>
</div>
@endif

<!-- Action Button -->
<div style="text-align: center; margin: 30px 0;">
    <p style="margin-bottom: 15px; color: #374151; font-weight: 500;">View your complete application details in the member portal:</p>
    <a href="{{ url('/union-loans') }}" style="display: inline-block; background: linear-gradient(135deg, #ffcb00 0%, #ffd700 100%); color: #1a1a1a; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 3px 10px rgba(255, 203, 0, 0.3);">
        View My Loan Applications →
    </a>
</div>

<!-- Footer Notice -->
<div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-top: 30px; text-align: center; border-left: 4px solid #ffcb00;">
    <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
        This is an automated notification from the DHL Bahrain Trade Union Loan Management System.<br>
        For questions, please contact the loan department.
    </p>
    <p style="margin: 0; color: #374151; font-size: 14px; font-weight: 600;">
        DHL Bahrain Trade Union<br>
        Loan Department
    </p>
</div>

@endcomponent