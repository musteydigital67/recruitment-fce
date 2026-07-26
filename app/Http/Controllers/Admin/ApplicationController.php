<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with('position')
            ->when($request->position_id, fn ($q) => $q->where('position_id', $request->position_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('full_name', 'like', '%'.$request->search.'%'))
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
        $request->validate(['status' => ['required', 'in:pending,shortlisted,rejected']]);
        $application->update(['status' => $request->status]);
        return back()->with('status', 'Application status updated.');
    }

    public function download(Application $application, string $type)
    {
        $path = $type === 'cv' ? $application->cv_path : $application->credentials_path;
        abort_unless($path && Storage::disk('local')->exists($path), 404);
        return Storage::disk('local')->download($path);
    }
}
