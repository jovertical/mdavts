<?php

namespace App\Http\Controllers\Root;

use App\Services\{Notify};
use App\{Grades};
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradesController extends Controller
{
    public function index()
    {
        $grades = Grades::get();

        return view('root.grades.index', compact('grades'));
    }

    public function create()
    {
        $grades = Grades::get();

        return view('root.grades.create', compact('grades'));
    }

    public function store(Request $request, Grades $grades)
    {
         $request->validate([
             'level' => 'required',
             'description' => 'required'
         ]);

         $grades->fill($request->all());

         if ($grades->save()) {
             Notify::success('Grades created.', 'Success!');

             return redirect()->route('root.grades.index');
         }

         Notify::warning('Failed to create a grades.', 'Warning!');

         return redirect()->route('root.grades.index');
     }


        public function destroy(Request $request, Grades $grade)
        {
            if ($grade->delete()) {
                Notify::success('Year Level deleted.', 'Success!');

                return redirect()->route('root.grades.index');
            }

            Notify::warning('Cannot delete Year Level.', 'Warning!');

            return redirect()->route('root.grades.index');
        }

        public function edit(Request $request, Grades $grade)
        {
            return view('root.grades.edit', compact('grade'));
        }

        public function update(Request $request, Grades $grade)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'optional',
        ]);

         $grade->fill($request->all());
         unset($grade->files);

        if ($grade->update()) {
            Notify::success('Grades Level updated.', 'Success!');

            return redirect()->route('root.grades.index');
        }
            Notify::warning('Cannot update grades level.', 'Failed');
            return redirect()->route('root.grades.index');
    }

}
