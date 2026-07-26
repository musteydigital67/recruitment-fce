@extends('layouts.admin')

@section('title', $application->full_name)

@section('content')
    <a href="{{ route('admin.applications.index') }}" class="text-sm text-blue-800 hover:underline">&larr; All applications</a>

    <div class="flex items-start justify-between mt-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $application->full_name }}</h1>
            <p class="text-slate-500">Applied for: {{ $application->position->title }} ({{ $application->position->grade }})</p>
        </div>

        <form method="POST" action="{{ route('admin.applications.status', $application) }}" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <select name="status" class="border rounded-md px-3 py-2 text-sm">
                <option value="pending" @selected($application->status === 'pending')>Pending</option>
                <option value="shortlisted" @selected($application->status === 'shortlisted')>Shortlisted</option>
                <option value="rejected" @selected($application->status === 'rejected')>Rejected</option>
            </select>
            <button class="bg-blue-900 text-white rounded-md px-4 py-2 text-sm">Update Status</button>
        </form>
    </div>

    <div class="grid sm:grid-cols-2 gap-6">
        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Personal</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Place of Birth</dt><dd>{{ $application->place_of_birth ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Date of Birth</dt><dd>{{ optional($application->date_of_birth)->format('d M Y') ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Marital Status</dt><dd>{{ $application->marital_status ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Nationality</dt><dd>{{ $application->nationality ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">State / LGA of Origin</dt><dd>{{ $application->state_of_origin }} / {{ $application->lga_of_origin }}</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Contact</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Phone</dt><dd>{{ $application->phone }}</dd></div>
                <div><dt class="text-slate-400">Email</dt><dd>{{ $application->email }}</dd></div>
                <div><dt class="text-slate-400">Permanent Address</dt><dd>{{ $application->permanent_address ?: '—' }}</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Next of Kin</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Name</dt><dd>{{ $application->next_of_kin_name ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Address</dt><dd>{{ $application->next_of_kin_address ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Phone</dt><dd>{{ $application->next_of_kin_phone ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Children</dt><dd>{{ $application->number_of_children }} ({{ $application->children_ages ?: '—' }})</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6">
            <h2 class="font-semibold mb-3">Employment</h2>
            <dl class="text-sm space-y-2">
                <div><dt class="text-slate-400">Present Status</dt><dd>{{ $application->employment_status ?: '—' }}</dd></div>
                <div><dt class="text-slate-400">Present Salary</dt><dd>{{ $application->present_salary ?: '—' }}</dd></div>
            </dl>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-2">Institutions Attended</h2>
            <p class="text-sm whitespace-pre-line">{{ $application->institutions_attended ?: '—' }}</p>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-2">Qualifications</h2>
            <p class="text-sm whitespace-pre-line">{{ $application->qualifications ?: '—' }}</p>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-2">Work Experience</h2>
            <p class="text-sm whitespace-pre-line">{{ $application->work_experience ?: '—' }}</p>
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
                        <p class="font-medium">{{ $referee['name'] ?? '—' }}</p>
                        <p class="text-slate-500">{{ $referee['address'] ?? '—' }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 sm:col-span-2">
            <h2 class="font-semibold mb-3">Documents</h2>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('admin.applications.download', [$application, 'cv']) }}" class="text-blue-800 hover:underline">Download CV</a>
                <a href="{{ route('admin.applications.download', [$application, 'credentials']) }}" class="text-blue-800 hover:underline">Download Credentials</a>
            </div>
        </section>
    </div>
@endsection
