<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Position::create([
            'name' => 'President',
        ]);

        \App\Position::create([
            'name' => 'Vice President',
        ]);

        \App\Position::create([
            'name' => 'Secretary',
        ]);

        \App\Position::create([
            'name' => 'PRO',
        ]);

        \App\Position::create([
            'name' => 'Auditor',
        ]);
    }
}
