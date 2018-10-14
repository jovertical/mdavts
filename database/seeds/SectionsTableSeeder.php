<?php

use App\{ Section };
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gradeSection = [
            1 => [
                "Help of the Afflicted", "Mother of Sorrows",
            ],
            2 => [
                "Our Lady of Charity","Our Lady of Grace",
            ],
            3 => [
                "Our Lady of Light","Our Lady of Providence",
            ],
            4 => [
                "Our Lady of Ransom","Our Lady of Solitude",
            ],
            5 => [
                "Our Lady, Star of the Sea","Our Lady of Vallarpadam",
            ],
            6 => [
                "Queen of All Saints","Queen of the Angels",
            ],
            7 => [
                "Queen of Apostles","Queen of Confessors",
            ],
            8 => [
                "Queen of Families","Queen of Martyrs",
            ],
            9 => [
                "Queen of Patriarchs","Queen of Prophets",
            ],
            10 => [
                "Queen of Virgins","Queen of the World",
            ],
            11 => [
                "Tower of David","Untier of Knots",
            ],
            12 => [
                "Holy Virgin of Virgins","Immaculate Heart of Mary","Morning Star",
            ]
        ];

        foreach ($gradeSection as $grade => $sections) {
            foreach ($sections as $section) {
                Section::create([
                    'grade_id' => $grade,
                    'name' => $section
                ]);
            }
        }
    }
}
