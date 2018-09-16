<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\Notify;
use App\Election;

/**
 * Laravel
 */
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

            return redirect()->route('root.elections.dashboard', $election);
        }

        Notify::warning('Cannot create the election.', 'Warning!');

        return redirect()->route('root.elections.index');
    }

    /**
     * Show resource edit page.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\View\View
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
}