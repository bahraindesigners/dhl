@component('emails.layouts.base', [
    'title' => 'New Contact Message',
    'subtitle' => 'Someone has sent a message through the contact form'
])

<!-- Contact Information Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">👤 Contact Information</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Name</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $contact->name }}</div>
        </div>
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Email</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="mailto:{{ $contact->email }}" style="color: #ffcb00; text-decoration: none;">{{ $contact->email }}</a>
            </div>
        </div>
        @if($contact->phone)
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Phone</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">
                <a href="tel:{{ $contact->phone }}" style="color: #ffcb00; text-decoration: none;">{{ $contact->phone }}</a>
            </div>
        </div>
        @endif
        @if($contact->subject)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Subject</div>
            <div style="background: #fff8e1; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #ffcb00; font-weight: 500; color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $contact->subject }}</div>
        </div>
        @endif
    </div>
</div>

<!-- Message Content Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">💬 Message Content</h2>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-family: Georgia, serif; font-size: 15px; color: #374151;">{{ $contact->message }}</div>
</div>

<!-- Message Details Section -->
<div style="margin-bottom: 30px;">
    <h2 style="color: #1a1a1a; font-size: 20px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #ffcb00; display: inline-block;">📋 Message Details</h2>
    <div style="background: #f8f9fb; border-radius: 8px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #ffcb00;">
        <div style="margin-bottom: 15px;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Received At</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
        @if($contact->ip_address)
        <div style="margin-bottom: 0;">
            <div style="font-weight: 600; color: #374151; margin-bottom: 5px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">IP Address</div>
            <div style="color: #1f2937; font-size: 16px; line-height: 1.5;">{{ $contact->ip_address }}</div>
        </div>
        @endif
    </div>
</div>

<!-- Quick Reply Notice -->
<div style="background: #e0f2fe; padding: 20px; border-radius: 8px; border-left: 4px solid #0288d1; margin-top: 30px;">
    <p style="margin: 0; color: #01579b; font-weight: 500;">
        <strong>Quick Reply:</strong> You can respond directly by replying to this email. The sender will receive your response at <strong>{{ $contact->email }}</strong>
    </p>
</div>

@endcomponent