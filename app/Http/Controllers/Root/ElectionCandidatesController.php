<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{User, Election, Candidate, PartyList};

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
     * Show Candidate Index Page.
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function index(Election $election)
    {
        $candidates = Candidate::where('election_id', $election->id)->get();

        return view('root.elections.election.candidates.index', compact(
            ['election', 'candidates']
        ));
    }

    /**
     * Show Candidate Creation Page.
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
            return Candidate::where('election_id', $election->id)
                ->where('user_id', $user->id)
                ->count() == 0;
        });

        $partylists = PartyList::all();

        $allUserCount = $users->count();

        if ($request->has('c')) {
            $users = $users->take($request->get('c'))->all();
        }

        return view('root.elections.election.candidates.create', compact(
            ['election', 'users', 'partylists', 'allUserCount']
        ));
    }

    /**
     * Store Candidate.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Routing\Redirector/\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Election $election)
    {
        if (empty($request->input('position'))) {
            $errors[] = 'Please select a Position';
        }

        if (empty($request->input('partylist'))) {
            $errors[] = 'Please select a Partylist';
        }

        $reElectionist = DB::table('candidates')
            ->where('election_id', $election->id)
            ->where('position_id', $request->input('position'))
            ->where('partylist_id', $request->input('partylist'))
            ->count() > 0;

        if ($reElectionist) {
            $errors[] = 'There is already a candidate for that partylist.';
        }

        $user =  User::find($request->input('user'));

        if (! empty($user->grade_id)) {
            $allowedGrades = DB::table('election_grades')
                ->where('election_id', $election->id)
                ->pluck('grade_id')
                ->toArray();

            if (! in_array($user->grade_id, $allowedGrades)) {
                $errors[] = 'Candidate is not eligible to run in the election.';
            }
        }

        if (count($errors ?? [])) {
            Notify::warning($errors[0]);

            return back();
        }

        $candidate = new Candidate;
        $candidate->user_id = $request->input('user');
        $candidate->election_id = $election->id;
        $candidate->position_id = $request->input('position');

        $candidate->partylist_id = $request->input('partylist');

        if ($candidate->save()) {
            Notify::success('Candidate nominated.', 'Success!');

            return redirect()->route('root.elections.candidates.index', $election);
        }

        Notify::warning('Failed to nominate candidate.', 'Warning!');

        return back();
    }
}