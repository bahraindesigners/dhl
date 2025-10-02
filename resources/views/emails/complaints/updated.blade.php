<x-mail::message>
@if($isAdminNotification)
# Complaint Updated

A complaint has been updated in the system.

**Complaint Details:**
- **Ticket ID:** {{ $complaint->ticket_id }}
- **Subject:** {{ $complaint->subject }}
- **Priority:** {{ ucfirst($complaint->priority) }}
- **Status:** {{ ucfirst($complaint->status) }}
- **Member:** {{ $complaint->user->name ?? 'N/A' }}
- **Member ID:** {{ $complaint->member_profile->member_id ?? 'N/A' }}
- **Last Updated:** {{ $complaint->updated_at->format('M d, Y \a\t H:i') }}

**Description:**
{{ $complaint->description }}

@if($complaint->admin_notes)
**Admin Notes:**
{{ $complaint->admin_notes }}
@endif

<x-mail::button :url="config('app.url') . '/admin/complaints/' . $complaint->id">
View Complaint in Admin Panel
</x-mail::button>

@else
# Your Complaint Status Updated

Your complaint has been updated. Please check the details below.

**Your Complaint Details:**
- **Ticket ID:** {{ $complaint->ticket_id }}
- **Subject:** {{ $complaint->subject }}
- **Priority:** {{ ucfirst($complaint->priority) }}
- **Status:** {{ ucfirst($complaint->status) }}
- **Last Updated:** {{ $complaint->updated_at->format('M d, Y \a\t H:i') }}

@if($complaint->admin_notes)
**Update Notes:**
{{ $complaint->admin_notes }}
@endif

<x-mail::button :url="route('complaints.show', $complaint)">
View Your Complaint
</x-mail::button>

@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
