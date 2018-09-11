<?php

namespace App\Http\Controllers\Root\Auth;

use Notify;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{
    public function showSigninForm()
    {
        return view('root.auth.signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'username'  => 'required|string',
            'password'  => 'required|string|min:6'
        ]);

        if ($this->attempt($request)) {
            $request->session()->regenerate();

            Notify::success(greet(), '');

            return redirect()->route('root.dashboard');
        }

        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')]
        ]);

        return back();
    }

    protected function attempt(Request $request)
    {
        $username = filter_var(
            $request->input('username'), FILTER_VALIDATE_EMAIL
        ) ? 'email' : 'username';

        return  Auth::attempt([
                $username   => $request->input('username'),
                'password'  => $request->input('password'),
                'verified'  => 1,
                'active'    => 1,
                'type'      => 'admin'
            ], $request->filled('remember'));
    }

    /**
     * Try Signing-out from the application.
     * @param  Request $request
     * @return redirect
     */
    public function signout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('root.auth.signin');
    }
}
