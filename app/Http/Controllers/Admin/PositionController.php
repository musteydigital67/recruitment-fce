<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::withCount('applications')->orderByDesc('id')->paginate(20);
        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.positions.form', ['position' => new Position()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Position::create($data);
        return redirect()->route('admin.positions.index')->with('status', 'Position created.');
    }

    public function edit(Position $position)
    {
        return view('admin.positions.form', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $data = $this->validated($request);
        $position->update($data);
        return redirect()->route('admin.positions.index')->with('status', 'Position updated.');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('status', 'Position deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:100'],
            'category' => ['required', 'in:academic,non_academic'],
            'department' => ['nullable', 'string', 'max:255'],
            'requirements' => ['required', 'string'],
            'slots' => ['required', 'integer', 'min:1'],
            'is_open' => ['nullable', 'boolean'],
            'closes_at' => ['nullable', 'date'],
        ]);

        $data['is_open'] = $request->boolean('is_open');

        return $data;
    }
}
