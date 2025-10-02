@component('emails.layouts.base', [
    'title' => 'Welcome to DHL Bahrain Trade Union!',
    'subtitle' => 'Your membership application has been received'
])

<div style="text-align: center; margin-bottom: 30px;">
    <h2 style="color: #059669; font-size: 24px; margin: 0;">Dear {{ $user->name }},</h2>
    <p style="color: #6b7280; font-size: 16px; margin: 10px 0 0 0;">
        Thank you for joining our union community! 🎉
    </p>
</div>

<div class="content-section">
    <h2 class="section-title">✅ Application Received</h2>
    <div style="background: #f0f9ff; padding: 20px; border-radius: 8px; border-left: 4px solid #0284c7;">
        <p style="margin: 0; color: #0c4a6e; font-weight: 500;">
            We have successfully received your membership application and it is now under review.
        </p>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">📋 Your Submission Details</h2>
    <div class="field-group">
        <div class="field">
            <div class="field-label">Submission Date</div>
            <div class="field-value highlight">{{ $memberProfile->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
        <div class="field">
            <div class="field-label">Staff Number</div>
            <div class="field-value">{{ $memberProfile->staff_number }}</div>
        </div>
        <div class="field">
            <div class="field-label">Position</div>
            <div class="field-value">{{ $memberProfile->position }}</div>
        </div>
        <div class="field">
            <div class="field-label">Department</div>
            <div class="field-value">{{ $memberProfile->department }}</div>
        </div>
    </div>
</div>

<div class="content-section">
    <h2 class="section-title">🔄 What Happens Next?</h2>
    <div style="background: #fefce8; padding: 20px; border-radius: 8px; border-left: 4px solid #eab308;">
        <div style="color: #854d0e;">
            <div style="margin-bottom: 15px;">
                <strong>1. Review Process</strong><br>
                <span style="color: #a16207;">Our team will review your application within 2-3 business days</span>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>2. Verification</strong><br>
                <span style="color: #a16207;">We may contact you if additional information is needed</span>
            </div>
            <div style="margin-bottom: 15px;">
                <strong>3. Approval Notification</strong><br>
                <span style="color: #a16207;">You will be notified once your membership is approved</span>
            </div>
            <div style="margin-bottom: 0;">
                <strong>4. Welcome Package</strong><br>
                <span style="color: #a16207;">Upon approval, you'll receive your membership benefits information</span>
            </div>
        </div>
    </div>
</div>

<div class="button-container">
    <a href="{{ config('app.url') . '/membership' }}" class="btn">
        View Membership Status
    </a>
</div>

<div style="background: #e0f2fe; padding: 20px; border-radius: 8px; border-left: 4px solid #0288d1; margin-top: 30px; text-align: center;">
    <p style="margin: 0; color: #01579b; font-weight: 500;">
        <strong>Important:</strong> Please keep this email for your records as it contains your submission reference.
    </p>
    <p style="margin: 10px 0 0 0; color: #0277bd; font-size: 14px;">
        For questions about your application, please contact us through our official channels.
    </p>
</div>

@endcomponent

Thank you for choosing to be part of our union!

Best regards,<br>
DHL Bahrain Trade Union
</x-mail::message>
