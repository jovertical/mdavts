<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'elec_auto_update' => 1,
        ];

        foreach ($settings as $name => $value) {
            DB::table('settings')->insert([
                'name' => $name,
                'value' => $value
            ]);
        }
    }
}
