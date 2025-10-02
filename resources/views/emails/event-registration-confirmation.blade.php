@component('emails.layouts.base', [
    'title' => 'Event Registration Confirmed',
    'subtitle' => 'Your registration has been successfully submitted'
])

<!-- Confirmation Message -->
<div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 20px; margin-bottom: 30px; text-align: center;">
    <div style="font-size: 48px; margin-bottom: 10px;">🎉</div>
    <h2 style="color: #0c4a6e; font-size: 22px; font-weight: 600; margin-bottom: 8px;">Registration Confirmed!</h2>
    <p style="color: #075985; margin: 0; font-size: 16px;">
        Hello {{ $registration->first_name }} {{ $registration->last_name }},<br>
        Thank you for registering for <strong>{{ $event->title }}</strong>! We're excited to have you join us.
    </p>
</div>

<!-- Event Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📅 Event Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Event Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $event->title }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Category</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $eventCategory->name }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Start Date & Time</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $event->start_date->format('F j, Y \a\t g:i A') }}</div>
        </div>
        @if($event->end_date)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">End Date & Time</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $event->end_date->format('F j, Y \a\t g:i A') }}</div>
        </div>
        @endif
        @if($event->location && $event->description)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Location</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $event->location }}</div>
        </div>
        @elseif($event->location)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Location</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $event->location }}</div>
        </div>
        @endif
    </div>
</div>

@if($event->description)
<!-- Event Description Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📋 Event Description</h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-family: Georgia, serif; font-size: 15px; color: #374151;">{{ $event->description }}</div>
</div>
@endif

<!-- Registration Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">👤 Your Registration Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $registration->first_name }} {{ $registration->last_name }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Email</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="mailto:{{ $registration->email }}" style="color: #ffcb00; text-decoration: none;">{{ $registration->email }}</a>
            </div>
        </div>
        @if($registration->phone)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Phone</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="tel:{{ $registration->phone }}" style="color: #ffcb00; text-decoration: none;">{{ $registration->phone }}</a>
            </div>
        </div>
        @endif
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Registration Date</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $registration->registered_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
        @if($registration->special_requirements)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Status</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                @if($registration->status === 'confirmed')
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #bbf7d0; color: #047857;">{{ ucfirst($registration->status) }}</span>
                @elseif($registration->status === 'pending')
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #fef3c7; color: #92400e;">{{ ucfirst($registration->status) }}</span>
                @else
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #f3f4f6; color: #374151;">{{ ucfirst($registration->status) }}</span>
                @endif
            </div>
        </div>
        @else
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Status</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                @if($registration->status === 'confirmed')
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #bbf7d0; color: #047857;">{{ ucfirst($registration->status) }}</span>
                @elseif($registration->status === 'pending')
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #fef3c7; color: #92400e;">{{ ucfirst($registration->status) }}</span>
                @else
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #f3f4f6; color: #374151;">{{ ucfirst($registration->status) }}</span>
                @endif
            </div>
        </div>
        @endif
        @if($registration->special_requirements)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Special Requirements</div>
            <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; white-space: pre-wrap; line-height: 1.6; font-size: 15px; color: #374151;">{{ $registration->special_requirements }}</div>
        </div>
        @endif
    </div>
</div>

@if($registration->amount_paid > 0)
<!-- Payment Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">💰 Payment Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Amount Paid</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 700; color: #059669; font-size: 18px; line-height: 1.5;">
                BD {{ number_format($registration->amount_paid, 2) }}
            </div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Status</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                @if($registration->payment_status === 'paid')
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #bbf7d0; color: #047857;">{{ ucfirst($registration->payment_status) }}</span>
                @else
                    <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; background: #fef3c7; color: #92400e;">{{ ucfirst($registration->payment_status) }}</span>
                @endif
            </div>
        </div>
        @if($registration->payment_method)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Method</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ ucfirst($registration->payment_method) }}</div>
        </div>
        @endif
        @if($registration->payment_reference)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Reference</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $registration->payment_reference }}</div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- What's Next Section -->
<div style="background: #fffbeb; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
    <h2 style="color: #ea580c; font-size: 18px; font-weight: 600; margin-bottom: 15px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">📝</span> What's Next?
    </h2>
    <div style="color: #9a3412; line-height: 1.6;">
        <div style="margin-bottom: 10px; padding-left: 20px; position: relative;">
            <span style="position: absolute; left: 0; color: #ffcb00; font-weight: 600;">•</span>
            Save this confirmation email for your records
        </div>
        <div style="margin-bottom: 10px; padding-left: 20px; position: relative;">
            <span style="position: absolute; left: 0; color: #ffcb00; font-weight: 600;">•</span>
            Mark your calendar for {{ $event->start_date->format('F j, Y') }}
        </div>
        @if($event->location)
        <div style="margin-bottom: 10px; padding-left: 20px; position: relative;">
            <span style="position: absolute; left: 0; color: #ffcb00; font-weight: 600;">•</span>
            Plan your route to {{ $event->location }}
        </div>
        @endif
        <div style="margin-bottom: 0; padding-left: 20px; position: relative;">
            <span style="position: absolute; left: 0; color: #ffcb00; font-weight: 600;">•</span>
            We'll send you any additional event updates as the date approaches
        </div>
    </div>
</div>

@if($registration->status !== 'confirmed')
<!-- Status Notice -->
<div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #ef4444;">
    <h2 style="color: #dc2626; font-size: 18px; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center;">
        <span style="margin-right: 8px;">⚠️</span> Please Note
    </h2>
    <p style="margin: 0; color: #dc2626; line-height: 1.6;">
        Your registration is currently <strong>{{ $registration->status }}</strong>. You'll receive another email once it's confirmed.
    </p>
</div>
@endif

<!-- Contact Information -->
<div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #ffcb00; text-align: center;">
    <p style="margin: 0; color: #374151; line-height: 1.6;">
        If you have any questions or need to make changes to your registration, please contact us.<br><br>
        <strong>We look forward to seeing you at the event!</strong>
    </p>
</div>

<!-- Footer Notice -->
<div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-top: 30px; text-align: center; border-left: 4px solid #ffcb00;">
    <p style="margin: 0; color: #374151; font-size: 14px; font-weight: 600;">
        Best regards,<br>
        {{ config('app.name') }} Events Team
    </p>
</div>

@endcomponent
