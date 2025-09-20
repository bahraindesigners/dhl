<x-mail::message>
# Membership Application Received

Dear {{ $user->name }},

Thank you for submitting your membership application to the DHL Bahrain Trade Union. We have successfully received your profile information.

## Your Submission Details

**Submitted On:** {{ $memberProfile->created_at->format('d/m/Y h:i A') }}  
**Staff Number:** {{ $memberProfile->staff_number }}  
**Position:** {{ $memberProfile->position }}  
**Department:** {{ $memberProfile->department }}  

## What Happens Next?

1. **Review Process:** Our team will review your application within 2-3 business days
2. **Verification:** We may contact you if additional information is needed
3. **Approval:** You will be notified once your membership is approved
4. **Welcome Package:** Upon approval, you'll receive your membership welcome package

## Need Help?

If you have any questions about your application or the membership process, please don't hesitate to contact us.

**Important:** Please keep this email for your records as it contains your submission reference.

<x-mail::button :url="config('app.url') . '/membership'">
View Membership Page
</x-mail::button>

Thank you for choosing to be part of our union!

Best regards,<br>
DHL Bahrain Trade Union
</x-mail::message>
