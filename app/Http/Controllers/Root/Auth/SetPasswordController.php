<?php

namespace App\Http\Controllers\Root\Auth;

use Notify;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SetPasswordController extends Controller
{
    /**
     * Show set password form page.
     *
     * @param Illuminate\Http\Request
     * @param string
     * @return null
     */
    public function showSetForm(Request $request, $token)
    {
        $account_verification = $this->getAccountVerification($token);
        $email = optional($account_verification)->email;

        $admin = User::where('email', $email)
            ->where('password', '!=', null)
            ->where('verified', 0)
            ->first();

        if (! empty($admin)) {
            session()->flash('message', [
                'type' => 'warning',
                'title' => 'Warning!',
                'content' => 'That account is already verified. Signin to check.'
            ]);

            return redirect()->route('root.auth.signin');
        }

        return view('root.auth.passwords.set', compact('token'));
    }

    /**
     * Set the password for the user.
     *
     * @param Illuminate\Http\Request
     * @param string
     * @return null
     */
    public function set(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed|pwned:100'
        ]);

        $account_verification = $this->getAccountVerification($token);
        $email = optional($account_verification)->email;

        $admin = User::where('type', 'admin')
            ->where('email', $email)
            ->first();

        $admin->password = bcrypt($request->input('password'));
        $admin->verified = 1;

        if (! $admin->save()) {
            Notify::warning('Cannot setup a password.', 'Warning!');

            return redirect()->route('root.auth.login');
        }

        // authenticate.
        Auth::loginUsingId($admin->uuid);

        Notify::success('Password created.', 'Success!');

        return redirect()->route('root.dashboard');
    }

    /**
     *
     * @param string
     * @return Collection
     */
    protected function getAccountVerification($token)
    {
        return DB::table('account_verifications')
            ->where('token', $token)
            ->first();
    }
}