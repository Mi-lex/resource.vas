<?php

use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drivers = [
            [
                'name' => 'mercury_230',
                'russ_name' => "Меркурий 230"
                // 2 - 8
            ],
            [
                'name' => 'impis_12',
                'russ_name' => "Импис 12"
                // 19, 20, 21 - пока не работают
            ],
            [
                'name' => 'logika_941',
                'russ_name' => "Логика 941"
            ],
            [
                'name' => 'oven_si8',
                'russ_name' => "Овен си8"
                // 9
            ],
            [
                'name' => 'pulsar_2m',
                'russ_name' => "Пульсар 2м"
                // 23, 25
            ],
            [
                'name' => 'logika_943',
                'russ_name' => "Логика 943"
            ],
            [
                'name' => 'oven_si30',
                'russ_name' => "Овен си30"
            ],
        ];

        foreach ($drivers as $driver) {
            DB::table('drivers')->insert($driver);
        }
    }
}
