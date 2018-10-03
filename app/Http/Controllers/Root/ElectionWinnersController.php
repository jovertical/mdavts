<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\Notify;
use App\Repositories\ElectionRepository;
use App\Election;

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionWinnersController extends Controller
{
    /**
     * Fetch election winners.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return string
     */
    public function fetch(Request $request, Election $election)
    {
        return [];
    }

    /**
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Routing\Redirector
     */
    public function declare(Request $request, Election $election)
    {
        /**
         * This data is a bit of biased (for tie breakers).
         * @var Illuminate\Support\Collection
         */
        $leaders = (new ElectionRepository($election))->getWinners();

        /**
         * These are early declared winners (randomized).
         * @var array
         */
        $tbWinners = DB::table('election_winners as w')
            ->where('w.election_uuid', $election->uuid)
            ->leftJoin('candidates as c', 'c.user_uuid', '=', 'w.candidate_uuid')
            ->select(['c.uuid as candidate_uuid', 'c.position_uuid'])
        
            ->get();

        /**
         * @var array
         */
        $winners = collect([]);

        collect($leaders)->each(function($leader, $loop) use ($tbWinners, $winners) {
            $positions = $tbWinners->pluck('position_uuid');
            $users = $tbWinners->pluck('candidate_uuid');

            if (($posIndex = $positions->search($leader->position_uuid)) === false) {
                $winners->push($leader->candidate_uuid);
            } else {
                $winners->push($users[$posIndex]);
            }
        });

        // Delete randomized winners.
        DB::table('election_winners')
            ->where('election_uuid', $election->uuid)
            ->delete();

        // store winners in db.
        foreach ($winners as $winner) {
            DB::table('election_winners')->insert([
                'election_uuid' => $election->uuid,
                'candidate_uuid' => $winner
            ]);
        }

        $election->status = 'closed';
        
        if ($election->save()) {
            Notify::success('Election winners declared.');
        }

        return back();
    }
}