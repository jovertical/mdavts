<?php

namespace App\Http\Controllers\Root\Auth;

use Notify;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        $password_reset = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (empty($password_reset)) {
            $errors[] = 'Link provided is invalid. Please try requesting for a new link.';
        }

        $time_passed = \Carbon\Carbon::parse(
            optional($password_reset)->created_at
        )->diffInSeconds(now());

        // token expiry of 60 seconds
        if ($time_passed > 3600) {
            // delete the password reset from db.
            DB::table('password_resets')
                ->where('email', $password_reset->email)
                ->delete();

            $errors[] = 'Token expired. Please try requesting for a new link.';
        }

        if (count($errors ?? [])) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => $errors[0]
            ]);

            return redirect()->route('root.auth.password.request');
        }

        return view('root.auth.passwords.reset', compact('token'));
    }

    public function reset(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6|max:255|pwned:100'
        ]);

        $password_reset = DB::table('password_resets')->where('token', $token)->first();
        $admin = User::where('email', $password_reset->email)->first();
        $admin->password = bcrypt($request->input('password'));

        if (! $admin->save()) {
            session()->flash('message', [
                'type' => 'warning',
                'title' => 'Warning!',
                'content' => 'We cannot reset your password. Please try again.'
            ]);

            return back();
        }

        // Delete password request.
        DB::table('password_resets')->where('token', $token)->delete();

        // Authenticate.
        Auth::loginUsingId($admin->uuid);

        Notify::success(greet(), '');

        return redirect()->route('root.dashboard');
    }
}
