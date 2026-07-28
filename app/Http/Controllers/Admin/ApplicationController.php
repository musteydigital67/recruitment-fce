<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationStatusUpdated;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with('position')
            ->when($request->position_id, fn ($q) => $q->where('position_id', $request->position_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('first_name', 'like', '%'.$request->search.'%')
                    ->orWhere('middle_name', 'like', '%'.$request->search.'%')
                    ->orWhere('surname', 'like', '%'.$request->search.'%');
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        $application->load('position');
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,shortlisted,interview,rejected'],
            'interview_date' => ['required_if:status,interview', 'nullable', 'date'],
            'interview_time' => ['required_if:status,interview', 'nullable'],
            'interview_location' => ['required_if:status,interview', 'nullable', 'string', 'max:255'],
            'interview_notes' => ['nullable', 'string'],
        ]);

        if ($data['status'] !== 'interview') {
            $data['interview_date'] = null;
            $data['interview_time'] = null;
            $data['interview_location'] = null;
            $data['interview_notes'] = null;
        }

        $application->update($data);

        try {
            Mail::to($application->email)->send(new ApplicationStatusUpdated($application));
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('status', 'Application status updated.');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $data = $request->validate([
            'application_ids' => ['required', 'array', 'min:1'],
            'application_ids.*' => ['exists:applications,id'],
            'status' => ['required', 'in:pending,shortlisted,rejected'],
        ]);

        $applications = Application::whereIn('id', $data['application_ids'])->get();

        foreach ($applications as $application) {
            $application->update([
                'status' => $data['status'],
                'interview_date' => null,
                'interview_time' => null,
                'interview_location' => null,
                'interview_notes' => null,
            ]);

            try {
                Mail::to($application->email)->send(new ApplicationStatusUpdated($application));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return back()->with('status', count($applications).' application(s) updated.');
    }

    public function download(Application $application, string $type)
    {
        $validTypes = [
            'passport', 'birth_certificate', 'olevel_result', 'degree',
            'lga_certificate', 'nysc_certificate', 'masters_certificate', 'professional_certificate',
            'nin', 'primary_certificate', 'trcn_certificate',
        ];

        abort_unless(in_array($type, $validTypes), 404);

        $path = $application->{$type . '_path'};
        abort_unless($path && Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    }
}
