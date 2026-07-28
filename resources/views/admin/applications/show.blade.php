@extends('layouts.admin')

@section('title', $application->full_name)

@section('content')
    <a href="{{ route('admin.applications.index') }}" class="text-sm text-blue-800 hover:underline">&larr; All applications</a>

    <div class="flex items-start justify-between mt-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $application->full_name }}</h1>
            <p class="text-slate-500">Applied for: {{ $application->position->title }} ({{ $application->position->grade }})</p>
        </div>

        <form method="POST" action="{{ route('admin.applications.status', $application) }}" class="space-y-2" id="status-form">
            @csrf
            @method('PATCH')
            <div class="flex items-center gap-2">
                <select name="status" id="status-select" class="border rounded-md px-3 py-2 text-sm">
                    <option value="pending" @selected($application->status === 'pending')>Pending</option>
                    <option value="shortlisted" @selected($application->status === 'shortlisted')>Shortlisted</option>
                    <option value="interview" @selected($application->status === 'interview')>Interview</option>
                    <option value="rejected" @selected($application->status === 'rejected')>Rejected</option>
                </select>
                <button class="bg-blue-900 text-white rounded-md px-4 py-2 text-sm">Update Status</button>
            </div>

            <div id="interview-fields" class="grid sm:grid-cols-2 gap-2 border rounded-md p-3 bg-slate-50" style="display: none;">
                <div>
                    <label class="block text-xs font-medium mb-1">Interview Date</label>
                    <input type="date" name="interview_date" value="{{ old('interview_date', $application->interview_date?->format('Y-m-d')) }}" class="w-full border rounded-md px-2 py-1 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Interview Time</label>
                    <input type="time" name="interview_time" value="{{ old('interview_time', $application->interview_time?->format('H:i')) }}" class="w-full border rounded-md px-2 py-1 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium mb-1">Venue / Meeting Link</label>
                    <input type="text" name="interview_location" value="{{ old('interview_location', $application->interview_location) }}" class="w-full border rounded-md px-2 py-1 text-sm" placeholder="e.g. Registrar's Office or a Zoom/Meet link">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium mb-1">Notes for Applicant</label>
                    <textarea name="interview_notes" rows="2" class="w-full border rounded-md px-2 py-1 text-sm">{{ old('interview_notes', $application->interview_notes) }}</textarea>
                </div>
            </div>
        </form>

        <script>
            (function () {
                var select = document.getElementById('status-select');
                var fields = document.getElementById('interview-fields');

                function toggle() {
                    fields.style.display = select.value === 'interview' ? 'grid' : 'none';
                }

                select.addEventListener('change', toggle);
                toggle();
            })();
        </script>
    </div>

    <div class="grid sm:grid-cols-2 gap-6">
        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Personal</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Date of Birth</dt><dd>{{ optional($application->date_of_birth)->format('d M Y') ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">Marital Status</dt><dd>{{ $application->marital_status ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">Nationality</dt><dd>{{ $application->nationality ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">State / LGA of Origin</dt><dd>{{ $application->state_of_origin }} / {{ $application->lga_of_origin }}</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Contact</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Phone</dt><dd>{{ $application->phone }}</dd></div>
                <div><dt class="text-slate-400">Email</dt><dd>{{ $application->email }}</dd></div>
                <div><dt class="text-slate-400">Permanent Address</dt><dd>{{ $application->permanent_address ?: 'N/A' }}</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Next of Kin</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Name</dt><dd>{{ $application->next_of_kin_name ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">Address</dt><dd>{{ $application->next_of_kin_address ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">Phone</dt><dd>{{ $application->next_of_kin_phone ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">Children</dt><dd>{{ $application->number_of_children }} ({{ $application->children_ages ?: 'N/A' }})</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Employment</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Present Status</dt><dd>{{ $application->employment_status ?: 'N/A' }}</dd></div>
                <div><dt class="text-slate-400">Present Salary</dt><dd>{{ $application->present_salary ?: 'N/A' }}</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-3">Education</h2>
            @if (!empty($application->education))
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-slate-400 border-b">
                                <th class="pb-2 pr-4">Institution</th>
                                <th class="pb-2 pr-4">Qualification</th>
                                <th class="pb-2 pr-4">Start Year</th>
                                <th class="pb-2">End Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($application->education as $edu)
                                <tr class="border-b last:border-0">
                                    <td class="py-2 pr-4">{{ $edu['institution'] ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $edu['qualification'] ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $edu['start_year'] ?? '-' }}</td>
                                    <td class="py-2">{{ $edu['end_year'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-400">No education entries provided.</p>
            @endif
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-2">Professional Qualifications / Certifications</h2>
            <p class="text-sm whitespace-pre-line">{{ $application->professional_qualifications ?: '-' }}</p>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-3">Work Experience</h2>
            @if (!empty($application->work_experiences))
                <div class="space-y-4">
                    @foreach ($application->work_experiences as $job)
                        <div class="border-b last:border-0 pb-4 last:pb-0">
                            <p class="font-medium text-sm">{{ $job['position'] ?? '-' }} — {{ $job['employer'] ?? '-' }}</p>
                            <p class="text-xs text-slate-400 mb-1">{{ $job['start_date'] ?? '-' }} to {{ $job['end_date'] ?? '-' }}</p>
                            @if (!empty($job['description']))
                                <p class="text-sm whitespace-pre-line">{{ $job['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-slate-400">No work experience entries provided.</p>
            @endif
        </section>

        @if ($application->publications || $application->extra_curricular || $application->additional_info)
        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-2">Additional Information</h2>
            @if ($application->publications)<p class="text-sm mb-2"><strong>Publications:</strong> {{ $application->publications }}</p>@endif
            @if ($application->extra_curricular)<p class="text-sm mb-2"><strong>Extra-Curricular:</strong> {{ $application->extra_curricular }}</p>@endif
            @if ($application->additional_info)<p class="text-sm"><strong>Other:</strong> {{ $application->additional_info }}</p>@endif
        </section>
        @endif

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-3">Referees</h2>
            <div class="grid sm:grid-cols-3 gap-4 text-sm">
                @foreach ($application->referees ?? [] as $referee)
                    <div>
                        <p class="font-medium">{{ $referee['name'] ?? '-' }}</p>
                        <p class="text-slate-500">{{ $referee['address'] ?? '-' }}</p>
                        <p class="text-slate-500">{{ $referee['phone'] ?? '-' }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-3">Documents</h2>
            @php
                $documentSlots = [
                    ['field' => 'passport', 'label' => 'Passport Photograph', 'required' => true],
                    ['field' => 'birth_certificate', 'label' => 'Birth Certificate', 'required' => true],
                    ['field' => 'olevel_result', 'label' => "O'Level Result", 'required' => true],
                    ['field' => 'degree', 'label' => 'First Degree', 'required' => true],
                    ['field' => 'lga_certificate', 'label' => 'Local Government Identification', 'required' => true],
                    ['field' => 'nysc_certificate', 'label' => 'NYSC Certificate', 'required' => true],
                    ['field' => 'masters_certificate', 'label' => "Master's Degree", 'required' => false],
                    ['field' => 'professional_certificate', 'label' => 'Professional Certificate', 'required' => false],
                    ['field' => 'nin', 'label' => 'National Identification Number (NIN)', 'required' => true],
                    ['field' => 'primary_certificate', 'label' => 'Primary School Certificate', 'required' => true],
                    ['field' => 'trcn_certificate', 'label' => 'TRCN Certificate', 'required' => false],
                ];
            @endphp
            <div class="space-y-2">
                @foreach ($documentSlots as $slot)
                    @php $hasFile = $application->{$slot['field'] . '_path'}; @endphp
                    <div class="flex items-center justify-between border rounded-lg px-4 py-2 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">{{ $slot['label'] }}</span>
                            @if ($slot['required'])
                                <span class="text-xs px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">Required</span>
                            @else
                                <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200">Optional</span>
                            @endif
                        </div>
                        @if ($hasFile)
                            <a href="{{ route('admin.applications.download', [$application, $slot['field']]) }}" class="text-blue-800 hover:underline">Download</a>
                        @else
                            <span class="text-slate-400">Not submitted</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection


