<?php

namespace App\Repositories;

/**
 * Application
 */
use App\{User, Election, Candidate, Position};

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;

class ElectionRepository
{
    /**
     * @var \App\Election
     */
    protected $election;

    /**
     * @param \App\Election
     */
    public function __construct($election)
    {
        $this->election = $election;
    }

    /**
     * @param string
     * @return array
     */
    public function getTally($position = null)
    {
        $election_votes = DB::table('election_votes')
            ->select(
                'position_id as position',
                'candidate_id as candidate',
                'election_id as election',
                DB::raw('COUNT(*) as votes')
            )
            ->groupBy('candidate')
            ->get()
            ->map(function($vote) {
                $vote->position = Position::find($vote->position);

                $candidate = User::find($vote->candidate);
                $candidate->candidate = 
                    Candidate::where('user_id', $vote->candidate)
                        ->where('election_id', $vote->election)
                        ->first();
                $vote->candidate = $candidate;

                return $vote;
            })
            ->sortBy('position.level')
            ->values();

        $archives = [];

        foreach ($election_votes as $vote) {
            $archives[$vote->position->id]['votes'][] = $vote;
            $archives[$vote->position->id]['position'] = $vote->position;
        }

        if ($position != null) {
            $archive = $archives[$position];
            $archives = [$archive];
        }

        return $archives;
    }

    /**
     * @return array
     */
    public function getWinners()
    {
        // position, candidate, votes.
        return DB::table('election_votes')
            ->select(
                'position_id',
                'candidate_id',
                DB::raw('COUNT(*) as votes')
            )
            ->where('election_id', $this->election->id)
            ->groupBy('candidate_id')
            ->get()
            ->sortByDesc('votes')
            ->unique('position_id')
            ->map(function ($value, $key) {
                $value->position = Position::find($value->position_id);
                $value->user = User::find($value->candidate_id);

                return $value;
            })
            ->sortBy('position.level')
            ->values()
            ->toArray();
    }

    /**
     * @param array
     * @return array
     */
    public function getTieBreakers($tally)
    {
        $filtered = array_filter($tally, function ($stats) {
            $votes = collect($stats['votes'])
                ->sortByDesc('votes')
                ->pluck('votes');

            $count = collect($votes)->filter(function ($vote) use ($votes) {
                return $vote == $votes[0];
            })->count();

            return $count > 1;
        });

        $tieBreakers = collect([]);

        collect(array_column($filtered, 'votes'))->each(
            function($votes) use ($tieBreakers) {
                collect($votes)->map(function($vote) use ($votes) {
                    $vote->has_won = DB::table('election_winners')
                        ->where('election_id', $this->election->id)
                        ->where('candidate_id', $vote->candidate->id)
                        ->count() > 0;
                });

                $votes = collect($votes)
                    ->sortByDesc('votes')
                    ->values();

                $tieBreaker = $votes->filter(function ($vote) use ($votes) {
                        return $vote->votes == $votes[0]->votes;
                    })->values();

                $tieBreakers->push($tieBreaker);
        })->toArray();

        return $tieBreakers;
    }
}