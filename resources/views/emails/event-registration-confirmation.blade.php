@component('emails.layouts.base', [
    'title' => 'Registration Confirmed',
    'subtitle' => 'Your event registration has been successfully submitted'
])

<!-- Success Message -->
<div style="text-align: center; margin-bottom: 32px;">
    <div style="width: 64px; height: 64px; background: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <polyline points="20,6 9,17 4,12"></polyline>
        </svg>
    </div>
    <h2 style="color: #111827; font-size: 20px; font-weight: 600; margin: 0 0 8px 0;">Thank you, {{ $registration->first_name }}!</h2>
    <p style="color: #6b7280; font-size: 16px; margin: 0;">You're registered for <strong>{{ $event->title }}</strong></p>
</div>

<!-- Event Information Card -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Event Details</h3>
    
    <div>
        <!-- Event Name -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Event</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $event->title }}</div>
        </div>
        
        <!-- Category -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Category</div>
            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 6px; font-size: 14px; font-weight: 500;">{{ $eventCategory->name }}</span>
        </div>
        
        <!-- Date & Time -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Date & Time</div>
            <div style="color: #111827; font-size: 16px;">{{ $event->start_date->format('l, F j, Y \a\t g:i A') }}</div>
            @if($event->end_date && $event->start_date->format('Y-m-d') !== $event->end_date->format('Y-m-d'))
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">Ends {{ $event->end_date->format('l, F j, Y \a\t g:i A') }}</div>
            @elseif($event->end_date)
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">Until {{ $event->end_date->format('g:i A') }}</div>
            @endif
        </div>
        
        @if($event->location)
        <!-- Location -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Location</div>
            <div style="color: #111827; font-size: 16px;">{{ $event->location }}</div>
            @if($event->location_details)
                <div style="color: #6b7280; font-size: 14px; margin-top: 4px;">{{ $event->location_details['en'] ?? $event->location_details }}</div>
            @endif
        </div>
        @endif
        
        @if($event->price && $event->price > 0)
        <!-- Price -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Price</div>
            <div style="color: #111827; font-size: 16px; font-weight: 600;">${{ number_format($event->price, 2) }}</div>
        </div>
        @endif
    </div>
</div>

@if($event->description)
<!-- Event Description -->
<div style="margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 12px 0;">About This Event</h3>
    <div style="color: #6b7280; font-size: 15px; line-height: 1.6;">{!! $event->description !!}</div>
</div>
@endif

<!-- Registration Summary -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Your Registration</h3>
    
    <div>
        <!-- Name -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Name</div>
            <div style="color: #111827; font-size: 16px;">{{ $registration->first_name }} {{ $registration->last_name }}</div>
        </div>
        
        <!-- Email -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Email</div>
            <div style="color: #111827; font-size: 16px;">{{ $registration->email }}</div>
        </div>
        
        @if($registration->phone)
        <!-- Phone -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Phone</div>
            <div style="color: #111827; font-size: 16px;">{{ $registration->phone }}</div>
        </div>
        @endif
        
        <!-- Registration Date -->
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Registered</div>
            <div style="color: #111827; font-size: 16px;">{{ $registration->registered_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
        
        <!-- Status -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Status</div>
            <div>
                @if($registration->status === 'confirmed')
                    <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">Confirmed</span>
                @elseif($registration->status === 'pending')
                    <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">Pending</span>
                @else
                    <span style="background: #f3f4f6; color: #374151; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">{{ ucfirst($registration->status) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

@if($registration->amount_paid > 0)
<!-- Payment Information -->
<div style="background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Payment Confirmed</h3>
    
    <div>
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Amount Paid</div>
            <div style="color: #059669; font-size: 20px; font-weight: 700;">BD {{ number_format($registration->amount_paid, 2) }}</div>
        </div>
        
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Payment Status</div>
            <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">{{ ucfirst($registration->payment_status) }}</span>
        </div>
        
        @if($registration->payment_method)
        <div style="margin-bottom: 12px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Payment Method</div>
            <div style="color: #111827; font-size: 16px;">{{ ucfirst($registration->payment_method) }}</div>
        </div>
        @endif
        
        @if($registration->payment_reference)
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Reference</div>
            <div style="color: #111827; font-size: 16px; font-family: mono;">{{ $registration->payment_reference }}</div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Next Steps -->
<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">What's Next</h3>
    
    <div style="color: #475569; font-size: 16px; line-height: 1.6;">
        <div style="margin-bottom: 8px;">• Save this confirmation for your records</div>
        <div style="margin-bottom: 8px;">• Add the event to your calendar</div>
        @if($event->location)
        <div style="margin-bottom: 8px;">• Plan your route to {{ $event->location }}</div>
        @endif
        <div style="margin-bottom: 0;">• We'll send updates as the event approaches</div>
    </div>
</div>

@if($registration->status !== 'confirmed')
<!-- Status Notice -->
<div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; margin-bottom: 8px;">
        <div style="width: 20px; height: 20px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px;">
            <span style="color: white; font-size: 12px; font-weight: 600;">!</span>
        </div>
        <h3 style="color: #dc2626; font-size: 16px; font-weight: 600; margin: 0;">Registration Pending</h3>
    </div>
    <p style="margin: 0; color: #991b1b; font-size: 14px; line-height: 1.5;">
        Your registration is currently <strong>{{ $registration->status }}</strong>. We'll send you another email once it's confirmed.
    </p>
</div>
@endif

<!-- Closing -->
<div style="text-align: center; color: #6b7280; font-size: 16px; margin-top: 32px;">
    <p style="margin: 0 0 16px 0;">Questions? Feel free to reach out to our events team.</p>
    <p style="margin: 0; font-weight: 600; color: #111827;">Looking forward to seeing you there!</p>
</div>

@endcomponent
