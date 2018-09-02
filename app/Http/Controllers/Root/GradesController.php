<?php

namespace App\Http\Controllers\Root;

use App\Services\{Notify};
use App\{Grade};
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradesController extends Controller
{
    public function index()
    {
        $grade = Grade::get();

        return view('root.grades.index', compact('grade'));
    }

    public function create()
    {
        $grade = Grade::get();

        return view('root.grades.create', compact('grade'));
    }

    public function store(Request $request, Grade $grade)
    {
         $request->validate([
             'level' => 'required',
             'description' => 'required'
         ]);

         $grade->fill($request->all());

         if ($grade->save()) {
             Notify::success('Grades created.', 'Success!');

             return redirect()->route('root.grades.index');
         }

         Notify::warning('Failed to create a grades.', 'Warning!');

         return redirect()->route('root.grades.index');
     }


        public function destroy(Request $request, Grade $grade)
        {
            if ($grade->delete()) {
                Notify::success('Year Level deleted.', 'Success!');

                return redirect()->route('root.grades.index');
            }

            Notify::warning('Cannot delete Year Level.', 'Warning!');

            return redirect()->route('root.grades.index');
        }

        public function edit(Request $request, Grade $grade)
        {
            return view('root.grades.edit', compact('grade'));
        }

        public function update(Request $request, Grade $grade)
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
