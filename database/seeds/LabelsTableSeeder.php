<?php

use Illuminate\Database\Seeder;

class LabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labels')->insert([
            'label_color' => 'green'
        ]);

        DB::table('labels')->insert([
            'label_color' => 'yellow'
        ]);

        DB::table('labels')->insert([
            'label_color' => 'orange'
        ]);

        DB::table('labels')->insert([
            'label_color' => 'red'
        ]);

        DB::table('labels')->insert([
            'label_color' => 'blue'
        ]);
    }
}
