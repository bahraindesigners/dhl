<x-mail::message>
# 🎉 Registration Confirmed!

Hello {{ $registration->first_name }} {{ $registration->last_name }},

Thank you for registering for **{{ $event->title }}**! We're excited to have you join us.

## 📅 Event Details

**Event:** {{ $event->title }}  
**Category:** {{ $eventCategory->name }}  
**Date & Time:** {{ $event->start_date->format('F j, Y \a\t g:i A') }}  
@if($event->end_date)
**End Date:** {{ $event->end_date->format('F j, Y \a\t g:i A') }}  
@endif
@if($event->location)
**Location:** {{ $event->location }}  
@endif
@if($event->description)

## 📋 Event Description

{{ $event->description }}
@endif

## 👤 Your Registration Details

**Name:** {{ $registration->first_name }} {{ $registration->last_name }}  
**Email:** {{ $registration->email }}  
@if($registration->phone)
**Phone:** {{ $registration->phone }}  
@endif
**Registration Date:** {{ $registration->registered_at->format('F j, Y \a\t g:i A') }}  
**Status:** {{ ucfirst($registration->status) }}

@if($registration->special_requirements)
**Special Requirements:** {{ $registration->special_requirements }}
@endif

@if($registration->amount_paid > 0)
## 💰 Payment Information

**Amount Paid:** ${{ number_format($registration->amount_paid, 2) }}  
**Payment Status:** {{ ucfirst($registration->payment_status) }}  
@if($registration->payment_method)
**Payment Method:** {{ ucfirst($registration->payment_method) }}  
@endif
@if($registration->payment_reference)
**Payment Reference:** {{ $registration->payment_reference }}  
@endif
@endif

## 📝 What's Next?

- Save this confirmation email for your records
- Mark your calendar for {{ $event->start_date->format('F j, Y') }}
@if($event->location)
- Plan your route to {{ $event->location }}
@endif
- We'll send you any additional event updates as the date approaches

@if($registration->status !== 'confirmed')
<x-mail::panel>
⚠️ **Please Note:** Your registration is currently **{{ $registration->status }}**. You'll receive another email once it's confirmed.
</x-mail::panel>
@endif

If you have any questions or need to make changes to your registration, please contact us.

We look forward to seeing you at the event!

Best regards,<br>
{{ config('app.name') }} Events Team
</x-mail::message>
