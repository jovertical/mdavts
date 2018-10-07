<?php

namespace App\Http\Controllers\Root;

use Notify;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function profile()
    {
        $admin = auth()->user();
        
        return view('root.account.profile', [
            'admin' => $admin
        ]);
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'email' => "required|email|unique:users,email,{$admin->id},id",
        ]);

        $admin->fill($request->all());

        if ($admin->update()) {
            Notify::success('Profile updated.', 'Success!');

            return redirect()->route('root.account.profile');
        }
            Notify::warning('Cannot update profile.', 'Failed');
            return redirect()->route('root.account.profile');
    }

    public function password(Request $request)
    {
        return view('root.account.password');



    }

    public function updatePassword(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
           'old_password' => 'required|min:6',
           'password' => 'required|min:6|confirmed',
        ]);

        if (! Hash::check($request->post('old_password'), $admin->password)) {
            Notify::warning('Old password entered is wrong.', 'Failed');

            return redirect()->route('root.account.password');
        }

        $admin->password = bcrypt($request->post('password'));

        if ($admin->update()) {
            Notify::success('Password updated.', 'Success!');

            return redirect()->route('root.account.password');
        }

        Notify::warning('Cannot update password.', 'Failed');
        return redirect()->route('root.account.password');
    }


}
