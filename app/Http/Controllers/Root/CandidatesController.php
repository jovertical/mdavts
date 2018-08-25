<?php

namespace App\Http\Controllers\Root;

use Notify;
use App\Candidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CandidatesController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();

        return view('root.candidates.index', compact('candidates'));
    }    

    public function create()
    {
        return view('root.candidates.create');
    }

    public function store(Request $request, Candidate $candidate)
   {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'grade_level' => 'required',
            
        ]);

        $candidate->fill($request->all());

        if ($candidate->save()) {
            Notify::success('Candidate created.', 'Success!');

            return redirect()->route('root.candidates.index');
        }

        Notify::warning('Failed to create a candidate.', 'Warning!');

        return redirect()->route('root.candidates.index');
    }

    public function edit(Request $request, Candidate $candidate)
    {
        return view('root.candidates.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'grade_level' => 'required',
            
        ]);

        $candidate->fill($request->all());

        if ($candidate->update()) {
            Notify::success('Candidate updated.', 'Success!');

            return redirect()->route('root.candidates.index');
        }

        Notify::warning('Failed to update a candidate.', 'Warning!');

        return redirect()->route('root.candidates.index');
    }

    public function destroy(Request $request, Candidate $candidate)
    {
        if ($candidate->delete()) {
            Notify::success('Candidate deleted.', 'Success!');

            return redirect()->route('root.candidates.index');
        }

        Notify::warning('Cannot delete candidate.', 'Warning!');

        return redirect()->route('root.candidates.index');
    }
}
