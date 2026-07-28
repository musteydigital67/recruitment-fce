<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with('position')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('applications.dashboard', compact('applications'));
    }
}
