<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{Grade, Section};

/**
 * Laravel
 */
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
{
    /**
     * Show index page.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $sections = Section::all();

        return view('root.sections.index', compact('sections'));
    }

    /**
     * Show resource creation page.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $grades = Grade::orderBy('level')->get();

        return view('root.sections.create', compact('grades'));
    }

    /**
     * Store resource.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'grade' => 'required',
            'name' => 'required'
        ]);

        $section = new Section;
        $section->grade_uuid = Grade::encodeUuid($request->input('grade'));
        $section->name = $request->input('name');
        $section->description = $request->input('description');

        if ($section->save()) {
            Notify::success('Section created.', 'Success!');

            return redirect()->route('root.sections.index');
        }

        Notify::warning('Failed to create a section.', 'Warning!');

        return redirect()->route('root.sections.index');
    }

    /**
     * Show resource edit page.
     * @param \Illuminate\Http\Request
     * @param \App\Section
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Section $section)
    {
        $grades = Grade::orderBy('level')->get();

        return view('root.sections.edit', compact(['grades', 'section']));
    }

    /**
     * Update resource.
     * @param \Illuminate\Http\Request
     * @param \App\Section
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Section $section)
    {
        $request->validate([
            'grade' => 'required',
            'name' => 'required'
        ]);

        $section->grade_uuid = Grade::encodeUuid($request->input('grade'));
        $section->name = $request->input('name');
        $section->description = $request->input('description');

        if ($section->update()) {
            Notify::success('Section updated.', 'Success!');

            return redirect()->route('root.sections.index');
        }

        Notify::warning('Failed to update section.', 'Warning!');

        return redirect()->route('root.sections.index');
    }

    /**
     * Destroy resource.
     * @param \Illuminate\Http\Request
     * @param \App\Section
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Section $section)
    {
        if ($section->delete()) {
            Notify::success('Section deleted.', 'Success!');

            return redirect()->route('root.sections.index');
        }

        Notify::warning('Cannot delete section.', 'Warning!');

        return redirect()->route('root.sections.index');
    }
}