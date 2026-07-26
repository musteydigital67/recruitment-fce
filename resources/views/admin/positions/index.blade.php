@extends('layouts.admin')

@section('title', 'Positions')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Positions</h1>
        <a href="{{ route('admin.positions.create') }}" class="bg-blue-900 text-white rounded-md px-4 py-2 text-sm">+ New Position</a>
    </div>

    <div class="bg-white border rounded-lg divide-y">
        @foreach ($positions as $position)
            <div class="flex items-center justify-between px-4 py-3">
                <div>
                    <p class="font-medium">{{ $position->title }}</p>
                    <p class="text-sm text-slate-500">
                        {{ $position->grade }} &middot; {{ $position->department }} &middot;
                        {{ $position->applications_count }} application(s)
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-1 rounded {{ $position->is_open ? 'bg-green-50 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $position->is_open ? 'Open' : 'Closed' }}
                    </span>
                    <a href="{{ route('admin.positions.edit', $position) }}" class="text-sm text-blue-800 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.positions.destroy', $position) }}" onsubmit="return confirm('Delete this position?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $positions->links() }}</div>
@endsection
