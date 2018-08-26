<?php

namespace App\Http\Controllers\Root;

use Notify;
use DB, Hash;
use App\{User, Election};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $users = User::where('type', 'user')->get();

        return view('root.users.index', compact('users'));
    }

    public function create()
    {
        return view('root.users.create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $user = new User;
        $user->fill($request->all());
        $user->username = create_username($request->post('firstname'));

        if ($user->save()) {
            Notify::success('User created.', 'Success!');

            return redirect()->route('root.users.index');
        }

        Notify::warning('Failed to create a user.', 'Warning!');

        return redirect()->route('root.users.index');
    }

    public function edit(Request $request, User $user)
    {
       return view('root.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $user->fill($request->all());
        $user->username = create_username($request->post('firstname'));


        if ($user->save()) {
            Notify::success('User created.', 'Success!');

            return redirect()->route('root.users.index');
        }

        Notify::warning('Failed to create a user.', 'Warning!');

        return redirect()->route('root.users.index');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->delete()) {
            Notify::success('User deleted.', 'Success!');

            return redirect()->route('root.users.index');
        }

        Notify::warning('Cannot delete user.', 'Warning!');

        return redirect()->route('root.users.index');
    }

    public function showControlNumbers(User $user)
    {
        $control_numbers = DB::table('election_control_numbers as ecn')
            ->where('user_uuid', $user->uuid)
            ->get();

        $control_numbers->each(function($number) use ($control_numbers) {
            $number->election = Election::find($number->election_uuid)->first();
        });

        return view('root.users.control_numbers', compact(
            ['user', 'control_numbers']
        ));
    }
}
