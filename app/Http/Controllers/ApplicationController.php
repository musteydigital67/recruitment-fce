<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationReceived;
use App\Models\Application;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function create(Position $position)
    {
        abort_unless($position->is_open, 404);

        if (Application::where('user_id', request()->user()->id)->exists()) {
            return redirect()
                ->route('positions.show', $position)
                ->with('error', 'You have already submitted an application. Only one application is allowed per applicant.');
        }

        return view('applications.create', compact('position'));
    }

    public function store(Request $request, Position $position)
    {
        abort_unless($position->is_open, 404);

        $maxPostSize = $this->convertToBytes(ini_get('post_max_size'));
        $contentLength = (int) $request->server('CONTENT_LENGTH');

        if ($contentLength > $maxPostSize) {
            return redirect()
                ->route('applications.create', $position)
                ->withInput()
                ->with('error', 'Your upload was too large. Please reduce file sizes and try again.');
        }

        if (Application::where('user_id', $request->user()->id)->exists()) {
            return redirect()
                ->route('positions.show', $position)
                ->with('error', 'You have already submitted an application. Only one application is allowed per applicant.');
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'marital_status' => ['nullable', 'in:Single,Married,Divorced,Widowed'],

            'next_of_kin_name' => ['nullable', 'string', 'max:255'],
            'next_of_kin_address' => ['nullable', 'string', 'max:255'],
            'next_of_kin_phone' => ['nullable', 'string', 'max:50'],
            'number_of_children' => ['nullable', 'integer', 'min:0'],
            'children_ages' => ['nullable', 'string', 'max:255'],

            'nationality' => ['nullable', 'string', 'max:100'],
            'state_of_origin' => ['nullable', 'string', 'max:100'],
            'lga_of_origin' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'confirmed'],
            'permanent_address' => ['nullable', 'string', 'max:500'],

            'education' => ['nullable', 'array'],
            'education.*.institution' => ['nullable', 'string', 'max:255'],
            'education.*.qualification' => ['nullable', 'string', 'max:255'],
            'education.*.start_year' => ['nullable', 'string', 'max:10'],
            'education.*.end_year' => ['nullable', 'string', 'max:10'],
            'professional_qualifications' => ['nullable', 'string'],
            'work_experiences' => ['nullable', 'array'],
            'work_experiences.*.employer' => ['nullable', 'string', 'max:255'],
            'work_experiences.*.position' => ['nullable', 'string', 'max:255'],
            'work_experiences.*.start_date' => ['nullable', 'string', 'max:50'],
            'work_experiences.*.end_date' => ['nullable', 'string', 'max:50'],
            'work_experiences.*.description' => ['nullable', 'string'],
            'employment_status' => ['nullable', 'string', 'max:255'],
            'present_salary' => ['nullable', 'string', 'max:255'],

            'publications' => ['nullable', 'string'],
            'extra_curricular' => ['nullable', 'string'],
            'additional_info' => ['nullable', 'string'],

            'referees' => ['required', 'array', 'size:3'],
            'referees.*.name' => ['required', 'string', 'max:255'],
            'referees.*.address' => ['required', 'string', 'max:255'],
            'referees.*.phone' => ['required', 'string', 'max:50'],

            'passport' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'birth_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'olevel_result' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'degree' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'lga_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'nysc_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'masters_certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'professional_certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'nin' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'primary_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'trcn_certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $data['position_id'] = $position->id;

        $data['education'] = collect($data['education'] ?? [])
            ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
            ->values()
            ->all();

        $data['work_experiences'] = collect($data['work_experiences'] ?? [])
            ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
            ->values()
            ->all();
        $documentFields = [
            'passport', 'birth_certificate', 'olevel_result', 'degree',
            'lga_certificate', 'nysc_certificate', 'masters_certificate', 'professional_certificate',
            'nin', 'primary_certificate', 'trcn_certificate',
        ];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field . '_path'] = $request->file($field)->store('applications/' . $field, 'local');
            }
            unset($data[$field]);
        }

        $data['user_id'] = $request->user()->id;
        $application = Application::create($data);

        try {
            Mail::to($application->email)->send(new ApplicationReceived($application));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('positions.show', $position)
            ->with('status', 'Your application has been submitted successfully. You will be contacted if shortlisted.');
    }

    private function convertToBytes(string $value): int
    {
        $value = trim($value);
        $unit = strtolower(substr($value, -1));
        $number = (int) $value;

        return match ($unit) {
            'g' => $number * 1024 * 1024 * 1024,
            'm' => $number * 1024 * 1024,
            'k' => $number * 1024,
            default => (int) $value,
        };
    }
}

