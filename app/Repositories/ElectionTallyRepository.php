<?php

namespace App\Repositories;

/**
 * Application
 */
use App\{User, Election, Position};

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;

class ElectionTallyRepository
{
    public function getData(Election $election)
    {
        // position, candidate, votes.
        return DB::table('election_votes')
            ->select(
                'position_uuid as position',
                'candidate_uuid as candidate',
                DB::raw('COUNT(*) as votes')
            )
            ->where('election_uuid', $election->uuid)
            ->groupBy('candidate')
            ->get()
            ->sortByDesc('votes')
            ->unique('position')
            ->map(function ($value, $key) {
                $position = Position::find($value->position);
                $value->position = $position->name;
                $value->level = $position->level;
                $value->candidate = User::find($value->candidate)->full_name_formal;

                return $value;
            })
            ->sortBy('level')
            ->each(function ($item, $key) {
                unset($item->level);

                return $item;
            });
    }
}