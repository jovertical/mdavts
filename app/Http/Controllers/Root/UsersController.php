<?php

namespace App\Http\Controllers\Root;

use Notify;
use Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
   
    public function index()
    {
        $users = User::where('type', '!=', 'admin')->get();

        
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

    public function edit() 
    {
       return view('root.candidates.edit');
    }

    public function update()
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
}
