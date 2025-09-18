<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Event Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .registration-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .event-details {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .detail-row {
            margin: 8px 0;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .status-confirmed {
            color: #28a745;
        }
        .status-pending {
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