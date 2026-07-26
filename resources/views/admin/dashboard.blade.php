@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid sm:grid-cols-5 gap-4 mb-8">
        @foreach ([
            'Positions' => $stats['positions'],
            'Open Positions' => $stats['open_positions'],
            'Applications' => $stats['applications'],
            'Pending' => $stats['pending'],
            'Shortlisted' => $stats['shortlisted'],
        ] as $label => $value)
            <div class="bg-white border rounded-lg p-4">
                <p class="text-xs uppercase text-slate-400">{{ $label }}</p>
                <p class="text-2xl font-bold mt-1">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <h2 class="font-semibold mb-3">Recent Applications</h2>
    <div class="bg-white border rounded-lg divide-y">
        @forelse ($recent as $application)
            <a href="{{ route('admin.applications.show', $application) }}" class="flex items-center justify-between px-4 py-3 hover:bg-slate-50">
                <div>
                    <p class="font-medium">{{ $application->full_name }}</p>
                    <p class="text-sm text-slate-500">{{ $application->position->title }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded bg-slate-100 capitalize">{{ $application->status }}</span>
            </a>
        @empty
            <p class="px-4 py-3 text-sm text-slate-500">No applications yet.</p>
        @endforelse
    </div>
@endsection
