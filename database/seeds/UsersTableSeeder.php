<?php

use App\User;
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
        User::create([
            'type' => 'admin',
            'username' => 'jericho',
            'email' => 'jericho@example.com',
            'password' => bcrypt('mdavts'),
            'verified' => 1,

            'firstname' => 'Jericho',
            'middlename' => null,
            'lastname' => 'Torres',
            'birthdate' => '1997-09-22',
            'gender' => 'male',
            'address' => 'Guyong, Sta Maria, Bulacan',

            'path' => null,
            'directory' => 'app/images/mates',
            'filename' => 'jericho_torres.jpg',
        ]);

        User::create([
            'type' => 'admin',
            'username' => 'bryan',
            'email' => 'bryan@example.com',
            'password' => bcrypt('mdavts'),
            'verified' => 1,

            'firstname' => 'Bryan',
            'middlename' => null,
            'lastname' => 'Eduria',
            'birthdate' => '1997-01-11',
            'gender' => 'male',
            'address' => 'Guyong, Sta Maria, Bulacan',

            'path' => null,
            'directory' => 'app/images/mates',
            'filename' => 'bryan_eduria.jpg',
        ]);

        User::create([
            'type' => 'admin',
            'username' => 'christian',
            'email' => 'christian@example.com',
            'password' => bcrypt('mdavts'),
            'verified' => 1,

            'firstname' => 'Christian',
            'middlename' => 'Venancio',
            'lastname' => 'Reyes',
            'birthdate' => '1997-10-21',
            'gender' => 'male',
            'address' => 'Sta Cruz, Sta Maria, Bulacan',

            'path' => null,
            'directory' => 'app/images/mates',
            'filename' => 'christian_reyes.jpg',
        ]);

        User::create([
            'type' => 'admin',
            'username' => 'erica',
            'email' => 'erica@example.com',
            'password' => bcrypt('mdavts'),
            'verified' => 1,

            'firstname' => 'Erica Mae',
            'middlename' => null,
            'lastname' => 'Garrido',
            'birthdate' => null,
            'gender' => 'female',
            'address' => 'Sta Maria, Bulacan',

            'path' => null,
            'directory' => 'app/images/mates',
            'filename' => 'erica_garrido.jpg',
        ]);
    }
}
