<x-mail::message>
# Application Received

Dear {{ $application->full_name }},

Thank you for applying for the position of **{{ $application->position->title }}**
({{ $application->position->grade }}) at Federal College of Education (Technical), Potiskum.

Your application has been received and is currently under review. You will be
contacted using the phone number or email you provided if you are shortlisted
for an interview.

**Reference number:** APP-{{ str_pad($application->id, 5, '0', STR_PAD_LEFT) }}

Please keep this reference number for your records.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
