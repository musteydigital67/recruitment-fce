@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My Applications</h1>

    @if ($applications->isEmpty())
        <div class="bg-white border rounded-lg p-6 text-sm text-slate-500">
            You haven't applied for any positions yet. <a href="{{ route('positions.index') }}" class="text-blue-800 hover:underline">Browse vacancies</a>.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($applications as $application)
                <div class="bg-white border rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $application->position->title }}</p>
                        <p class="text-sm text-slate-500">{{ $application->position->grade }} &middot; Applied {{ $application->created_at->format('d M Y') }}</p>
                    </div>
                    <span class="text-xs font-medium px-3 py-1 rounded-full
                        @class([
                            'bg-yellow-50 text-yellow-700' => $application->status === 'pending',
                            'bg-green-50 text-green-700' => $application->status === 'shortlisted',
                            'bg-red-50 text-red-700' => $application->status === 'rejected',
                        ])">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif
@endsection
