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
            'level' => 1,
        ]);

        \App\Position::create([
            'name' => 'Vice President',
            'level' => 2,
        ]);

        \App\Position::create([
            'name' => 'Secretary',
            'level' => 3,
        ]);
    }
}
