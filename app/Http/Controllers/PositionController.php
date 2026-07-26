<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $positions = Position::open()
            ->when($request->category, fn ($q) => $q->where('category', $request->category))
            ->when($request->search, fn ($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->orderBy('category')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('positions.index', compact('positions'));
    }

    public function show(Position $position)
    {
        return view('positions.show', compact('position'));
    }
}
