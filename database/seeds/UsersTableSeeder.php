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
            'username' => 'master',
            'email' => 'master@example.com',
            'password' => bcrypt('master'),
            'verified' => 1,
            'type' => 'admin',
        ]);

        \App\User::create([
            'verified' => 1,
            'type' => 'user',

            'lrn' => '2014-00345-SM-0',
            'grade_level' => 5,
            'section' => 'Kind',

            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
    }
}
