@extends('layouts.admin')

@section('title', 'Applications')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Applications</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..."
               class="border rounded-md px-3 py-2 text-sm w-64">
        <select name="status" class="border rounded-md px-3 py-2 text-sm">
            <option value="">All statuses</option>
            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
            <option value="shortlisted" @selected(request('status') === 'shortlisted')>Shortlisted</option>
            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
        </select>
        <button class="bg-blue-900 text-white rounded-md px-4 py-2 text-sm">Filter</button>
    </form>

    <div class="bg-white border rounded-lg divide-y">
        @forelse ($applications as $application)
            <a href="{{ route('admin.applications.show', $application) }}" class="flex items-center justify-between px-4 py-3 hover:bg-slate-50">
                <div>
                    <p class="font-medium">{{ $application->full_name }}</p>
                    <p class="text-sm text-slate-500">{{ $application->position->title }} &middot; {{ $application->email }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded bg-slate-100 capitalize">{{ $application->status }}</span>
            </a>
        @empty
            <p class="px-4 py-3 text-sm text-slate-500">No applications found.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
