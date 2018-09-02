<?php

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 12) as $level) {
            \App\Grade::create([
                'level' => $level,
                'description' => "Grade Level {$level}"
            ]);
        }
    }
}
