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
        $elections = Election::get(['id', 'name'])->toJson();

        $positions = Election::get()->keyBy('id')->map(function ($election) {
            return $election->positions->pluck('name', 'id');
        });

        $users = User::where('type', 'user')->get()->map(function ($user) {
            $user->full_name = "
                {$user->lastname}, {$user->firstname} {$user->middlename}
            ";

            return $user->only(['id', 'full_name']);
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

        $election = Election::find($request->input('election'));
        $user = User::find($request->input('user'));
        $users = User::where('type', 'user')->get();

        $elected = Candidate::where('election_id', $election->id)
            ->where('user_id', $user->id)
            ->count() > 0;

        if ($elected) {
            $errors[] = 'This user is already elected for this election';
        }

        if (count($errors ?? [])) {
            Notify::warning($errors[0], 'Error!');

            return back();
        }

        $candidate = new Candidate;
        $candidate->user_id = $request->input('user');
        $candidate->election_id = $request->input('election');
        $candidate->position_id = $request->input('position');

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
