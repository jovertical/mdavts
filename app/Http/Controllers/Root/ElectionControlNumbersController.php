<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{User, Election};

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

class ElectionControlNumbersController extends Controller
{
    /**
     * Show Resource Index page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function index(Request $request, Election $election)
    {
        $control_numbers = DB::table('election_control_numbers as ecn')
            ->where('ecn.election_id', $election->id)
            ->get();

        $control_numbers->each(function($cn) {
            $cn->user = User::find($cn->voter_id);
        });

        return view('root.elections.election.control_numbers.index', compact(
            ['election', 'control_numbers']
        ));
    }

    /**
     * Show Resource Creation page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Election $election)
    {
        // add a check to prevent further modifications.
        if (in_array($election->status, ['active', 'ended', 'closed'])) {
            Notify::warning("The election is already {$election->status}.");

            return back();
        }

        $data = collect([]);

        $data->all_users = User::where('type', 'user')->count();

        $data->with = DB::table('election_control_numbers as ecn')
            ->leftJoin('users as u', 'u.id', '=', 'ecn.voter_id')
            ->where('election_id', $election->id)
            ->where('u.deleted_at', null)
            ->count();

        $data->without = $data->all_users - $data->with;

        return view('root.elections.election.control_numbers.create', compact(
           ['data', 'election']
        ));
    }

    /**
     * Store Resource.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request, Election $election)
    {
        $users = User::where('type', 'user')->get();
        $voter_ids = DB::table('election_control_numbers')
            ->where('election_id', $election->id)
            ->pluck('voter_id')
            ->all();

        // Store control numbers for each user with this election as reference.
        $users->each(function($user) use ($election, $voter_ids) {
            if (! in_array($user->id, $voter_ids)) {
                DB::table('election_control_numbers')->insert([
                    'election_id' => $election->id,
                    'voter_id' => $user->id,
                    'number' => mt_rand(100000, 999999)
                ]);
            }
        });

        Notify::success('Control Number(s) stored.');

        return redirect()->route('root.elections.control-numbers.index', $election);
    }
}