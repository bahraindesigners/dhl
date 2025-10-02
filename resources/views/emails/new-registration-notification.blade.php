@component('emails.layouts.base', [
    'title' => 'New Event Registration',
    'subtitle' => 'A new event registration has been submitted'
])

<!-- Event Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">🎉 Event Information</h2>
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
        @if($event->location)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Location</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $event->location }}</div>
        </div>
        @endif
    </div>
</div>

<!-- Registration Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">👤 Registration Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Registration ID</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">#{{ $registration->id }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Participant Name</div>
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
        @if($registration->special_requirements || $registration->amount_paid > 0)
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
        @if($registration->special_requirements && $registration->amount_paid > 0)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Special Requirements</div>
            <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; white-space: pre-wrap; line-height: 1.6; font-size: 15px; color: #374151;">{{ $registration->special_requirements }}</div>
        </div>
        @elseif($registration->special_requirements)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Special Requirements</div>
            <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; white-space: pre-wrap; line-height: 1.6; font-size: 15px; color: #374151;">{{ $registration->special_requirements }}</div>
        </div>
        @endif
        @if($registration->amount_paid > 0)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Amount Paid</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 700; color: #059669; font-size: 18px; line-height: 1.5;">
                BD {{ number_format($registration->amount_paid, 2) }}
            </div>
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

<!-- Action Button -->
<div style="text-align: center; margin: 30px 0;">
    <a href="{{ url('/admin/event-registrations/' . $registration->id) }}" style="display: inline-block; background: linear-gradient(135deg, #ffcb00 0%, #ffd700 100%); color: #1a1a1a; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 3px 10px rgba(255, 203, 0, 0.3);">
        Review Registration
    </a>
</div>

<!-- Action Required Notice -->
<div style="background: #fff8e1; padding: 20px; border-radius: 8px; border-left: 4px solid #ffcb00; margin-top: 30px;">
    <p style="margin: 0; color: #92400e; font-weight: 500;">
        <strong>Action Required:</strong> Please review this event registration and take appropriate action in the admin panel.
    </p>
</div>

@endcomponent
            color: #ffc107;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 New Event Registration</h1>
        <p>A new registration has been submitted for one of your events.</p>
    </div>

    <div class="content">
        <div class="event-details">
            <h2>📅 Event Details</h2>
            <div class="detail-row">
                <span class="label">Event:</span> {{ $event->title }}
            </div>
            <div class="detail-row">
                <span class="label">Category:</span> {{ $eventCategory->name }}
            </div>
            <div class="detail-row">
                <span class="label">Start Date:</span> {{ $event->start_date->format('F j, Y g:i A') }}
            </div>
            @if($event->location)
            <div class="detail-row">
                <span class="label">Location:</span> {{ $event->location }}
            </div>
            @endif
        </div>

        <div class="registration-details">
            <h2>👤 Registration Details</h2>
            <div class="detail-row">
                <span class="label">Name:</span> {{ $registration->first_name }} {{ $registration->last_name }}
            </div>
            <div class="detail-row">
                <span class="label">Email:</span> {{ $registration->email }}
            </div>
            @if($registration->phone)
            <div class="detail-row">
                <span class="label">Phone:</span> {{ $registration->phone }}
            </div>
            @endif
            <div class="detail-row">
                <span class="label">Registration Date:</span> {{ $registration->registered_at->format('F j, Y g:i A') }}
            </div>
            <div class="detail-row">
                <span class="label">Status:</span> 
                <span class="{{ $registration->status === 'confirmed' ? 'status-confirmed' : 'status-pending' }}">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>
            @if($registration->special_requirements)
            <div class="detail-row">
                <span class="label">Special Requirements:</span> {{ $registration->special_requirements }}
            </div>
            @endif
        </div>

        @if($registration->amount_paid > 0)
        <div class="registration-details">
            <h2>💰 Payment Information</h2>
            <div class="detail-row">
                <span class="label">Amount Paid:</span> ${{ number_format($registration->amount_paid, 2) }}
            </div>
            <div class="detail-row">
                <span class="label">Payment Status:</span> {{ ucfirst($registration->payment_status) }}
            </div>
            @if($registration->payment_method)
            <div class="detail-row">
                <span class="label">Payment Method:</span> {{ ucfirst($registration->payment_method) }}
            </div>
            @endif
            @if($registration->payment_reference)
            <div class="detail-row">
                <span class="label">Payment Reference:</span> {{ $registration->payment_reference }}
            </div>
            @endif
        </div>
        @endif
    </div>

    <div class="footer">
        <p>This is an automated notification from the DHL Event Management System.</p>
        <p>Please log into the admin panel to view more details or manage this registration.</p>
    </div>
</body>
</html>