@extends('layouts.app')

@section('title', $position->title)

@section('content')
    <a href="{{ route('positions.index') }}" class="text-sm text-blue-800 hover:underline">&larr; Back to vacancies</a>

    <div class="bg-white border rounded-lg p-6 mt-4">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">{{ $position->title }}</h1>
                <p class="text-slate-500">{{ $position->department }}</p>
            </div>
            <span class="text-sm font-medium bg-blue-50 text-blue-800 px-3 py-1 rounded">
                {{ $position->grade }}
            </span>
        </div>

        <h2 class="font-semibold mt-6 mb-2">Requirements</h2>
        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $position->requirements }}</p>

        @if ($position->closes_at)
            <p class="text-sm text-slate-500 mt-4">Applications close: {{ $position->closes_at->format('d M Y') }}</p>
        @endif

        @if ($position->is_open)
            <a href="{{ route('applications.create', $position) }}"
               class="inline-block mt-6 bg-blue-900 text-white rounded-md px-5 py-2.5 text-sm font-medium hover:bg-blue-800">
                Apply for this position
            </a>
        @else
            <p class="mt-6 text-sm text-red-600">This position is no longer accepting applications.</p>
        @endif
    </div>
@endsection
