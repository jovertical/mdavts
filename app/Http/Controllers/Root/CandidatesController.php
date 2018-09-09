<?php

namespace App\Http\Controllers\Root;

use Notify;
use App\{Candidate, User, Election, Position};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidatesController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();

        return view('root.candidates.index', compact('candidates'));
    }

    public function create()
    {
        $elections = Election::get(['uuid', 'name'])->toJson();

        $positions = Election::get()->keyBy('uuid_text')->map(function ($election) {
            return $election->positions->pluck('name', 'uuid_text');
        });

        $users = User::where('type', 'user')->get()->map(function ($user) {
            $user->full_name = "
                {$user->lastname}, {$user->firstname} {$user->middlename}
            ";

            return $user->only(['uuid_text', 'full_name']);
        })->toJson();

        return view('root.candidates.create', compact(
            ['elections', 'positions', 'users']
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'string|required',
            'election' => 'string|required',
            'position' => 'string|required',
        ]);

        $election = Election::withUuid($request->input('election'))->first();
        $user = User::withUuid($request->input('user'))->first();
        $users = User::where('type', 'user')->get();

        $elected = Candidate::where('election_uuid', $election->uuid)
            ->where('user_uuid', $user->uuid)
            ->count() > 0;

        if ($elected) {
            $errors[] = 'This user is already elected for this election';
        }

        if (count($errors ?? [])) {
            Notify::warning($errors[0], 'Error!');

            return back();
        }

        $candidate = new Candidate;
        $candidate->user_uuid = User::encodeUuid($request->input('user'));
        $candidate->election_uuid = Election::encodeUuid($request->input('election'));
        $candidate->position_uuid = Position::encodeUuid($request->input('position'));

        if ($candidate->save()) {
            Notify::success('Candidate nominated.', 'Success!');

            return redirect()->route('root.candidates.index');
        }

        Notify::warning('Failed to nominate candidate.', 'Warning!');

        return redirect()->route('root.candidates.index');
    }

    public function edit(Request $request, Candidate $candidate)
    {
        return view('root.candidates.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'grade_level' => 'required',

        ]);

        $candidate->fill($request->all());

        if ($candidate->update()) {
            Notify::success('Candidate updated.', 'Success!');

            return redirect()->route('root.candidates.index');
        }

        Notify::warning('Failed to update a candidate.', 'Warning!');

        return redirect()->route('root.candidates.index');
    }

    public function destroy(Request $request, Candidate $candidate)
    {
        if ($candidate->delete()) {
            Notify::success('Candidate deleted.', 'Success!');

            return redirect()->route('root.candidates.index');
        }

        Notify::warning('Cannot delete candidate.', 'Warning!');

        return redirect()->route('root.candidates.index');
    }
}
