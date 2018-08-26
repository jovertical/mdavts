<?php

namespace App\Http\Controllers\Front;

use DB;
use App\{Election, Position, User};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VotesController extends Controller
{
    public function showIdentityForm()
    {
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

        $election = Election::find($control_number->election_uuid ?? null);
        $user = User::find($control_number->user_uuid ?? null);

        return redirect()->route('front.voting.vote', compact(
            ['election', 'user']
        ));
    }

    public function showVoteForm(Request $request, Election $election, User $user)
    {
        $pi = $request->input('pi') ?? 0;

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
}