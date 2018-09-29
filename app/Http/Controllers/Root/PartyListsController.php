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
            'party' => 'required',
        ]);

        

        $partylist = new PartyList;
        $partylist->party = $request->input('party');
        $partylist->description = $request->input('description');

        if ($partylist->save()) {
            Notify::success('Party List created.', 'Success!');

            return redirect()->route('root.partylists.index');
        }

        Notify::warning('Cannot create the party list.', 'Warning!');

        return redirect()->route('root.partylists.index');
    }

    public function edit(Request $request, PartyList $partylist)
    {
        return view('root.partylists.edit', compact('partylist'));
    }

    public function update(Request $request, PartyList $partylist)
    {
        $request->validate([
            'party' => 'required',
        ]);

        $partylist->party = $request->input('party');
        $partylist->description = $request->input('description');

        if ($partylist->save()) {
            Notify::success('Party List created.', 'Success!');

            return redirect()->route('root.partylists.index');
        }

        Notify::warning('Cannot create the party list.', 'Warning!');

        return redirect()->route('root.partylists.index');
    }

    public function destroy(Request $request, PartyList $partylist)
    {
        if ($partylist->delete()) {
            Notify::success('Party list deleted.', 'Success!');

            return redirect()->route('root.partylists.index');
        }

        Notify::warning('Cannot delete the party list.', 'Warning!');

        return redirect()->route('root.partylists.index');
    }

}

