<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{Notify};
use App\{Grade};

/**
 * Laravel
 */
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradesController extends Controller
{
    /**
     * Show index page.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $grades = Grade::orderBy('level')->get();

        return view('root.grades.index', compact('grades'));
    }

    /**
     * Show resource creation page.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('root.grades.create');
    }

    /**
     * Store resource.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
         $request->validate([
            'level' => 'required|integer|unique:grades,level,NULL,uuid,deleted_at,NULL'
         ]);

         $grade = new Grade;
         $grade->level = $request->input('level');
         $grade->description = $request->input('description');

         if ($grade->save()) {
             Notify::success('Grade created.', 'Success!');

             return redirect()->route('root.grades.index');
         }

         Notify::warning('Failed to create a grade.', 'Warning!');

         return redirect()->route('root.grades.index');
    }

    /**
     * Show resource edit page.
     * @param \Illuminate\Http\Request
     * @param \App\Grade
     */
    public function edit(Request $request, Grade $grade)
    {
        return view('root.grades.edit', compact('grade'));
    }

    /**
     * Update resource.
     * @param \Illuminate\Http\Request
     * @param \App\Section
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'level' => "required|integer|unique:grades,level,{$grade->uuid},uuid,deleted_at,NULL"
        ]);

        $grade->level = $request->input('level');
        $grade->description = $request->input('description');

        if ($grade->update()) {
            Notify::success('Grades Level updated.', 'Success!');

            return redirect()->route('root.grades.index');
        }

        Notify::warning('Cannot update grades level.', 'Warning!');

        return redirect()->route('root.grades.index');
    }

    /**
     * Destroy resource.
     * @param \Illuminate\Http\Request
     * @param \App\Grade
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Grade $grade)
    {
        if ($grade->delete()) {
            Notify::success('Year Level deleted.', 'Success!');

            return redirect()->route('root.grades.index');
        }

        Notify::warning('Cannot delete Year Level.', 'Warning!');

        return redirect()->route('root.grades.index');
    }
}