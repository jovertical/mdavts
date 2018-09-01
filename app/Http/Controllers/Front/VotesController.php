<?php

namespace App\Http\Controllers\Front;

use DB;
use App\{User, Election, Position, Candidate};
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VotesController extends Controller
{
    /**
     * Show identity page
     * @return \Illuminate\View\View
     */
    public function showIdentityForm()
    {
        // linisin ang naiwang sakit.
        session()->forget('voting');

        return view('front.voting.identity');
    }

    /**
     * Identify the voter
     * @param Illuminate\Http\Request
     * @return Illuminate\Routing\Redirector
     */
    public function identify(Request $request)
    {
        $request->validate([
            'control_number' => 'required|exists:election_control_numbers,number'
        ]);

        // hanapin ang may ari.
        $control_number = DB::table('election_control_numbers')
            ->where('number', $request->input('control_number'))
            ->first();

        $election = Election::find($control_number->election_uuid);

        $now = now()->format('Y-m-d');

        if ($now < $election->start_date) {
            $errors[] = 'Election is not yet started.';
        }

        if ($now > $election->end_date) {
            $errors[] = 'Election is over.';
        }

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
        $user = User::find($control_number->voter_uuid ?? null);

        return redirect()->route('front.voting.vote', compact(
            ['election', 'user']
        ));
    }

    /**
     * Show vote page
     * @param Illuminate\Http\Request
     * @param App\Election
     * @param App\User The voter
     * @return \Illuminate\View\View/Illuminate\Routing\Redirector
     */
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

        // filter to skip voting for positions without candidate.
        $positions = $election->positions->filter(function($p) use ($election) {
            $p_uuids = $election->candidates->pluck('position_uuid')->all();

            return in_array($p->uuid, $p_uuids);
        });

        $position = $positions[$pi];

        $candidates = $election->candidates->filter(
            function($candidate) use ($position) {
                return $candidate->position_uuid == $position->uuid;
            });

        return view('front.voting.vote', compact(
            ['election', 'positions', 'position', 'user', 'candidates']
        ));
    }

    /**
     * Select a candidate
     * @param Illuminate\Http\Request
     * @param App\Election
     * @param App\User The voter
     * @return \Illuminate\Routing\Redirector
     */
    public function vote(
        Request $request, Election $election, User $user
    ) {
        $puuid = $request->input('position_uuid');
        $u_uuid = $request->input('user_uuid');

        session(["voting.selected.{$puuid}" => $u_uuid]);

        return back();
    }

    /**
     * Store Election Vote
     * @param Illuminate\Http\Request
     * @param App\Election
     * @param App\User The voter
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request, Election $election, User $user)
    {
        $candidates = session()->get('voting.selected');

        // Store vote (of course).
        foreach ($candidates as $position => $candidate) {
            DB::table('election_votes')->insert([
                'election_uuid' => $election->uuid,
                'position_uuid' => Position::encodeUuid($position),
                'candidate_uuid' => Candidate::encodeUuid($candidate),
                'voter_uuid' => $user->uuid
            ]);
        }

        // Set control number of user as used, for this election.
        DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->where('voter_uuid', $user->uuid)
            ->update(['used' => 1]);

        return redirect()->route('front.voting.review', [$election, $user]);
    }

    /**
     * Show review page
     * @param Illuminate\Http\Request
     * @param App\Election
     * @param App\User The voter
     * @return \Illuminate\View\View
     */
    public function showReviewPage(
        Request $request, Election $election, User $user
    ) {
        $uuids = DB::table('election_votes')
            ->where('voter_uuid', $user->uuid)
            ->pluck('candidate_uuid');

        $candidates = Candidate::whereIn('user_uuid', $uuids)
            ->leftJoin('positions as p', 'p.uuid', '=', 'candidates.position_uuid')
            ->orderBy('level')
            ->select(['user_uuid', 'election_uuid', 'position_uuid'])
            ->get();

        return view('front.voting.review', compact(
            ['election', 'user', 'candidates']
        ));
    }
}