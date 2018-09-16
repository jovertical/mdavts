<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
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
        $data = [
            'votes_today' => [],
            'total_votes' => [],
            'voters_ineligible' => [],
            'voters_eligible' => []
        ];

        $votesTodayCount = DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->where('used', 1)
            ->whereBetween('used_at', [
                now()->format('Y-m-d'), now()->addDays(1)->format('Y-m-d')
            ])
            ->count();

        $allVotesCount = DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->where('used', 1)
            ->count();

        $allVotersCount = User::where('type', 'user')->count();

        $eligibleVotersCount = DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->count();

        $ineligibleVotersCount = $allVotersCount - $eligibleVotersCount;

        // Votes Today
        $voteTodayRate = ($votesTodayCount / max($eligibleVotersCount, 1)) * 100;
        $data['votes_today']['value'] = $votesTodayCount;
        $data['votes_today']['rate'] = round($voteTodayRate);
        $data['votes_today']['floored_rate'] = floor($voteTodayRate / 5) * 5;

        // Total Votes
        $totalVoteRate = ($allVotesCount / max($eligibleVotersCount, 1)) * 100;
        $data['total_votes']['value'] = $allVotesCount;
        $data['total_votes']['rate'] = round($totalVoteRate);
        $data['total_votes']['floored_rate'] = floor($totalVoteRate / 5) * 5;

        // Voters Eligible
        $votersEligibleRate = ($eligibleVotersCount / max($allVotersCount, 1)) * 100;
        $data['voters_eligible']['value'] = $eligibleVotersCount;
        $data['voters_eligible']['rate'] = round($votersEligibleRate);
        $data['voters_eligible']['floored_rate'] = floor($votersEligibleRate / 5) * 5;

        // Voters Ineligible
        $votersIneligibleRate = $allVotersCount > 0
            ? (100 - $data['voters_eligible']['rate'])
            : 0;
        $data['voters_ineligible']['value'] = $ineligibleVotersCount;
        $data['voters_ineligible']['rate'] = round($votersIneligibleRate);
        $data['voters_ineligible']['floored_rate'] = floor($votersIneligibleRate / 5) * 5;

        return view('root.elections.election.dashboard', compact(
            ['data', 'election']
        ));
    }
}