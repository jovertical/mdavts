<?php

use Illuminate\Database\Seeder;

class PartyListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\PartyList::create([
            'name' => 'Independent',
        ]);
    }
}
