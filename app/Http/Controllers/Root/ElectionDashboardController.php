<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Repositories\ElectionRepository;
use App\{User, Election};

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionDashboardController extends Controller
{
    /**
     * Show Election Dashboard Page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function showDashboardPage(Request $request, Election $election)
    {
        $stats = [
            'votes_today' => [],
            'total_votes' => [],
            'voters_ineligible' => [],
            'voters_eligible' => []
        ];

        $votesTodayCount = DB::table('election_control_numbers')
            ->where('election_id', $election->id)
            ->where('used', 1)
            ->whereBetween('used_at', [
                now()->format('Y-m-d'), now()->addDays(1)->format('Y-m-d')
            ])
            ->count();

        $allVotesCount = DB::table('election_control_numbers')
            ->where('election_id', $election->id)
            ->where('used', 1)
            ->count();

        $allVotersCount = User::where('type', 'user')->count();

        $eligibleVotersCount = DB::table('election_control_numbers as ecn')
            ->leftJoin('users as u', 'u.id', '=', 'ecn.voter_id')
            ->where('election_id', $election->id)
            ->where('u.deleted_at', null)
            ->count();

        $ineligibleVotersCount = $allVotersCount - $eligibleVotersCount;

        // All Voters Count
        $stats['all_voters']['value'] = $allVotersCount;

        // Votes Today
        $voteTodayRate = ($votesTodayCount / max($eligibleVotersCount, 1)) * 100;
        $stats['votes_today']['value'] = $votesTodayCount;
        $stats['votes_today']['rate'] = round($voteTodayRate);
        $stats['votes_today']['floored_rate'] = floor($voteTodayRate / 5) * 5;

        // Total Votes
        $totalVoteRate = ($allVotesCount / max($eligibleVotersCount, 1)) * 100;
        $stats['total_votes']['value'] = $allVotesCount;
        $stats['total_votes']['rate'] = round($totalVoteRate);
        $stats['total_votes']['floored_rate'] = floor($totalVoteRate / 5) * 5;

        // Voters Eligible
        $votersEligibleRate = ($eligibleVotersCount / max($allVotersCount, 1)) * 100;
        $stats['voters_eligible']['value'] = $eligibleVotersCount;
        $stats['voters_eligible']['rate'] = round($votersEligibleRate);
        $stats['voters_eligible']['floored_rate'] = floor($votersEligibleRate / 5) * 5;

        // Voters Ineligible
        $votersIneligibleRate = $allVotersCount > 0
            ? (100 - $stats['voters_eligible']['rate'])
            : 0;
        $stats['voters_ineligible']['value'] = $ineligibleVotersCount;
        $stats['voters_ineligible']['rate'] = round($votersIneligibleRate);
        $stats['voters_ineligible']['floored_rate'] = floor($votersIneligibleRate / 5) * 5;

        // Election Winners
        $winners = (new ElectionRepository($election))->getWinners();

        return view('root.elections.election.dashboard', compact(
            ['election', 'stats', 'winners']
        ));
    }
}