<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Exports\{ElectionTallyExport};
use App\Repositories\ElectionTallyRepository;
use App\Services\{Notify};
use App\{User, Election, Position};

/**
 * Package Services
 */
use PDF;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionTallyController extends Controller
{
    /**
     * Show Tally page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function showTallyPage(Request $request, Election $election)
    {
        $election_votes = DB::table('election_votes')
            ->select(
                'position_uuid as position',
                'candidate_uuid as candidate',
                DB::raw('COUNT(*) as votes')
            )
            ->groupBy('candidate')
            ->get()
            ->map(function($vote) {
                $vote->position = Position::find($vote->position);
                $vote->candidate = User::find($vote->candidate);

                return $vote;
            })
            ->sortBy('position.level')
            ->values();

        $archives = [];

        foreach ($election_votes as $vote) {
            $archives[$vote->position->uuid]['votes'][] = $vote;
            $archives[$vote->position->uuid]['position'] = $vote->position;
        }

        if ($position = $request->get('position')) {
            $archive = $archives[Position::encodeUuid($position)];
            $archives = [$archive];
        }

        return view('root.elections.election.tally', compact(['election', 'archives']));
    }

    /**
     * Export Results.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export(Request $request, Election $election)
    {
        $file_name = $request->input('file_name');
        $file_type = $request->input('file_type');

        try {
            switch (strtolower($file_type)) {
                case 'pdf':
                    $heading = "{$election->name} Results";
                    $archives = (new ElectionTallyRepository)->getData($election);

                    return PDF::loadView('root.exports.elections.tally', compact(
                        ['archives', 'heading']
                    ))
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 150])
                    ->download($file_name.'.pdf');
                break;

                case 'excel':
                    return Excel::download(
                        new ElectionTallyExport($election), "{$file_name}.xlsx"
                    );
                break;

                case 'csv':
                    return Excel::download(
                        new ElectionTallyExport($election), "{$file_name}.csv"
                    );
                break;
            }

            throw new \ErrorException('Error generating results');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Error!');
        }

        return back();
    }
}