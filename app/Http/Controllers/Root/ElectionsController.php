<?php

namespace App\Http\Controllers\Root;

use Notify;
use App\{User, Election, Position, Candidate};
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionsController extends Controller
{
    public function index()
    {
        $elections = Election::all();

        return view('root.elections.index', compact('elections'));
    }

    public function create()
    {
        return view('root.elections.create');
    }

   public function store(Request $request)
   {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date|after:today|before:end_date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $election = new Election;
        $election->fill($request->all());
        unset($election->files);

        if ($election->save()) {
            Notify::success('Election created.', 'Success!');

            return redirect()->route('root.elections.index');
        }

        Notify::warning('Cannot create the election.', 'Warning!');

        return redirect()->route('root.elections.index');
    }

    public function edit(Request $request, Election $election)
    {
        return view('root.elections.edit', compact('election'));
    }

    public function update(Request $request, Election $election)
    {

        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date|after:today|before:end_date',
            'end_date' => 'required|date|after:start_date'
        ]);

         $election->fill($request->all());
         unset($election->files);

        if ($election->update()) {
            Notify::success('Election event updated.', 'Success!');

            return redirect()->route('root.elections.index');
        }
            Notify::warning('Cannot update election event.', 'Failed');
            return redirect()->route('root.elections.index');
    }

    public function destroy(Request $request, Election $election)
    {
        if ($election->delete()) {
            Notify::success('Election event deleted.', 'Success!');

            return redirect()->route('root.elections.index');
        }

        Notify::warning('Cannot delete election event.', 'Warning!');

        return redirect()->route('root.elections.index');
    }

    public function setPositions(Election $election)
    {
        $positions = Position::all();

        $position_uuids = DB::table('election_position')
            ->where('election_uuid', $election->uuid)
            ->get()
            ->map(function($e) {
                return Election::decodeUuid($e->position_uuid);
            })
            ->all();

        return view('root.elections.positions', compact(
            ['position_uuids', 'positions', 'election']
        ));
    }

    public function updatePositions(Request $request, Election $election)
    {
        $position_uuids = $request->input('positions');

        DB::table('election_position')
            ->where('election_uuid', $election->uuid)
            ->delete();

        foreach ($position_uuids as $position_uuid) {
            DB::table('election_position')->insert([
                'election_uuid' => $election->uuid,
                'position_uuid' => Position::encodeUuid($position_uuid)
            ]);
        }

        Notify::success('Election Positions updated.');

        return back();
    }

    public function nominee(Request $request, Election $election)
    {
        if ($request->has('firstname')) {
            $firstname = "%{$request->input('firstname')}%";
        }

        if ($request->has('lastname')) {
            $lastname = "%{$request->input('lastname')}%";
        }

        $users = User::where('type', 'user')
            ->where('firstname', 'like', $firstname ?? '')
            ->where('lastname', 'like', $lastname ?? '')
            ->get();

        // filter user to prevent being nominated again!!!
        $users = $users->filter(function($user) use ($election) {
            return Candidate::where('election_uuid', $election->uuid)
                ->where('user_uuid', $user->uuid)
                ->count() == 0;
        });

        return view('root.elections.candidates', compact(
            ['election', 'users']
        ));
    }

    public function nominate(Request $request, Election $election)
    {
        $request->validate([
            'position' => 'required'
        ]);

        $candidate = new Candidate;
        $candidate->user_uuid = User::encodeUuid($request->input('user'));
        $candidate->election_uuid = $election->uuid;
        $candidate->position_uuid = Candidate::encodeUuid(
            $request->input('position')
        );

        if ($candidate->save()) {
            Notify::success('Candidate nominated.', 'Success!');

            return back();
        }

        Notify::warning('Failed to nominate candidate.', 'Warning!');

        return back();
    }
}