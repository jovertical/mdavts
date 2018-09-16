<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{User, Election, Candidate};

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

class ElectionCandidatesController extends Controller
{

    /**
     * Show Set Candidate Page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function showCandidatesPage(Request $request, Election $election)
    {
        $users = User::where('type', 'user');

        if ($request->has('firstname')) {
            $firstname = "%{$request->input('firstname')}%";

            $users->where('firstname', 'like', $firstname ?? '');
        }

        if ($request->has('lastname')) {
            $lastname = "%{$request->input('lastname')}%";

            $users->where('lastname', 'like', $lastname ?? '');
        }

        // filter user to prevent being nominated again!!!
        $users = $users->get()->filter(function($user) use ($election) {
            return Candidate::where('election_uuid', $election->uuid)
                ->where('user_uuid', $user->uuid)
                ->count() == 0;
        });

        $allUserCount = $users->count();

        if ($request->has('c')) {
            $users = $users->take($request->get('c'))->all();
        }

        return view('root.elections.election.candidates', compact(
            ['election', 'users', 'allUserCount']
        ));
    }

    /**
     * Nominate.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Election $election)
    {
        $request->validate([
            'position' => 'required'
        ]);

        $candidate = new Candidate;
        $candidate->user_uuid = User::encodeUuid($request->input('user'));
        $candidate->election_uuid = $election->uuid;
        $candidate->position_uuid = Candidate::encodeUuid(
            $request->input('position')
        );

        if ($candidate->save()) {
            Notify::success('Candidate nominated.', 'Success!');

            return back();
        }

        Notify::warning('Failed to nominate candidate.', 'Warning!');

        return back();
    }
}