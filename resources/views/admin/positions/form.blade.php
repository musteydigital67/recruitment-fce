@extends('layouts.admin')

@section('title', $position->exists ? 'Edit Position' : 'New Position')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $position->exists ? 'Edit Position' : 'New Position' }}</h1>

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $position->exists ? route('admin.positions.update', $position) : route('admin.positions.store') }}"
          class="bg-white border rounded-lg p-6 space-y-4 max-w-2xl">
        @csrf
        @if ($position->exists) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $position->title) }}" required class="w-full border rounded-md px-3 py-2 text-sm">
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Grade / Level</label>
                <input type="text" name="grade" value="{{ old('grade', $position->grade) }}" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Category *</label>
                <select name="category" required class="w-full border rounded-md px-3 py-2 text-sm">
                    <option value="academic" @selected(old('category', $position->category) === 'academic')>Academic</option>
                    <option value="non_academic" @selected(old('category', $position->category) === 'non_academic')>Non-Academic</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Department / School</label>
            <input type="text" name="department" value="{{ old('department', $position->department) }}" class="w-full border rounded-md px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Requirements *</label>
            <textarea name="requirements" rows="4" required class="w-full border rounded-md px-3 py-2 text-sm">{{ old('requirements', $position->requirements) }}</textarea>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Slots</label>
                <input type="number" min="1" name="slots" value="{{ old('slots', $position->slots ?? 1) }}" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Closes At</label>
                <input type="date" name="closes_at" value="{{ old('closes_at', optional($position->closes_at)->format('Y-m-d')) }}" class="w-full border rounded-md px-3 py-2 text-sm">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $position->is_open ?? true))>
            Open for applications
        </label>

        <button class="bg-blue-900 text-white rounded-md px-5 py-2.5 text-sm font-medium hover:bg-blue-800">
            {{ $position->exists ? 'Save Changes' : 'Create Position' }}
        </button>
    </form>
@endsection
