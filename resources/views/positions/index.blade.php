@extends('layouts.app')

@section('title', 'Vacancies')

@section('content')
    <h1 class="text-2xl font-bold mb-1">Current Vacancies</h1>
    <p class="text-slate-600 mb-6">Applications are invited from suitably qualified candidates for Academic and Non-Academic positions.</p>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..."
               class="border rounded-md px-3 py-2 text-sm w-64">
        <select name="category" class="border rounded-md px-3 py-2 text-sm">
            <option value="">All categories</option>
            <option value="academic" @selected(request('category') === 'academic')>Academic</option>
            <option value="non_academic" @selected(request('category') === 'non_academic')>Non-Academic</option>
        </select>
        <button class="bg-blue-900 text-white rounded-md px-4 py-2 text-sm">Filter</button>
    </form>

    <div class="grid gap-4">
        @forelse ($positions as $position)
            <a href="{{ route('positions.show', $position) }}"
               class="block bg-white border rounded-lg p-4 hover:border-blue-400 transition">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-semibold text-slate-900">{{ $position->title }}</h2>
                        <p class="text-sm text-slate-500">{{ $position->department }}</p>
                    </div>
                    <span class="text-xs font-medium bg-blue-50 text-blue-800 px-2 py-1 rounded">
                        {{ $position->grade }}
                    </span>
                </div>
                <span class="inline-block mt-2 text-xs uppercase tracking-wide text-slate-400">
                    {{ $position->category === 'academic' ? 'Academic Staff' : 'Non-Academic Staff' }}
                </span>
            </a>
        @empty
            <p class="text-slate-500">No open vacancies at this time.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $positions->links() }}
    </div>
@endsection
