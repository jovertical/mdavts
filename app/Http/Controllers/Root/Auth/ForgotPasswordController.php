<?php

namespace App\Http\Controllers\Root\Auth;

use App\User;
use App\Notifications\ResetPasswordLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * Show the link request form.
     *
     * @return null
     */
    public function showLinkRequestForm()
    {
        return view('root.auth.passwords.request');
    }

    /**
     * We will send an email for the user to reset their password.
     *
     * @param Illuminate\Http\Request
     * @return null
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->input('email');
        $token = create_token();
        $url = route('root.auth.password.reset', $token);

        $admin = User::where('email', $email)->first();

        if (empty($admin)) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => 'We cannot process your request. Please try again.'
            ]);

            return back();
        }

        $this->storeResetToken($admin, $token);

        $admin->notify(new ResetPasswordLink($admin, $url));

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Success!',
            'content' => 'Password reset link has been sent to your email.'
        ]);

        return back();
    }

    /**
     * Store the reset token.
     *
     * @param App\User
     * @param string
     * @return bool
     */
    protected function storeResetToken(User $user, $token)
    {
        $email = $user->email;
        $created_at = now();

        DB::table('password_resets')->where('email', $email)->delete();

        return DB::table('password_resets')->insert(compact([
            'email', 'token', 'created_at'
        ]));
    }
}
