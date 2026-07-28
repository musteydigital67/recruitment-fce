<x-mail::message>
# Application Status Update

Dear {{ $application->full_name }},

@if ($application->status === 'interview')
Congratulations! You have been invited for an interview for the position of
**{{ $application->position->title }}** ({{ $application->position->grade }})
at Federal College of Education (Technical), Potiskum.

**Interview Details**

- **Date:** {{ optional($application->interview_date)->format('l, d F Y') ?? 'To be confirmed' }}
- **Time:** {{ $application->interview_time ? \Carbon\Carbon::parse($application->interview_time)->format('g:i A') : 'To be confirmed' }}
- **Venue / Link:** {{ $application->interview_location ?? 'To be confirmed' }}

@if ($application->interview_notes)
**Additional Notes**

{{ $application->interview_notes }}
@endif

Please arrive on time and bring along original copies of your credentials.
@elseif ($application->status === 'shortlisted')
We are pleased to inform you that your application for the position of
**{{ $application->position->title }}** ({{ $application->position->grade }})
has been shortlisted. You will be contacted separately with further details,
including any interview arrangements.
@elseif ($application->status === 'rejected')
Thank you for your interest in the position of **{{ $application->position->title }}**
({{ $application->position->grade }}) at Federal College of Education (Technical), Potiskum.

After careful review, we regret to inform you that your application was not
successful on this occasion. We appreciate the time you invested and encourage
you to apply for future openings that match your qualifications.
@else
The status of your application for the position of **{{ $application->position->title }}**
({{ $application->position->grade }}) has been updated to **{{ ucfirst($application->status) }}**.
@endif

**Reference number:** APP-{{ str_pad($application->id, 5, '0', STR_PAD_LEFT) }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>