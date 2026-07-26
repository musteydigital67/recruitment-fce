@extends('layouts.app')

@section('title', 'Apply - '.$position->title)

@section('content')
    <a href="{{ route('positions.show', $position) }}" class="text-sm text-blue-800 hover:underline">&larr; {{ $position->title }}</a>

    <h1 class="text-2xl font-bold mt-4 mb-1">Application Form</h1>
    <p class="text-slate-600 mb-6">Applying for: <strong>{{ $position->title }}</strong> ({{ $position->grade }})</p>

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
            <p class="font-medium mb-1">Please correct the following:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('applications.store', $position) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">1. Personal Information</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name (Surname last, CAPITALS) *</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Marital Status</label>
                    <input type="text" name="marital_status" value="{{ old('marital_status') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Place of Birth</label>
                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Nationality</label>
                    <input type="text" name="nationality" value="{{ old('nationality', 'Nigerian') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">State of Origin</label>
                    <input type="text" name="state_of_origin" value="{{ old('state_of_origin') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Local Government Origin</label>
                    <input type="text" name="lga_of_origin" value="{{ old('lga_of_origin') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">2. Contact Details</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Mobile Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Permanent Home Address</label>
                    <textarea name="permanent_address" rows="2" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('permanent_address') }}</textarea>
                </div>
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">3. Next of Kin</h2>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="next_of_kin_name" value="{{ old('next_of_kin_name') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <input type="text" name="next_of_kin_address" value="{{ old('next_of_kin_address') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone Number</label>
                    <input type="text" name="next_of_kin_phone" value="{{ old('next_of_kin_phone') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Number of Children</label>
                    <input type="number" min="0" name="number_of_children" value="{{ old('number_of_children', 0) }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Ages of Children</label>
                    <input type="text" name="children_ages" value="{{ old('children_ages') }}" placeholder="e.g. 5, 8, 12" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">4. Education &amp; Experience</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Institutions Attended (with dates)</label>
                <textarea name="institutions_attended" rows="3" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('institutions_attended') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Academic &amp; Professional Qualifications (with dates)</label>
                <textarea name="qualifications" rows="3" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('qualifications') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Work Experience (with dates, former and present posts)</label>
                <textarea name="work_experience" rows="3" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('work_experience') }}</textarea>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Present Employment Status</label>
                    <input type="text" name="employment_status" value="{{ old('employment_status') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Present Salary</label>
                    <input type="text" name="present_salary" value="{{ old('present_salary') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">5. Additional Information</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Publications (if applicable)</label>
                <textarea name="publications" rows="2" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('publications') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Extra-Curricular Activities</label>
                <textarea name="extra_curricular" rows="2" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('extra_curricular') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Any Other Relevant Information</label>
                <textarea name="additional_info" rows="2" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('additional_info') }}</textarea>
            </div>
        </section>

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">6. Referees (3 required)</h2>
            @for ($i = 0; $i < 3; $i++)
                <div class="grid sm:grid-cols-2 gap-4 border-t pt-4 first:border-t-0 first:pt-0">
                    <div>
                        <label class="block text-sm font-medium mb-1">Referee {{ $i + 1 }} Name *</label>
                        <input type="text" name="referees[{{ $i }}][name]" value="{{ old('referees.'.$i.'.name') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Referee {{ $i + 1 }} Address *</label>
                        <input type="text" name="referees[{{ $i }}][address]" value="{{ old('referees.'.$i.'.address') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                    </div>
                </div>
            @endfor
        </section>

        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">7. Documents</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Curriculum Vitae (PDF/DOC, max 5MB) *</label>
                <input type="file" name="cv" required accept=".pdf,.doc,.docx" class="w-full text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Credentials / Certificates (PDF/DOC, max 10MB) *</label>
                <input type="file" name="credentials" required accept=".pdf,.doc,.docx" class="w-full text-sm">
            </div>
        </section>

        <button type="submit" class="bg-blue-900 text-white rounded-md px-6 py-3 text-sm font-medium hover:bg-blue-800">
            Submit Application
        </button>
    </form>
@endsection
