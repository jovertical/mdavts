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

        $election = Election::find($control_number->election_id);

        if ($election->status == 'upcoming') {
            $errors[] = 'Election is not yet started.';
        }

        if ($election->status == 'ended') {
            $errors[] = 'Election is already ended.';
        }

        if ($election->status == 'closed') {
            $errors[] = 'Election is already closed.';
        }

        if ($control_number->used) {
            $errors[] = 'The provided control number is already used.';
        }

        $user =  User::find($control_number->voter_id);

        if (! empty($user->grade_id)) {
            $allowedGrades = DB::table('election_grades')
                ->where('election_id', $election->id)
                ->pluck('grade_id')
                ->toArray();

            if (! in_array($user->grade_id, $allowedGrades)) {
                $errors[] = 'Candidate is not eligible to run in the election.';
            }
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

        $election = Election::find($control_number->election_id ?? null);
        $user = User::find($control_number->voter_id ?? null);

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

        // hanapin ang may ari.
        $control_number = DB::table('election_control_numbers')
            ->where('election_id', $election->id)
            ->where('voter_id', $user->id)
            ->first();

        if ($election->positions->count() < 1) {
            $errors[] = 'Election needs at least one position.';
        }

        if ($election->candidates->count() < 1)  {
            $errors[] = 'Election needs at least one candidate.';
        }

        if ($control_number->used) {
            $errors[] = 'The provided control number is already used.';
        }

        if (count($errors ?? [])) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => $errors[0]
            ]);

            return redirect()->route('front.voting.identity');
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
            $p_ids = $election->candidates->pluck('position_id')->all();

            return in_array($p->id, $p_ids);
        })->values();

        $position = $positions[$pi];

        $candidates = $election->candidates->filter(
            function($candidate) use ($position) {
                return $candidate->position_id == $position->id;
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
        $pid = $request->input('position_id');
        $u_id = $request->input('user_id');

        session(["voting.selected.{$pid}" => $u_id]);

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
                'election_id' => $election->id,
                'position_id' => $position,
                'candidate_id' => $candidate,
                'voter_id' => $user->id
            ]);
        }

        // Set control number of user as used, for this election.
        DB::table('election_control_numbers')
            ->where('election_id', $election->id)
            ->where('voter_id', $user->id)
            ->update([
                'used' => 1, 'used_at' => now()
            ]);

        // Remove voting data from session. (kalimutan na)
        session()->forget('voting');

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
        $ids = DB::table('election_votes')
            ->where('election_id', $election->id)
            ->where('voter_id', $user->id)
            ->pluck('candidate_id');

        $candidates = Candidate::whereIn('user_id', $ids)
            ->where('election_id', $election->id)
            ->leftJoin('positions as p', 'p.id', '=', 'candidates.position_id')
            ->orderBy('level')
            ->select(['user_id', 'election_id', 'position_id', 'partylist_id'])
            ->with(['user', 'party_list'])
            ->get();

        return view('front.voting.review', compact(
            ['election', 'user', 'candidates']
        ));
    }
}