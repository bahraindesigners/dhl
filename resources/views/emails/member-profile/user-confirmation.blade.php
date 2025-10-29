@component('mail::message')
# Welcome to DHL Bahrain Trade Union!

Dear {{ $user->name }},

Thank you for joining our union community! 🎉

## ✅ Application Received

We have successfully received your membership application and it is now under review.

## 📋 Your Submission Details

**Submission Date:** {{ $memberProfile->created_at->format('F j, Y \a\t g:i A') }}
**Staff Number:** {{ $memberProfile->staff_number }}
**Position:** {{ $memberProfile->position }}
**Department:** {{ $memberProfile->department }}

## 🔄 What Happens Next?

1. **Review Process** - Our team will review your application within 2-3 business days
2. **Verification** - We may contact you if additional information is needed
3. **Approval Notification** - You will be notified once your membership is approved
4. **Welcome Package** - Upon approval, you'll receive your membership benefits information

@component('mail::button', ['url' => url('/profile')])
View Membership Status
@endcomponent

> **Important:** Please keep this email for your records as it contains your submission reference.
> For questions about your application, please contact us through our official channels.

Thank you for choosing to be part of our union!

Best regards,
DHL Bahrain Trade Union

@endcomponent