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
     * @return \Illuminate\View\View
     */
    public function showPositionsPage(Election $election)
    {
        $positions = Position::all();

        $position_uuids = DB::table('election_position')
            ->where('election_uuid', $election->uuid)
            ->get()
            ->map(function($e) {
                return Election::decodeUuid($e->position_uuid);
            })
            ->all();

        return view('root.elections.election.positions', compact(
            ['position_uuids', 'positions', 'election']
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
        $position_uuids = $request->input('positions');

        DB::table('election_position')
            ->where('election_uuid', $election->uuid)
            ->delete();

        foreach ($position_uuids as $position_uuid) {
            DB::table('election_position')->insert([
                'election_uuid' => $election->uuid,
                'position_uuid' => Position::encodeUuid($position_uuid)
            ]);
        }

        Notify::success('Election Positions stored.');

        return back();
    }
}