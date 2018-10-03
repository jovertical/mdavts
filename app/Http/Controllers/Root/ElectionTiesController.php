<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Repositories\ElectionRepository;
use App\{Election, Candidate};

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionTiesController extends Controller
{
    /**
     * Fetch election tie-breakers.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return string
     */
    public function fetch(Request $request, Election $election)
    {
        $tally = (new ElectionRepository($election))->getTally();

        return (new ElectionRepository($election))->getTieBreakers($tally);
    }

    /**
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return string
     */
    public function randomize(Request $request, Election $election)
    {
        $tally = (new ElectionRepository($election))->getTally();

        $tieBreakers = (new ElectionRepository($election))->getTieBreakers($tally);

        $candidates = $tieBreakers[$request->post('index')];

        // random index.
        $randomIndex = mt_rand(0, count($candidates) - 1);

        // candidate (winner).
        $candidate = $candidates[$randomIndex]->candidate;

        // insert the winner.
        DB::table('election_winners')->insert([
            'election_uuid' => $election->uuid,
            'candidate_uuid' => Candidate::encodeUuid($candidate->uuid)
        ]);

        // we will just return the candidate
        return $candidate;
    }
}