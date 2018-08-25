<?php

namespace App\Http\Controllers\Root\Auth;

use Notify;
use App\Notifications\{AccountVerification};
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountVerificationController extends Controller
{
    /**
     * Show Account Verification form
     *
     * @return null
     */
    public function showVerificationForm()
    {
        return view('root.auth.verify.request');
    }

    /**
     *
     * @param Illuminate\Http\Request
     * @return null
     */
    public function sendVerificationLink(Request $request)
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

        // store account verification.
        $this->storeAccountVerification($admin, $token);

        // send account verification email.
        $admin->notify(
            new AccountVerification(route('root.auth.verify.check', $token))
        );

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Success!',
            'content' => 'Account verification link has been sent to your email.'
        ]);

        return back();
    }

    /**
     * Verify user.
     *
     * @param Illuminate\Http\Request
     * @param string
     * @return null
     */
    public function check(Request $request, $token)
    {
        $account_verification = DB::table('account_verifications')
            ->where('token', $token)
            ->first();

        $email = optional($account_verification)->email;
        $admin = User::where('email', $email)->first();

        if (empty($account_verification)) {
            $errors[] = 'Invalid url.';
        }

        if (empty($admin)) {
            $errors[] = 'Admin does not exist';
        }

        if (count($errors ?? [])) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => $errors[0]
            ]);

            return redirect()->route('root.auth.signin');
        }

        // If the admin does not have a password, redirect to set password page.
        if (empty($admin->password)) {
            session()->flash('message', [
                'type' => 'info',
                'title' => 'Info!',
                'content' => 'You need to set your account`s password.'
            ]);

            return redirect()->route('root.auth.password.set', $token);
        }

        $admin->verified = 1;

        if (! $admin->save()) {
            session()->flash('message', [
                'type' => 'danger',
                'title' => 'Error!',
                'content' => 'Cannot verify account.'
            ]);

            return redirect()->route('root.auth.verify.request');
        }

        // delete existing account verification from db.
        DB::table('account_verifications')->where('token', $token)->delete();

        Notify::success('Account verified.', 'Success!');

        return redirect()->route('root.dashboard');
    }

    /**
     *
     * @param App\User
     * @param string
     * @return Collection
     */
    protected function storeAccountVerification(User $admin, $token)
    {
        $email = $admin->email;
        $created_at = now();

        DB::table('account_verifications')->where('email', $email)->delete();

        return DB::table('account_verifications')->insert(compact([
            'email', 'token', 'created_at'
        ]));
    }
}