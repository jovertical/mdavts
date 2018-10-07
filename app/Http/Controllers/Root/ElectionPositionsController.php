<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{Election, Position};

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

class ElectionPositionsController extends Controller
{
    /**
     * Show Set Election Positions page.
     * @param \App\Election
     * @return \Illuminate\View\View/\Illuminate\Http\RedirectResponse
     */
    public function showPositionsPage(Election $election)
    {
        // add a check to prevent further modifications.
        if (in_array($election->status, ['active', 'ended', 'closed'])) {
            Notify::warning("The election is already {$election->status}.");

            return back();
        }

        $positions = Position::all();

        $position_ids = DB::table('election_position')
            ->where('election_id', $election->id)
            ->get()
            ->map(function($e) {
                return $e->position_id;
            })
            ->all();

        return view('root.elections.election.positions', compact(
            ['position_ids', 'positions', 'election']
        ));
    }

    /**
     * Store Election Positions.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Election $election)
    {
        $position_ids = $request->input('positions') ?? [];

        DB::table('election_position')
            ->where('election_id', $election->id)
            ->delete();

        foreach ($position_ids as $position_id) {
            DB::table('election_position')->insert([
                'election_id' => $election->id,
                'position_id' => $position_id
            ]);
        }

        Notify::success('Election Positions stored.');

        return back();
    }
}