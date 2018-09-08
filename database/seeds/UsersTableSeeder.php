<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'type' => 'admin',
            'username' => 'master',
            'email' => 'master@example.com',
            'password' => bcrypt('master'),
            'verified' => 1,

            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
    }
}
