@if($isAdminNotification)
@component('emails.layouts.base', [
    'title' => 'New Complaint Submitted',
    'subtitle' => 'A member has submitted a complaint that requires attention'
])

<div class="content-section">
    <h2 class="section-title">⚠️ Complaint Information</h2>
    <div class="field-group">
        <div class="field">
            <div class="field-label">Ticket ID</div>
            <div class="field-value highlight">#{{ $complaint->ticket_id }}</div>
        </div>
        <div class="field">
            <div class="field-label">Subject</div>
            <div class="field-value highlight">{{ $complaint->subject }}</div>
        </div>
        <div class="field">
            <div class="field-label">Priority</div>
            <div class="field-value">
                <span class="status-badge {{ $complaint->priority === 'high' ? 'status-rejected' : ($complaint->priority === 'medium' ? 'status-pending' : 'status-approved') }}">
                    {{ ucfirst($complaint->priority) }}
                </span>
            </div>
        </div>
        <div class="field">
            <div class="field-label">Status</div>
            <div class="field-value">
                <span class="status-badge status-pending">{{ ucfirst($complaint->status) }}</span>
            </div>
        </div>
        <div class="field">
            <div class="field-label">Submitted Date</div>
            <div class="field-value">{{ $complaint->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">👤 Complainant Information</h2>
    <div class="field-group">
        <div class="field">
            <div class="field-label">Name</div>
            <div class="field-value highlight">{{ $complaint->user->name ?? 'N/A' }}</div>
        </div>
        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $complaint->user->email }}" style="color: #ffcb00; text-decoration: none;">
                    {{ $complaint->user->email ?? 'N/A' }}
                </a>
            </div>
        </div>
        <div class="field">
            <div class="field-label">Member ID</div>
            <div class="field-value">{{ $complaint->member_profile->member_id ?? 'N/A' }}</div>
        </div>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">📝 Complaint Description</h2>
    <div class="message-content">{{ $complaint->description }}</div>
</div>

<div class="button-container">
    <a href="{{ config('app.url') . '/admin/complaints/' . $complaint->id }}" class="btn">
        View in Admin Panel
    </a>
</div>

<div style="background: #fee2e2; padding: 20px; border-radius: 8px; border-left: 4px solid #dc2626; margin-top: 30px;">
    <p style="margin: 0; color: #991b1b; font-weight: 500;">
        <strong>Action Required:</strong> This complaint requires your attention. Please review and respond promptly to maintain member satisfaction.
    </p>
</div>

@endcomponent

@else
@component('emails.layouts.base', [
    'title' => 'Complaint Submitted Successfully',
    'subtitle' => 'We have received your complaint and will review it shortly'
])

<div style="text-align: center; margin-bottom: 30px;">
    <h2 style="color: #059669; font-size: 24px; margin: 0;">Thank you for your submission</h2>
    <p style="color: #6b7280; font-size: 16px; margin: 10px 0 0 0;">
        Your complaint has been received and is being processed
    </p>
</div>

<div class="content-section">
    <h2 class="section-title">📋 Your Complaint Details</h2>
    <div class="field-group">
        <div class="field">
            <div class="field-label">Ticket ID</div>
            <div class="field-value highlight">#{{ $complaint->ticket_id }}</div>
        </div>
        <div class="field">
            <div class="field-label">Subject</div>
            <div class="field-value">{{ $complaint->subject }}</div>
        </div>
        <div class="field">
            <div class="field-label">Priority</div>
            <div class="field-value">{{ ucfirst($complaint->priority) }}</div>
        </div>
        <div class="field">
            <div class="field-label">Status</div>
            <div class="field-value">
                <span class="status-badge status-pending">{{ ucfirst($complaint->status) }}</span>
            </div>
        </div>
        <div class="field">
            <div class="field-label">Submitted</div>
            <div class="field-value">{{ $complaint->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">📝 Your Description</h2>
    <div class="message-content">{{ $complaint->description }}</div>
</div>

<div class="button-container">
    <a href="{{ config('app.url') . '/complaints/' . $complaint->id }}" class="btn">
        Track Your Complaint
    </a>
</div>

<div style="background: #f0f9ff; padding: 20px; border-radius: 8px; border-left: 4px solid #0284c7; margin-top: 30px;">
    <p style="margin: 0; color: #0c4a6e; font-weight: 500;">
        <strong>Next Steps:</strong> Our team will review your complaint and respond within 2-3 business days. You can track the progress using your ticket ID: <strong>#{{ $complaint->ticket_id }}</strong>
    </p>
</div>

@endcomponent
@endif
- **Priority:** {{ ucfirst($complaint->priority) }}
- **Status:** {{ ucfirst($complaint->status) }}
- **Submitted on:** {{ $complaint->created_at->format('M d, Y \a\t H:i') }}

You can track the status of your complaint using the ticket ID above.

<x-mail::button :url="route('complaints.show', $complaint)">
View Your Complaint
</x-mail::button>

@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
