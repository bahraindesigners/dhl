<x-mail::message>
# New Member Profile Submission

A new member profile has been submitted to the DHL Bahrain Trade Union.

## Member Information

**Name:** {{ $user->name }}  
**Email:** {{ $user->email }}  
**CPR Number:** {{ $memberProfile->cpr_number }}  
**Staff Number:** {{ $memberProfile->staff_number }}  
**Position:** {{ $memberProfile->position }}  
**Department:** {{ $memberProfile->department }}  
**Mobile:** {{ $memberProfile->mobile_number }}  
**Date of Joining:** {{ $memberProfile->date_of_joining?->format('d/m/Y') }}  

## Contact Details

**Office Phone:** {{ $memberProfile->office_phone }}  
**Home Phone:** {{ $memberProfile->home_phone }}  
**Working Address:** {{ $memberProfile->working_place_address }}  
**Permanent Address:** {{ $memberProfile->permanent_address }}  

## Additional Information

**Nationality:** {{ $memberProfile->nationality }}  
**Gender:** {{ ucfirst($memberProfile->gender) }}  
**Marital Status:** {{ ucfirst($memberProfile->marital_status) }}  
**Education:** {{ $memberProfile->education_qualification }}  
**Section:** {{ $memberProfile->section }}  

<x-mail::button :url="config('app.url') . '/admin/member-profiles'">
View in Admin Panel
</x-mail::button>

Please review this submission and take appropriate action.

Thanks,<br>
{{ config('app.name') }} System
</x-mail::message>
