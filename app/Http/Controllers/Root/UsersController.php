<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Services\{ImageUploader, Notify};
use App\{User, Grade, Section, Election};

/**
 * Laravel
 */
use DB, Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Show index page.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $users = User::where('type', 'user')->get();

        return view('root.users.index', compact('users'));
    }

    /**
     * Show resource creation page.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $grades = Grade::orderBy('level')->get();

        return view('root.users.create', compact('grades'));
    }

    /**
     * Store resource.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'grade' => 'required'
        ]);

        $user = new User;
        $user->type = 'user';
        $user->username = create_username($request->post('firstname'));

        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->contact_number = $request->input('contact_number');

        $user->lrn = $request->input('lrn');

        $user->grade_id = ! empty($grade = $request->get('grade'))
            ? $grade : null;
        $user->section_id = ! empty($section = $request->get('section'))
            ? $section : null;

        if ($request->hasFile('image')) {
            $upload = ImageUploader::upload(
                $request->file('image'), 'users/'.$user->id
            );

            if (count($upload)) {
                $user->path = $upload['path'];
                $user->directory = $upload['directory'];
                $user->filename = $upload['filename'];
            }
        }

        if ($user->save()) {
            Notify::success('User created.', 'Success!');

            return redirect()->route('root.users.index');
        }

        Notify::warning('Failed to create a user.', 'Warning!');

        return redirect()->route('root.users.index');
    }

    /**
     * Show resource edit page.
     * @param \Illuminate\Http\Request
     * @param \App\User
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, User $user)
    {
        $grades = Grade::orderBy('level')->get();

       return view('root.users.edit', compact(['user', 'grades']));
    }

    /**
     * Update resource.
     * @param \Illuminate\Http\Request
     * @param \App\User
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'grade' => 'required'
        ]);

        $user->type = 'user';
        $user->username = create_username($request->post('firstname'));

        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->contact_number = $request->input('contact_number');

        $user->lrn = $request->input('lrn');

        $user->grade_id = ! empty($grade = $request->get('grade')) 
            ? $grade : null;
        $user->section_id = ! empty($section = $request->get('section')) 
            ? $section : null;

        if ($request->hasFile('image')) {
            $upload = ImageUploader::upload(
                $request->file('image'), 'users/'.$user->id
            );

            if (count($upload)) {
                $user->path = $upload['path'];
                $user->directory = $upload['directory'];
                $user->filename = $upload['filename'];
            }
        }

        if ($user->update()) {
            Notify::success('User updated.', 'Success!');

            return redirect()->route('root.users.index');
        }

        Notify::warning('Failed to update user.', 'Warning!');

        return redirect()->route('root.users.index');
    }

    /**
     * Destroy resource.
     * @param \Illuminate\Http\Request
     * @param \App\User
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->delete()) {
            Notify::success('User deleted.', 'Success!');

            return redirect()->route('root.users.index');
        }

        Notify::warning('Cannot delete user.', 'Warning!');

        return redirect()->route('root.users.index');
    }

    /**
     * Show control numbers page.
     * @param \App\User
     * @return \Illuminate\View\View
     */
    public function showControlNumbers(User $user)
    {
        $control_numbers = DB::table('election_control_numbers as ecn')
            ->where('voter_id', $user->id)
            ->get();

        $control_numbers->each(function($number) use ($control_numbers) {
            $number->election = Election::find($number->election_id);
        });

        return view('root.users.control_numbers', compact(
            ['user', 'control_numbers']
        ));
    }
}
