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

        return view('applications.create', compact('position'));
    }

    public function store(Request $request, Position $position)
    {
        abort_unless($position->is_open, 404);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'place_of_birth' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'marital_status' => ['nullable', 'string', 'max:50'],

            'next_of_kin_name' => ['nullable', 'string', 'max:255'],
            'next_of_kin_address' => ['nullable', 'string', 'max:255'],
            'next_of_kin_phone' => ['nullable', 'string', 'max:50'],
            'number_of_children' => ['nullable', 'integer', 'min:0'],
            'children_ages' => ['nullable', 'string', 'max:255'],

            'nationality' => ['nullable', 'string', 'max:100'],
            'state_of_origin' => ['nullable', 'string', 'max:100'],
            'lga_of_origin' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'permanent_address' => ['nullable', 'string', 'max:500'],

            'institutions_attended' => ['nullable', 'string'],
            'qualifications' => ['nullable', 'string'],
            'work_experience' => ['nullable', 'string'],
            'employment_status' => ['nullable', 'string', 'max:255'],
            'present_salary' => ['nullable', 'string', 'max:255'],

            'publications' => ['nullable', 'string'],
            'extra_curricular' => ['nullable', 'string'],
            'additional_info' => ['nullable', 'string'],

            'referees' => ['required', 'array', 'size:3'],
            'referees.*.name' => ['required', 'string', 'max:255'],
            'referees.*.address' => ['required', 'string', 'max:255'],

            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'credentials' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $data['position_id'] = $position->id;
        $data['cv_path'] = $request->file('cv')->store('applications/cv', 'local');
        $data['credentials_path'] = $request->file('credentials')->store('applications/credentials', 'local');

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
}
