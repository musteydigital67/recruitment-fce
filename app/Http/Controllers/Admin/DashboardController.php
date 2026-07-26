<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Position;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'positions' => Position::count(),
            'open_positions' => Position::open()->count(),
            'applications' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'shortlisted' => Application::where('status', 'shortlisted')->count(),
        ];

        $recent = Application::with('position')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
