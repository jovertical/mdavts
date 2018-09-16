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
     * Show Set Control Numbers page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function showControlNumbersPage(Request $request, Election $election)
    {
        $data = collect([]);

        $data->all_users = User::where('type', 'user')->count();

        $data->with = DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->count();

        $data->without = $data->all_users - $data->with;

        return view('root.elections.election.control_numbers', compact(
           ['data', 'election']
        ));
    }

    /**
     * Store Control Numbers.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Election $election)
    {
        $users = User::where('type', 'user')->get();
        $voter_uuids = DB::table('election_control_numbers')
            ->where('election_uuid', $election->uuid)
            ->pluck('voter_uuid')
            ->all();

        // Store control numbers for each user with this election as reference.
        $users->each(function($user) use ($election, $voter_uuids) {
            if (! in_array($user->uuid, $voter_uuids)) {
                DB::table('election_control_numbers')->insert([
                    'election_uuid' => $election->uuid,
                    'voter_uuid' => $user->uuid,
                    'number' => mt_rand(100000, 999999)
                ]);
            }
        });

        Notify::success('Control Number(s) stored.');

        return back();
    }
}