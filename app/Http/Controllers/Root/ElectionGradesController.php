<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{Election, Grade};

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionGradesController extends Controller
{
    /**
     * Show Set Election Grades page.
     * @param \App\Election
     * @return \Illuminate\View\View/\Illuminate\Http\RedirectResponse
     */
    public function showGradesPage(Election $election)
    {
        // add a check to prevent further modifications.
        if (in_array($election->status, ['active', 'ended', 'closed'])) {
            Notify::warning("The election is already {$election->status}.");

            return back();
        }

        $grades = Grade::all();

        $grade_ids = DB::table('election_grades')
            ->where('election_id', $election->id)
            ->get()
            ->map(function($e) {
                return $e->grade_id;
            })
            ->all();

        return view('root.elections.election.grades', compact(
            ['grade_ids', 'grades', 'election']
        ));
    }

    /**
     * Store Election Grades.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Election $election)
    {
        $grade_ids = $request->input('grades') ?? [];

        DB::table('election_grades')
            ->where('election_id', $election->id)
            ->delete();

        foreach ($grade_ids as $grade_id) {
            DB::table('election_grades')->insert([
                'election_id' => $election->id,
                'grade_id' => $grade_id
            ]);
        }

        Notify::success('Election Grades stored.');

        return back();
    }
}