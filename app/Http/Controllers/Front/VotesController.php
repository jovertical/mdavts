<?php

namespace App\Http\Controllers\Front;

use DB;
use App\{User, Election, Position, Candidate};
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VotesController extends Controller
{
    public function showIdentityForm()
    {
        // linisin ang naiwang sakit.
        session()->forget('voting');

        return view('front.voting.identity');
    }

    public function identify(Request $request)
    {
        $request->validate([
            'control_number' => 'required|exists:election_control_numbers,number'
        ]);

        // hanapin ang may ari.
        $control_number = DB::table('election_control_numbers')
            ->where('number', $request->input('control_number'))
            ->first();

        if ($control_number->used) {
            $errors[] = 'The provided control number is already used.';
        }

        if (count($errors ?? [])) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => 'The system cannot process your request. Please try again.'
            ]);

            throw ValidationException::withMessages([
                'control_number' => $errors[0]
            ]);

            return back();
        }

        $election = Election::find($control_number->election_uuid ?? null);
        $user = User::find($control_number->user_uuid ?? null);

        return redirect()->route('front.voting.vote', compact(
            ['election', 'user']
        ));
    }

    public function showVoteForm(Request $request, Election $election, User $user)
    {
        $pi = $request->input('pi') ?? 0;

        if ($election->positions->count() < 1) {
            $errors[] = 'Election needs at least one position.';
        }

        if ($election->candidates->count() < 1)  {
            $errors[] = 'Election needs at least one candidate.';
        }

        if (count($errors ?? [])) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => $errors[0]
            ]);

            return back();
        }

        // increment position level.
        if ($request->has('next')) {
            $pi++;

            return redirect()->route('front.voting.vote', compact(
                ['election', 'user', 'pi']
            ));
        }

        // decrement position level.
        if ($request->has('back')) {
            $pi--;

            return redirect()->route('front.voting.vote', compact(
                ['election', 'user', 'pi']
            ));
        }

        $position = $election->positions[$pi];

        $candidates = $election->candidates->filter(
            function($candidate) use ($position) {
                return $candidate->position_uuid == $position->uuid;
            });

        return view('front.voting.vote', compact(
            ['election', 'position', 'user', 'candidates']
        ));
    }

    public function vote(
        Request $request, Election $election, User $user
    ) {
        $puuid = $request->input('position_uuid');
        $u_uuid = $request->input('user_uuid');

        session(["voting.selected.{$puuid}" => $u_uuid]);

        return back();
    }

    public function store(Request $request, Election $election, User $user)
    {
        $user_uuids = array_values(session()->get('voting.selected'));

        // Add Candidate Vote for each candidate (of course).
        foreach ($user_uuids as $uuid) {
            $candidate = Candidate::where(
                'user_uuid', User::encodeUuid($uuid)
            )->first();

            DB::table('candidate_votes')->insert([
                'candidate_uuid' => $candidate->uuid,
                'user_uuid' => $user->uuid
            ]);
        }

        // Set control number of user as used, for this election.
        DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->where('user_uuid', $user->uuid)
            ->update(['used' => 1]);

        return redirect()->route('front.voting.results', [$election, $user]);
    }

    public function showResultsPage(
        Request $request, Election $election, User $user
    ) {
        $uuids = DB::table('candidate_votes')
            ->where('user_uuid', $user->uuid)
            ->pluck('candidate_uuid');

        $candidates = Candidate::whereIn('uuid', $uuids)->orderBy('level')->get();

        return view('front.voting.results', compact(
            ['election', 'user', 'candidates']
        ));
    }
}