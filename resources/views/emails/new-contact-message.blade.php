@component('emails.layouts.base', [
    'title' => 'New Contact Message',
    'subtitle' => 'Someone has sent a message through the contact form'
])

<!-- Alert -->
<div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 12px; padding: 20px; margin-bottom: 32px; text-align: center;">
    <div style="width: 48px; height: 48px; background: #3b82f6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
    </div>
    <p style="color: #1e40af; font-size: 16px; margin: 0; font-weight: 500;">A new message has been received via the contact form</p>
</div>

<!-- Contact Information -->
<div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 16px 0;">Contact Information</h3>
    
    <div>
        <!-- Name -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Name</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $contact->name }}</div>
        </div>
        
        <!-- Email -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Email</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="mailto:{{ $contact->email }}" style="color: #3b82f6; text-decoration: none;">{{ $contact->email }}</a>
            </div>
        </div>
        
        @if($contact->phone)
        <!-- Phone -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Phone</div>
            <div style="color: #111827; font-size: 16px;">
                <a href="tel:{{ $contact->phone }}" style="color: #3b82f6; text-decoration: none;">{{ $contact->phone }}</a>
            </div>
        </div>
        @endif
        
        @if($contact->subject)
        <!-- Subject -->
        <div style="margin-bottom: 16px;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Subject</div>
            <div style="color: #111827; font-size: 16px; font-weight: 500;">{{ $contact->subject }}</div>
        </div>
        @endif
        
        <!-- Received Date -->
        <div style="margin-bottom: 0;">
            <div style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 4px;">Received</div>
            <div style="color: #111827; font-size: 16px;">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

<!-- Message Content -->
<div style="margin-bottom: 32px;">
    <h3 style="color: #111827; font-size: 18px; font-weight: 600; margin: 0 0 12px 0;">Message</h3>
    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; white-space: pre-wrap; line-height: 1.6; font-size: 16px; color: #374151;">{{ $contact->message }}</div>
</div>

<!-- Quick Reply -->
<div style="background: #f0f9ff; border: 1px solid #c7d2fe; border-radius: 12px; padding: 20px; text-align: center;">
    <h3 style="color: #4338ca; font-size: 16px; font-weight: 600; margin: 0 0 8px 0;">Quick Reply</h3>
    <p style="margin: 0; color: #4338ca; font-size: 14px; line-height: 1.5;">
        Reply directly to this email to respond to <strong>{{ $contact->email }}</strong>
    </p>
</div>

@endcomponent