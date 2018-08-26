<?php

namespace App\Http\Controllers\Root;

use App\Services\Notify;
use App\{Sections};
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
{
    public function index()
    {
        $section = Sections::get();

        return view('root.sections.index', compact('section'));
    }

    public function create()
    {
        $section = Sections::get();

        return view('root.sections.create', compact('section'));
    }

    public function store(Request $request, Sections $section)
    {
         $request->validate([
             'year_level' => 'required',
             'name' => 'required',
             'description' => 'required'   
         ]);
 
         $section->fill($request->all());
 
         if ($section->save()) {
             Notify::success('Section created.', 'Success!');
 
             return redirect()->route('root.sections.index');
         }
 
         Notify::warning('Failed to create a section.', 'Warning!');
 
         return redirect()->route('root.sections.index');
     }

   
        public function destroy(Request $request, Sections $section)
        {
            if ($section->delete()) {
                Notify::success('Section deleted.', 'Success!');
    
                return redirect()->route('root.sections.index');
            }
    
            Notify::warning('Cannot delete section.', 'Warning!');
    
            return redirect()->route('root.sections.index');
        }
     
        public function edit(Request $request, Sections $section)
        {
            return view('root.sections.edit', compact('section'));
        }

        public function update(Request $request, Sections $section)
    {

        $request->validate([
            'year_level' => 'required',
            'name' => 'required',
            'description' => 'optional',
        ]);

         $section->fill($request->all());
         unset($section->files);

        if ($section->update()) {
            Notify::success('Grades Level updated.', 'Success!');

            return redirect()->route('root.sections.index');
        }
            Notify::warning('Cannot update section.', 'Failed');
            return redirect()->route('root.sections.index');
    }
}