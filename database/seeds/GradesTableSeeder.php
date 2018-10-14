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
        foreach (range(1, 12) as $id => $level) {
            \App\Grade::create([
                'id' => $id,
                'level' => $level,
                'description' => "Grade Level {$level}"
            ]);
        }
    }
}
