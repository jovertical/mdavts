<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Exports\{ElectionTallyExport};
use App\Repositories\ElectionRepository;
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
        $archives = (new ElectionRepository($election))->getTally(
            $request->get('position')
        );

        return view('root.elections.election.tally', compact(
            ['election', 'archives', 'tie_breakers']
        ));
    }
}