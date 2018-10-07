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
            ->where('w.election_id', $election->id)
            ->leftJoin('candidates as c', 'c.user_id', '=', 'w.candidate_id')
            ->select(['c.id as candidate_id', 'c.position_id'])
            ->get();

        /**
         * @var array
         */
        $winners = collect([]);

        collect($leaders)->each(function($leader, $loop) use ($tbWinners, $winners) {
            $positions = $tbWinners->pluck('position_id');
            $users = $tbWinners->pluck('candidate_id');

            if (($posIndex = $positions->search($leader->position_id)) === false) {
                $winners->push($leader->candidate_id);
            } else {
                $winners->push($users[$posIndex]);
            }
        });

        // Delete randomized winners.
        DB::table('election_winners')
            ->where('election_id', $election->id)
            ->delete();

        // store winners in db.
        foreach ($winners as $winner) {
            DB::table('election_winners')->insert([
                'election_id' => $election->id,
                'candidate_id' => $winner
            ]);
        }

        $election->status = 'closed';
        
        if ($election->save()) {
            Notify::success('Election winners declared.');
        }

        return back();
    }
}