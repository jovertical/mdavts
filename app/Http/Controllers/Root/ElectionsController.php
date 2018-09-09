<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{User, Election, Position, Candidate};

/**
 * Third-party
 */
use PDF;

/**
 * Laravel
 */
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionsController extends Controller
{
    /**
     * Show index page.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $elections = Election::all();

        return view('root.elections.index', compact('elections'));
    }

    /**
     * Show resource creation page.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('root.elections.create');
    }

    /**
     * Store resource.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:elections,name,NULL,uuid,deleted_at,NULL',
            'start_date' => 'required|date|after:today|before:end_date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $election = new Election;
        $election->fill($request->all());
        unset($election->files);

        if ($election->save()) {
            Notify::success('Election created.', 'Success!');

            return redirect()->route('root.elections.index');
        }

        Notify::warning('Cannot create the election.', 'Warning!');

        return redirect()->route('root.elections.index');
    }

    /**
     * Show resource edit page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     */
    public function edit(Request $request, Election $election)
    {
        return view('root.elections.edit', compact('election'));
    }

    /**
     * Update resource.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     */
    public function update(Request $request, Election $election)
    {
        $request->validate([
            'name' => "required|unique:elections,name,{$election->uuid},uuid,deleted_at,NULL",
            'start_date' => 'required|date|after:today|before:end_date',
            'end_date' => 'required|date|after:start_date'
        ]);

         $election->fill($request->all());
         unset($election->files);

        if ($election->update()) {
            Notify::success('Election event updated.', 'Success!');

            return redirect()->route('root.elections.index');
        }

        Notify::warning('Cannot update election event.', 'Failed');
        return redirect()->route('root.elections.index');
    }

    public function destroy(Request $request, Election $election)
    {
        // wag burahin, sayang ang memories!!!
    }

    /**
     * Show Set Control Numbers page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
     public function setControlNumbers(Request $request, Election $election)
     {
         $data = collect([]);

         $data->all_users = User::where('type', 'user')->count();

         $data->with = DB::table('election_control_numbers')
             ->where('election_uuid', $election->uuid)
             ->count();

         $data->without = $data->all_users - $data->with;

         return view('root.elections.control_numbers', compact(
             ['data', 'election']
         ));
     }

     /**
      * Store Control Numbers.
      * @param \Illuminate\Http\Request
      * @param \App\Election
      * @return \Illuminate\Http\RedirectResponse
      */
     public function storeControlNumbers(Request $request, Election $election)
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

    /**
     * Show Set Election Positions page.
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function setPositions(Election $election)
    {
        $positions = Position::all();

        $position_uuids = DB::table('election_position')
            ->where('election_uuid', $election->uuid)
            ->get()
            ->map(function($e) {
                return Election::decodeUuid($e->position_uuid);
            })
            ->all();

        return view('root.elections.positions', compact(
            ['position_uuids', 'positions', 'election']
        ));
    }

    /**
     * Store Election Positions.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePositions(Request $request, Election $election)
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

    /**
     * Show Set Candidate Page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function setCandidate(Request $request, Election $election)
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

        return view('root.elections.candidates', compact(
            ['election', 'users', 'allUserCount']
        ));
    }

    /**
     * Nominate.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCandidate(Request $request, Election $election)
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

    /**
     * Show Tally page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
     */
    public function showTally(Request $request, Election $election)
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

        foreach ($election_votes as $vote) {
            $archives[$vote->position->uuid]['votes'][] = $vote;
            $archives[$vote->position->uuid]['position'] = $vote->position;
        }

        if ($position = $request->get('position')) {
            $archive = $archives[Position::encodeUuid($position)];
            $archives = [$archive];
        }

        return view('root.elections.tally', compact(['election', 'archives']));
    }

    /**
     * Generate Results.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateResults(Request $request, Election $election)
    {
        $file_name = $request->input('file_name');
        $file_type = $request->input('file_type');
        $heading = "{$election->name} Results";

        try {
            $archives = $this->getArchives($election);

            switch (strtolower($file_type)) {
                case 'pdf':
                    return $this->exportResultsAsPdf(
                        $archives, $file_name, $heading
                    );
                break;

                case 'excel':

                break;

                case 'csv':

                break;
            }

            throw new Exception('Error generating results');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Error!');
        }

        return back();
    }

    /**
     * Produce a data set for result generation.
     * @param \App\Election
     * @return array
     */
    protected function getArchives(Election $election)
    {
        // position, candidate, votes.
        return DB::table('election_votes')
            ->select(
                'position_uuid as position',
                'candidate_uuid as candidate',
                DB::raw('COUNT(*) as votes')
            )
            ->where('election_uuid', $election->uuid)
            ->groupBy('candidate')
            ->get()
            ->sortByDesc('votes')
            ->unique('position')
            ->map(function ($value, $key) {
                $position = Position::find($value->position);
                $value->position = $position->name;
                $value->level = $position->level;
                $value->candidate = User::find($value->candidate)->full_name_formal;

                return $value;
            })
            ->sortBy('level')
            ->each(function ($item, $key) {
                unset($item->level);

                return $item;
            })
            ->values()
            ->all();
    }

    /**
     * Export Results as PDF
     * @param array
     * @return PDF
     */
    protected function exportResultsAsPdf(
        array $archives, string $file_name, string $heading
    ) {
        $pdf = PDF::loadView('root.elections.results.pdf', compact(
                ['archives', 'heading']
            ))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 150]);

        return $pdf->download($file_name.'.pdf');
    }
}