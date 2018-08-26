<?php

namespace App\Http\Controllers\Root;

use Notify;
use App\{Position};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionsController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('level')->get();

        return view('root.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('root.positions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $position = new Position;
        $position->name = $request->input('name');
        $position->description = $request->input('description');

        if ($position->save()) {
            Notify::success('Position created.', 'Success!');

            return redirect()->route('root.positions.index');
        }

        Notify::warning('Cannot create the position.', 'Warning!');

        return redirect()->route('root.positions.index');
    }

    public function edit(Request $request, Position $position)
    {
        return view('root.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $position->name = $request->input('name');
        $position->description = $request->input('description');

        if ($position->save()) {
            Notify::success('Position updated.', 'Success!');

            return redirect()->route('root.positions.index');
        }

        Notify::warning('Cannot update the position.', 'Warning!');

        return redirect()->route('root.positions.index');
    }

    public function destroy(Request $request, Position $position)
    {
        if ($position->delete()) {
            Notify::success('Position deleted.', 'Success!');

            return redirect()->route('root.positions.index');
        }

        Notify::warning('Cannot delete position.', 'Warning!');

        return redirect()->route('root.positions.index');
    }
}