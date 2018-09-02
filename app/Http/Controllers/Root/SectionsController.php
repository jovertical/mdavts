<?php

namespace App\Http\Controllers\Root;

use App\Services\Notify;
use App\{Section};
use App\{Grade};
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
{
    public function index()
    {
        $sections = Section::get();

        return view('root.sections.index', compact('sections'));
    }

    public function create()
    {
        $sections = Section::get();

        $grades = Grade::get();

        return view('root.sections.create', compact(['sections', 'grades']));
    }

    public function store(Request $request, Section $sections)
    {

       
         $request->validate([
            'grade' => 'required',
             'name' => 'required',
             'description' => 'required'   
         ]);
 
         $sections->fill($request->all());

         if ($sections->save()) {

           
             Notify::success('Section created.', 'Success!');
 
             return redirect()->route('root.sections.index');
         }
 
         Notify::warning('Failed to create a section.', 'Warning!');
 
         return redirect()->route('root.sections.index');
     }

   
        public function destroy(Request $request, Section $sections)
        {
            if ($sections->delete()) {
                Notify::success('Section deleted.', 'Success!');
    
                return redirect()->route('root.sections.index');
            }
    
            Notify::warning('Cannot delete section.', 'Warning!');
    
            return redirect()->route('root.sections.index');
        }
     
        public function edit(Request $request, Section $sections)
        {
            return view('root.sections.edit', compact('section'));
        }

        public function update(Request $request, Section $sections)
    {

        $request->validate([
            'year_level' => 'required',
            'name' => 'required',
            'description' => 'optional',
        ]);

         $sections->fill($request->all());
         unset($sections->files);

        if ($section->update()) {
            Notify::success('Grades Level updated.', 'Success!');

            return redirect()->route('root.sections.index');
        }
            Notify::warning('Cannot update section.', 'Failed');
            return redirect()->route('root.sections.index');
    }
}