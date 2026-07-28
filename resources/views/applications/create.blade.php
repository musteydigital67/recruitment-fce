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

    <div id="wizard-progress" class="mb-6 flex items-center justify-between">
        @foreach (['Personal', 'Contact', 'Next of Kin', 'Education', 'Additional', 'Referees', 'Documents'] as $idx => $label)
            <div class="flex-1 flex flex-col items-center relative">
                @if ($idx > 0)
                    <div class="absolute top-3 right-1/2 w-full h-0.5 bg-slate-200 step-line" data-line="{{ $idx }}"></div>
                @endif
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-medium border-2 border-slate-200 bg-white text-slate-400 relative z-10 step-dot" data-dot="{{ $idx + 1 }}">
                    {{ $idx + 1 }}
                </div>
                <span class="text-xs text-slate-400 mt-1 step-label" data-label="{{ $idx + 1 }}">{{ $label }}</span>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('applications.store', $position) }}" enctype="multipart/form-data" id="application-form">
        @csrf

        <div class="wizard-step" data-step="1">
        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">1. Personal Information</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Surname *</label>
                    <input type="text" name="surname" value="{{ old('surname') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Marital Status</label>
                    <select name="marital_status" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">-- Select --</option>
                        @foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $status)
                            <option value="{{ $status }}" @selected(old('marital_status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
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
                    <select id="state_of_origin" name="state_of_origin" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">-- Select State --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Local Government Origin</label>
                    <select id="lga_of_origin" name="lga_of_origin" class="w-full border rounded-md px-3 py-2 text-sm">
                        <option value="">-- Select State First --</option>
                    </select>
                </div>
            </div>
        </section>
        </div>

        <div class="wizard-step" data-step="2">
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
                <div>
                    <label class="block text-sm font-medium mb-1">Confirm Email *</label>
                    <input type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" required class="w-full border rounded-md px-3 py-2 text-sm" onpaste="return false" autocomplete="off">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Permanent Home Address</label>
                    <textarea name="permanent_address" rows="2" class="w-full border rounded-md px-3 py-2 text-sm">{{ old('permanent_address') }}</textarea>
                </div>
            </div>
        </section>
        </div>

        <div class="wizard-step" data-step="3">
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
        </div>

        <div class="wizard-step" data-step="4">
        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">4. Education &amp; Experience</h2>

            <div>
                <label class="block text-sm font-medium mb-2">Education</label>
                <div id="education-rows" class="space-y-3"></div>
                <button type="button" id="add-education" class="mt-2 text-sm text-blue-800 hover:underline">+ Add another institution</button>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Professional Qualifications / Certifications</label>
                <textarea name="professional_qualifications" rows="2" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="e.g. NYSC Certificate, professional body memberships">{{ old('professional_qualifications') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Work Experience</label>
                <div id="work-rows" class="space-y-3"></div>
                <button type="button" id="add-work" class="mt-2 text-sm text-blue-800 hover:underline">+ Add another work experience</button>
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
        </div>

        <div class="wizard-step" data-step="5">
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
        </div>

        <div class="wizard-step" data-step="6">
        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">6. Referees (3 required)</h2>
            @for ($i = 0; $i < 3; $i++)
                <div class="grid sm:grid-cols-3 gap-4 border-t pt-4 first:border-t-0 first:pt-0">
                    <div>
                        <label class="block text-sm font-medium mb-1">Referee {{ $i + 1 }} Name *</label>
                        <input type="text" name="referees[{{ $i }}][name]" value="{{ old('referees.'.$i.'.name') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Referee {{ $i + 1 }} Address *</label>
                        <input type="text" name="referees[{{ $i }}][address]" value="{{ old('referees.'.$i.'.address') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Referee {{ $i + 1 }} Phone *</label>
                        <input type="text" name="referees[{{ $i }}][phone]" value="{{ old('referees.'.$i.'.phone') }}" required class="w-full border rounded-md px-3 py-2 text-sm">
                    </div>
                </div>
            @endfor
        </section>
        </div>

        <div class="wizard-step" data-step="7">
        <section class="bg-white border rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-slate-900">7. Documents</h2>

            @php
                $documentSlots = [
                    ['field' => 'passport', 'label' => 'Passport Photograph', 'desc' => 'Upload a recent passport photograph.', 'required' => true, 'accept' => '.jpg,.jpeg,.png'],
                    ['field' => 'birth_certificate', 'label' => 'Birth Certificate', 'desc' => 'Birth certificate or declaration of age.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'olevel_result', 'label' => "O'Level Result", 'desc' => 'WAEC / NECO / NABTEB Result.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'degree', 'label' => 'First Degree', 'desc' => 'Degree/HND/ND/NCE qualification.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'lga_certificate', 'label' => 'Local Government Identification', 'desc' => 'Certificate of Local Government Origin.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'nysc_certificate', 'label' => 'NYSC Certificate', 'desc' => 'National Youth Service Corps Certificate.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'masters_certificate', 'label' => "Master's Degree", 'desc' => "Master's Degree (if applicable).", 'required' => false, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'professional_certificate', 'label' => 'Professional Certificate', 'desc' => 'Certificate of Professional Qualification.', 'required' => false, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'nin', 'label' => 'National Identification Number (NIN)', 'desc' => 'NIN slip or National ID card.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'primary_certificate', 'label' => 'Primary School Certificate', 'desc' => 'First School Leaving Certificate.', 'required' => true, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    ['field' => 'trcn_certificate', 'label' => 'TRCN Certificate', 'desc' => 'Teachers Registration Council of Nigeria certificate (for teaching positions).', 'required' => false, 'accept' => '.pdf,.jpg,.jpeg,.png'],
                ];
            @endphp

            <div class="space-y-3">
                @foreach ($documentSlots as $slot)
                    <div class="border rounded-lg p-4 flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-slate-900">{{ $slot['label'] }}</span>
                                @if ($slot['required'])
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-200">Required</span>
                                @else
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 border border-slate-200">Optional</span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500 mt-0.5">{{ $slot['desc'] }}</p>
                            <input type="file" name="{{ $slot['field'] }}" @if($slot['required']) required @endif accept="{{ $slot['accept'] }}" class="mt-2 w-full text-sm">
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        </div>

        <div class="flex justify-between items-center mt-6">
            <button type="button" id="wizard-back" class="border border-slate-300 rounded-md px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 invisible">
                Back
            </button>
            <button type="button" id="wizard-next" class="bg-blue-900 text-white rounded-md px-6 py-3 text-sm font-medium hover:bg-blue-800">
                Next
            </button>
            <button type="submit" id="wizard-submit" class="bg-blue-900 text-white rounded-md px-6 py-3 text-sm font-medium hover:bg-blue-800 hidden">
                Submit Application
            </button>
        </div>
    </form>

    <script src="{{ asset('js/nigeria-states-lgas.js') }}"></script>
    <script>
        (function () {
            function setupCascade(stateId, lgaId, oldState, oldLga) {
                var stateSelect = document.getElementById(stateId);
                var lgaSelect = document.getElementById(lgaId);

                Object.keys(window.NIGERIA_STATES_LGAS).sort().forEach(function (state) {
                    var opt = document.createElement('option');
                    opt.value = state;
                    opt.textContent = state;
                    if (state === oldState) opt.selected = true;
                    stateSelect.appendChild(opt);
                });

                function populateLgas(state) {
                    lgaSelect.innerHTML = '';
                    var placeholder = document.createElement('option');
                    placeholder.value = '';
                    placeholder.textContent = state ? '-- Select LGA --' : '-- Select State First --';
                    lgaSelect.appendChild(placeholder);

                    if (!state || !window.NIGERIA_STATES_LGAS[state]) return;

                    window.NIGERIA_STATES_LGAS[state].forEach(function (lga) {
                        var opt = document.createElement('option');
                        opt.value = lga;
                        opt.textContent = lga;
                        if (lga === oldLga) opt.selected = true;
                        lgaSelect.appendChild(opt);
                    });
                }

                stateSelect.addEventListener('change', function () {
                    populateLgas(this.value);
                });

                if (oldState) populateLgas(oldState);
            }

            setupCascade('state_of_origin', 'lga_of_origin', @json(old('state_of_origin')), @json(old('lga_of_origin')));
        })();

        (function () {
            var oldEducation = @json(old('education', []));
            var oldWork = @json(old('work_experiences', []));

            function makeEducationRow(index, values) {
                values = values || {};
                var row = document.createElement('div');
                row.className = 'border rounded-md p-3 relative education-row';
                row.innerHTML =
                    '<button type="button" class="remove-row absolute top-2 right-2 text-xs text-red-600 hover:underline">Remove</button>' +
                    '<div class="grid sm:grid-cols-4 gap-3 pr-16">' +
                    '<div><label class="block text-xs text-slate-500 mb-1">Institution</label>' +
                    '<input type="text" name="education[' + index + '][institution]" value="' + (values.institution || '') + '" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '<div><label class="block text-xs text-slate-500 mb-1">Qualification</label>' +
                    '<input type="text" name="education[' + index + '][qualification]" value="' + (values.qualification || '') + '" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '<div><label class="block text-xs text-slate-500 mb-1">Start Year</label>' +
                    '<input type="text" name="education[' + index + '][start_year]" value="' + (values.start_year || '') + '" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '<div><label class="block text-xs text-slate-500 mb-1">End Year</label>' +
                    '<input type="text" name="education[' + index + '][end_year]" value="' + (values.end_year || '') + '" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '</div>';
                return row;
            }

            function makeWorkRow(index, values) {
                values = values || {};
                var row = document.createElement('div');
                row.className = 'border rounded-md p-3 relative work-row';
                row.innerHTML =
                    '<button type="button" class="remove-row absolute top-2 right-2 text-xs text-red-600 hover:underline">Remove</button>' +
                    '<div class="grid sm:grid-cols-2 gap-3 pr-16 mb-3">' +
                    '<div><label class="block text-xs text-slate-500 mb-1">Employer</label>' +
                    '<input type="text" name="work_experiences[' + index + '][employer]" value="' + (values.employer || '') + '" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '<div><label class="block text-xs text-slate-500 mb-1">Position Held</label>' +
                    '<input type="text" name="work_experiences[' + index + '][position]" value="' + (values.position || '') + '" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '<div><label class="block text-xs text-slate-500 mb-1">Start Date</label>' +
                    '<input type="text" name="work_experiences[' + index + '][start_date]" value="' + (values.start_date || '') + '" placeholder="e.g. Jan 2020" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '<div><label class="block text-xs text-slate-500 mb-1">End Date</label>' +
                    '<input type="text" name="work_experiences[' + index + '][end_date]" value="' + (values.end_date || '') + '" placeholder="e.g. Present" class="w-full border rounded-md px-3 py-2 text-sm"></div>' +
                    '</div>' +
                    '<label class="block text-xs text-slate-500 mb-1">Description</label>' +
                    '<textarea name="work_experiences[' + index + '][description]" rows="2" class="w-full border rounded-md px-3 py-2 text-sm">' + (values.description || '') + '</textarea>';
                return row;
            }

            function setupRepeater(containerId, addBtnId, rowFactory, oldValues) {
                var container = document.getElementById(containerId);
                var addBtn = document.getElementById(addBtnId);
                var index = 0;

                function addRow(values) {
                    var row = rowFactory(index, values);
                    index++;
                    container.appendChild(row);
                    row.querySelector('.remove-row').addEventListener('click', function () {
                        if (container.children.length > 1) {
                            row.remove();
                        }
                    });
                }

                if (oldValues && oldValues.length) {
                    oldValues.forEach(function (v) { addRow(v); });
                } else {
                    addRow({});
                }

                addBtn.addEventListener('click', function () { addRow({}); });
            }

            setupRepeater('education-rows', 'add-education', makeEducationRow, oldEducation);
            setupRepeater('work-rows', 'add-work', makeWorkRow, oldWork);
        })();

        (function () {
            var totalSteps = 7;
            var currentStep = 1;
            var form = document.getElementById('application-form');
            var steps = document.querySelectorAll('.wizard-step');
            var backBtn = document.getElementById('wizard-back');
            var nextBtn = document.getElementById('wizard-next');
            var submitBtn = document.getElementById('wizard-submit');

            steps.forEach(function (step) {
                step.querySelectorAll('[required]').forEach(function (el) {
                    el.classList.add('wizard-required');
                });
            });

            function setStepRequiredState(stepNumber, isActive) {
                var step = document.querySelector('.wizard-step[data-step="' + stepNumber + '"]');
                if (!step) return;
                step.querySelectorAll('.wizard-required').forEach(function (el) {
                    if (isActive) {
                        el.setAttribute('required', 'required');
                    } else {
                        el.removeAttribute('required');
                    }
                });
            }

            function updateProgress() {
                for (var i = 1; i <= totalSteps; i++) {
                    var dot = document.querySelector('.step-dot[data-dot="' + i + '"]');
                    var label = document.querySelector('.step-label[data-label="' + i + '"]');
                    var line = document.querySelector('.step-line[data-line="' + (i - 1) + '"]');

                    if (i < currentStep) {
                        dot.classList.remove('bg-white', 'text-slate-400', 'border-slate-200');
                        dot.classList.add('bg-blue-900', 'text-white', 'border-blue-900');
                        label.classList.remove('text-slate-400');
                        label.classList.add('text-blue-900');
                        if (line) { line.classList.remove('bg-slate-200'); line.classList.add('bg-blue-900'); }
                    } else if (i === currentStep) {
                        dot.classList.remove('bg-white', 'text-slate-400', 'bg-blue-900', 'text-white');
                        dot.classList.add('border-blue-900', 'text-blue-900');
                        label.classList.remove('text-slate-400');
                        label.classList.add('text-blue-900', 'font-medium');
                        if (line) { line.classList.remove('bg-slate-200'); line.classList.add('bg-blue-900'); }
                    } else {
                        dot.classList.remove('bg-blue-900', 'text-white', 'text-blue-900', 'border-blue-900');
                        dot.classList.add('bg-white', 'text-slate-400', 'border-slate-200');
                        label.classList.remove('text-blue-900', 'font-medium');
                        label.classList.add('text-slate-400');
                        if (line) { line.classList.remove('bg-blue-900'); line.classList.add('bg-slate-200'); }
                    }
                }
            }

            function showStep(stepNumber) {
                steps.forEach(function (step) {
                    var stepNum = parseInt(step.getAttribute('data-step'), 10);
                    if (stepNum === stepNumber) {
                        step.style.display = '';
                        setStepRequiredState(stepNum, true);
                    } else {
                        step.style.display = 'none';
                        setStepRequiredState(stepNum, false);
                    }
                });

                backBtn.classList.toggle('invisible', stepNumber === 1);
                nextBtn.classList.toggle('hidden', stepNumber === totalSteps);
                submitBtn.classList.toggle('hidden', stepNumber !== totalSteps);

                updateProgress();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            nextBtn.addEventListener('click', function () {
                if (!form.reportValidity()) {
                    return;
                }
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            backBtn.addEventListener('click', function () {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            @if ($errors->any())
                var errorFieldNames = @json(array_keys($errors->toArray()));
                var stepFieldPrefixes = {
                    1: ['first_name', 'middle_name', 'surname', 'marital_status', 'date_of_birth', 'nationality', 'state_of_origin', 'lga_of_origin'],
                    2: ['phone', 'email', 'permanent_address'],
                    3: ['next_of_kin_name', 'next_of_kin_address', 'next_of_kin_phone', 'number_of_children', 'children_ages'],
                    4: ['education', 'professional_qualifications', 'work_experiences', 'employment_status', 'present_salary'],
                    5: ['publications', 'extra_curricular', 'additional_info'],
                    6: ['referees'],
                    7: ['passport', 'birth_certificate', 'olevel_result', 'degree', 'lga_certificate', 'nysc_certificate', 'masters_certificate', 'professional_certificate', 'nin', 'primary_certificate', 'trcn_certificate']
                };
                var firstErrorStep = totalSteps;
                for (var step in stepFieldPrefixes) {
                    var prefixes = stepFieldPrefixes[step];
                    var hasError = errorFieldNames.some(function (name) {
                        return prefixes.some(function (prefix) { return name.indexOf(prefix) === 0; });
                    });
                    if (hasError) {
                        firstErrorStep = Math.min(firstErrorStep, parseInt(step, 10));
                    }
                }
                currentStep = firstErrorStep;
            @endif

            showStep(currentStep);
        })();
    </script>
@endsection