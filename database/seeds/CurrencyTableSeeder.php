<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
            'currency_name' => 'UAH',
            'currency_sign' => '&#8372;',
            'currency_main' => TRUE
        ]);

        DB::table('currency')->insert([
            'currency_name' => 'USD',
            'currency_sign' => '$',
            'currency_main' => FALSE
        ]);
        
        DB::table('currency')->insert([
            'currency_name' => 'EUR',
            'currency_sign' => '&euro;',
            'currency_main' => FALSE
        ]);
    }
}
