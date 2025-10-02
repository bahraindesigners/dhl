@component('emails.layouts.base', [
    'title' => 'New Event Registration',
    'subtitle' => 'A new event registration has been submitted'
])

<!-- Alert -->
<div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 12px; padding: 20px; margin-bottom: 32px; text-align: center;">
    <div style="width: 48px; height: 48px; background: #3b82f6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="m22 21-3-3m0 0a5.5 5.5 0 1 0-7.78-7.78 5.5 5.5 0 0 0 7.78 7.78Z"></path>
        </svg>
    </div>
    <p style="color: #1e40af; font-size: 16px; margin: 0; font-weight: 500;">New event registration received</p>
</div>

<!-- Event Information -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Event Information</h3>
    
    <div>
        <!-- Event Name -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Event</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $event->title }}</div>
        </div>
        
        <!-- Category -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Category</div>
            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 6px; font-size: 14px; font-weight: 500;">{{ $eventCategory->name }}</span>
        </div>
        
        <!-- Date & Time -->
        <div style="margin-bottom: 16px;">
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
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Location</div>
            <div style="color: #111827; font-size: 16px;">{{ $event->location }}</div>
        </div>
        @endif
    </div>
</div>

<!-- Registration Details -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Registration Details</h3>
    
    <div>
        <!-- Registration ID -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Registration ID</div>
            <div style="color: #111827; font-size: 16px; font-weight: 600; font-family: mono;">#{{ $registration->id }}</div>
        </div>
        
        <!-- Participant Name -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Participant</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $registration->first_name }} {{ $registration->last_name }}</div>
        </div>
        
        <!-- Email -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Email</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="mailto:{{ $registration->email }}" style="color: #3b82f6; text-decoration: none;">{{ $registration->email }}</a>
            </div>
        </div>
        
        @if($registration->phone)
        <!-- Phone -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Phone</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="tel:{{ $registration->phone }}" style="color: #3b82f6; text-decoration: none;">{{ $registration->phone }}</a>
            </div>
        </div>
        @endif
        
        <!-- Registration Date -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Registered</div>
            <div style="color: #111827; font-size: 16px;">{{ $registration->registered_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
        
        <!-- Status -->
        <div style="margin-bottom: 16px;">
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
        
        @if($registration->special_requirements)
        <!-- Special Requirements -->
        @if($registration->amount_paid > 0)
        <div style="margin-bottom: 16px;">
        @else
        <div style="margin-bottom: 0;">
        @endif
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Special Requirements</div>
            <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; color: #374151; font-size: 14px; line-height: 1.5;">{{ $registration->special_requirements }}</div>
        </div>
        @endif
        
        @if($registration->amount_paid > 0)
        <!-- Amount Paid -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Amount Paid</div>
            <div style="color: #059669; font-size: 20px; font-weight: 700;">BD {{ number_format($registration->amount_paid, 2) }}</div>
        </div>
        @endif
    </div>
</div>

@if($registration->amount_paid > 0)
<!-- Payment Information -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Payment Information</h3>
    
    <div>
        <!-- Payment Status -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Payment Status</div>
            <div>
                @if($registration->payment_status === 'paid')
                    <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">Paid</span>
                @elseif($registration->payment_status === 'pending')
                    <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">Pending</span>
                @else
                    <span style="background: #f3f4f6; color: #374151; padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 500;">{{ ucfirst($registration->payment_status) }}</span>
                @endif
            </div>
        </div>
        
        @if($registration->payment_method)
        <!-- Payment Method -->
        @if($registration->payment_reference)
        <div style="margin-bottom: 16px;">
        @else
        <div style="margin-bottom: 0;">
        @endif
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Payment Method</div>
            <div style="color: #111827; font-size: 16px;">{{ ucfirst($registration->payment_method) }}</div>
        </div>
        @endif
        
        @if($registration->payment_reference)
        <!-- Payment Reference -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Payment Reference</div>
            <div style="color: #111827; font-size: 16px; font-family: mono;">{{ $registration->payment_reference }}</div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Action Button -->
<div style="text-align: center; margin: 32px 0;">
    <a href="{{ url('/admin/event-registrations/' . $registration->id . '/edit') }}" style="display: inline-block; background: #3b82f6; color: white; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: 500; font-size: 16px; transition: background-color 0.2s;">
        Review Registration
    </a>
</div>

<!-- Action Required Notice -->
<div style="background: #fffbeb; border: 1px solid #f59e0b; border-radius: 12px; padding: 20px; margin-top: 32px;">
    <div style="display: flex; align-items: flex-start;">
        <div style="width: 20px; height: 20px; background: #f59e0b; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0; margin-top: 2px;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                <path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div>
            <p style="color: #92400e; font-weight: 500; margin: 0; line-height: 1.5;">
                <strong>Action Required:</strong> Please review this event registration and take appropriate action in the admin panel.
            </p>
        </div>
    </div>
</div>

@endcomponent