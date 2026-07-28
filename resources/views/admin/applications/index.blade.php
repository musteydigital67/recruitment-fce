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

    <form method="POST" action="{{ route('admin.applications.bulk-status') }}" id="bulk-form">
        @csrf
        @method('PATCH')

        <div class="flex items-center gap-3 mb-3">
            <select name="status" class="border rounded-md px-3 py-2 text-sm">
                <option value="">Bulk action...</option>
                <option value="shortlisted">Mark as Shortlisted</option>
                <option value="pending">Mark as Pending</option>
                <option value="rejected">Mark as Rejected</option>
            </select>
            <button type="submit" class="bg-slate-800 text-white rounded-md px-4 py-2 text-sm">Apply to Selected</button>
            <span class="text-sm text-slate-500" id="selected-count">0 selected</span>
        </div>

        <div class="bg-white border rounded-lg divide-y">
            @forelse ($applications as $application)
                <div class="flex items-center justify-between px-4 py-3 hover:bg-slate-50">
                    <div class="flex items-center gap-3 flex-1">
                        <input type="checkbox" name="application_ids[]" value="{{ $application->id }}" class="bulk-checkbox">
                        <a href="{{ route('admin.applications.show', $application) }}" class="flex-1">
                            <p class="font-medium">{{ $application->full_name }}</p>
                            <p class="text-sm text-slate-500">{{ $application->position->title }} &middot; {{ $application->email }}</p>
                        </a>
                    </div>
                    <span class="text-xs px-2 py-1 rounded bg-slate-100 capitalize">{{ $application->status }}</span>
                </div>
            @empty
                <p class="px-4 py-3 text-sm text-slate-500">No applications found.</p>
            @endforelse
        </div>
    </form>

    <script>
        document.querySelectorAll('.bulk-checkbox').forEach(function (cb) {
            cb.addEventListener('change', function () {
                var count = document.querySelectorAll('.bulk-checkbox:checked').length;
                document.getElementById('selected-count').textContent = count + ' selected';
            });
        });

        document.getElementById('bulk-form').addEventListener('submit', function (e) {
            var count = document.querySelectorAll('.bulk-checkbox:checked').length;
            if (count === 0) {
                e.preventDefault();
                alert('Select at least one application first.');
            }
        });
    </script>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
