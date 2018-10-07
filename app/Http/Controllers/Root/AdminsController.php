<?php

namespace App\Http\Controllers\Root;

use App\Services\{ImageUploader, Notify};
use App\Notifications\{AccountVerification};
use App\{User};
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    public function index()
    {
        $admins = User::where('type', 'admin')->get();

        return view('root.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('root.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,deleted_at,null',
        ]);

        $admin = new User;

        $admin->type = 'admin';
        $admin->email = $request->input('email');
        $admin->username = empty($username = $request->input('username'))
            ? create_username($request->post('firstname'))
            : $username;
        $admin->contact_number = $request->input('contact_number');

        $admin->firstname = $request->input('firstname');
        $admin->middlename = $request->input('middlename');
        $admin->lastname = $request->input('lastname');
        $admin->birthdate = $request->input('birthdate');
        $admin->gender = $request->input('gender');
        $admin->address = $request->input('address');

        if ($request->hasFile('image')) {
            $upload = ImageUploader::upload(
                $request->file('image'), 'admins/'.$admin->id
            );

            if (count($upload)) {
                $admin->path = $upload['path'];
                $admin->directory = $upload['directory'];
                $admin->filename = $upload['filename'];
            }
        }

        if ($admin->save()) {
            $token = create_token();

            // store account verification.
            $this->storeAccountVerification($admin, $token);

            // send account verification email.
            $admin->notify(
                new AccountVerification(route('root.auth.verify.check', $token))
            );

            Notify::success('Admin created.', 'Success!');

            return redirect()->route('root.admins.index');
        }

        Notify::warning('Cannot create admin.', 'Warning!');

        return redirect()->route('root.admins.index');
    }

    public function edit(Request $request, User $admin)
    {
        return view('root.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
        ]);

        $admin->email = $request->input('email');
        $admin->username = empty($username = $request->input('username'))
            ? create_username($request->post('firstname'))
            : $username;
        $admin->contact_number = $request->input('contact_number');

        $admin->firstname = $request->input('firstname');
        $admin->middlename = $request->input('middlename');
        $admin->lastname = $request->input('lastname');
        $admin->birthdate = $request->input('birthdate');
        $admin->gender = $request->input('gender');
        $admin->address = $request->input('address');

        if ($request->hasFile('image')) {
            $upload = ImageUploader::upload(
                $request->file('image'), 'admins/'.$admin->id
            );

            if (count($upload)) {
                $admin->path = $upload['path'];
                $admin->directory = $upload['directory'];
                $admin->filename = $upload['filename'];
            }
        }

        if ($admin->update()) {
            Notify::success('Admin updated.', 'Success!');

            return redirect()->route('root.admins.index');
        }

        Notify::warning('Cannot update admin.', 'Failed');

        return redirect()->route('root.admins.index');
    }

    public function destroy(Request $request, User $admin)
    {
        // wag burahin, sayang ang memories XD
    }

    protected function storeAccountVerification(User $admin, $token)
    {
        DB::table('account_verifications')->where('email', $admin->email)->delete();

        return DB::table('account_verifications')->insert([
            'email' => $admin->email,
            'token' => $token,
            'created_at' => now()
        ]);
    }
}
