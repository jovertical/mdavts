<?php

use Illuminate\Support\Facades\DB;
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
            DB::table('grades')->insert([
                'id' => ($id + 1),
                'level' => $level,
                'description' => "Grade Level {$level}"
            ]);
        }
    }
}
