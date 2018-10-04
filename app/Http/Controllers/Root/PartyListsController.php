<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\Notify;
use App\{PartyList};


/*
Laravel
*/
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartyListsController extends Controller
{
    public function index()
    {
        $partylists = PartyList::all();

        return view('root.partylists.index', compact('partylists'));
    }

    public function create()
    {
        return view('root.partylists.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $partylists = new PartyList;
        $partylists->name = $request->input('name');
        $partylists->description = $request->input('description');

        if ($partylists->save()) {

            Notify::success('Party List created.', 'Success!');

            return redirect()->route('root.partylists.index');
        }

        Notify::warning('Cannot create the party list.', 'Warning!');

        return redirect()->route('root.partylists.index');
    }

    public function edit(Request $request, PartyList $partylists)
    {
        return view('root.partylists.edit', compact('partylists'));
    }

    public function update(Request $request, PartyList $partylists)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $partylists->name = $request->input('name');
        $partylists->description = $request->input('description');

        if ($partylists->save()) {
            Notify::success('Party List created.', 'Success!');

            return redirect()->route('root.partylists.index');
        }

        Notify::warning('Cannot create the party list.', 'Warning!');

        return redirect()->route('root.partylists.index');
    }

    public function destroy(Request $request, PartyList $partylists)
    {
        if ($partylists->delete()) {
            Notify::success('Party list deleted.', 'Success!');

            return redirect()->route('root.partylists.index');
        }

        Notify::warning('Cannot delete the party list.', 'Warning!');

        return redirect()->route('root.partylists.index');
    }

}

